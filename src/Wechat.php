<?php


namespace chenbo29\Tool;


use Exception;
use GuzzleHttp\Client;
use Redis;
use GuzzleHttp\Exception\GuzzleException;

class Wechat
{
    private $url;
    private $redis;
    private $appId;
    private $appDebug;
    private $appSecret;
    private $jsApiList;
    private $shareInfoTitle;
    private $shareInfoDesc;
    private $shareInfoLink;
    private $shareInfoImgUrl;

    public function __construct(array $redisConf, array $conf)
    {
        $this->url       = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->appId     = $conf['app_id'];
        $this->appDebug  = $conf['app_debug'];
        $this->appSecret = $conf['app_secret'];
        $this->redis     = new Redis();
        $this->redis->connect($redisConf['host']);
        $this->jsApiList = ['updateAppMessageShareData', 'updateTimelineShareData', 'chooseWXPay'];
    }

    /**
     * @param string $shareInfoDesc
     */
    public function setShareInfoDesc(string $shareInfoDesc)
    {
        $this->shareInfoDesc = $shareInfoDesc;
    }

    /**
     * @param string $shareInfoImgUrl
     */
    public function setShareInfoImgUrl(string $shareInfoImgUrl)
    {
        $this->shareInfoImgUrl = $shareInfoImgUrl;
    }

    /**
     * @param string $shareInfoLink
     */
    public function setShareInfoLink(string $shareInfoLink)
    {
        $this->shareInfoLink = $shareInfoLink;
    }

    /**
     * @param string $shareInfoTitle
     */
    public function setShareInfoTitle(string $shareInfoTitle)
    {
        $this->shareInfoTitle = $shareInfoTitle;
    }

    /**
     * @param false $isRefresh
     * @return bool|mixed|string
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAccessToken($isRefresh = false)
    {
        if ($accessToken = $this->redis->exists('access_token') && $isRefresh === false) {
            return $this->redis->get('access_token');
        } else {
            $client   = new Client();
            $url      = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
            $response = $client->request('GET', sprintf($url, $this->appId, $this->appSecret));
            if ($response->getStatusCode() === 200) {
                $result = json_decode($response->getBody()->getContents(), true);
                if (isset($result['errcode'])) {
                    throw new Exception(print_r($result, true));
                } else {
                    $this->redis->set('access_token', $result['access_token'], $result['expires_in'] - 60);
                    return $result['access_token'];
                }
            } else {
                throw new Exception('获取access_token的http请求出现错误【' . $response->getBody()->getContents() . '】');
            }
        }
    }

    /**
     * @return bool|mixed|string
     * @throws GuzzleException
     * @throws Exception
     */
    private function getJsApiTicket()
    {
        if ($ticket = $this->redis->exists('js_api_ticket')) {
            return $this->redis->get('js_api_ticket');
        } else {
            $client   = new Client();
            $response = $client->request('GET', sprintf('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi', $this->getAccessToken()));
            $result   = json_decode($response->getBody()->getContents(), true);
            if (isset($result['errcode']) && $result['errcode'] === 0) {
                $this->redis->set('js_api_ticket', $result['ticket'], $result['expires_in'] - 60);
                return $result['ticket'];
            } else {
                throw new Exception('获取js_api_ticket失败【' . print_r($result, true) . '】');
            }
        }
    }

    /**
     * @param int $timestamp
     * @param string $nonceStr
     * @return string
     * @throws GuzzleException
     */
    public function getJsApiSign(int $timestamp, string $nonceStr)
    {
        $jsApiTicket = $this->getJsApiTicket();
        $data        = [
            'noncestr'     => $nonceStr,
            'jsapi_ticket' => $jsApiTicket,
            'timestamp'    => $timestamp,
        ];
        ksort($data);
        return sha1(http_build_query($data) . "&url=" . $this->url);
    }

    /**
     * @return string
     * @throws GuzzleException
     */
    public function getConfigHtml()
    {
        return sprintf("wx.config(JSON.parse('%s'));", json_encode($this->getConfig()));
    }

    public function getReadyHtml()
    {
        return sprintf("wx.ready(function () {
        wx.updateAppMessageShareData({
            title: '%s',
            desc: '%s',
            link: '%s',
            imgUrl: '%s',
            success: function () {
            }
        });
        wx.updateTimelineShareData({
            title: '%s',
            link: '%s',
            imgUrl: '%s',
            success: function () {
            }
        })
    });", $this->shareInfoTitle, $this->shareInfoDesc, $this->shareInfoLink, $this->shareInfoImgUrl, $this->shareInfoTitle, $this->shareInfoLink, $this->shareInfoImgUrl);
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getConfig()
    {
        $time  = time();
        $nonce = 'cb' . time();
        return [
            'debug'     => $this->appDebug,
            'appId'     => $this->appId,
            'timestamp' => $time,
            'nonceStr'  => $nonce,
            'signature' => $this->getJsApiSign($time, $nonce),
            'jsApiList' => $this->jsApiList
        ];
    }

    /**
     * @return mixed|string[]
     * @throws GuzzleException
     * @throws Exception
     */
    public function getUserInfo()
    {
        if (!isset($_GET['code'])) {
            header("Location: " . $this->getAuthorizeUrl());
            die();
        }
        list($accessToken, $openId) = $this->getAccessTokenAndOpenId($_GET['code']);
        $url      = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN";
        $client   = new Client();
        $response = $client->request('GET', sprintf($url, $accessToken, $openId));
        $result   = json_decode($response->getBody()->getContents(), true);
        if (isset($result['errcode'])) {
            throw new Exception(sprintf('获取用户信息失败【%s】', print_r($result, true)));
        } else {
            $result['source'] = 'wechat';
            return $result;
        }
    }

    /**
     * @return string
     */
    public function getAuthorizeUrl()
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        return sprintf($url, $this->appId, $this->url);
    }

    /**
     * @param string $code
     * @return array|false[]
     * @throws GuzzleException
     * @throws Exception
     */
    private function getAccessTokenAndOpenId(string $code)
    {
        $url      = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
        $client   = new Client();
        $response = $client->request('GET', sprintf($url, $this->appId, $this->appSecret, $code));
        $result   = json_decode($response->getBody()->getContents(), true);
        if (isset($result['errcode'])) {
            throw new Exception('无法获取用户信息【' . print_r($result, true) . '】');
        } else {
            return [$result['access_token'], $result['openid']];
        }
    }
}