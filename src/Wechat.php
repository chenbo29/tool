<?php


namespace chenbo29\Tool;


class Wechat
{
    private $appId;
    private $appSecret;
    private $redirectUrl;

    public function __construct($appId, $appSecret, $redirectUrl)
    {
        $this->appId       = $appId;
        $this->appSecret   = $appSecret;
        $this->redirectUrl = $redirectUrl;
    }

    public function getRedirectUrl()
    {
        return sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect', $this->appId, urlencode($this->redirectUrl));
    }
}