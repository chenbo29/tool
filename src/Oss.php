<?php


namespace chenbo29\Tool;


use Endroid\QrCode\QrCode;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Mimey\MimeTypes;
use OSS\Core\OssException;
use OSS\OssClient;
use Ramsey\Uuid\Uuid;
use chenbo29\Tool\inter\Upload;

class Oss implements Upload
{
    public $keyId;
    public $keySecret;
    public $endPoint;
    public $ossDomain;
    public $bucket;

    public function __construct($keyId, $keySecret, $endPoint, $ossDomain, $bucket)
    {
        $this->keyId     = $keyId;
        $this->keySecret = $keySecret;
        $this->endPoint  = $endPoint;
        $this->ossDomain = $ossDomain;
        $this->bucket    = $bucket;
    }

    /**
     * @param $file
     * @return string
     * @throws Exception
     */
    public function uploadByFile($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName  = str_replace('_', '', Uuid::uuid4()->toString()) . '.' . $extension;
        // todo 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录RAM控制台创建RAM账号。
        try {
            $ossClient = new OssClient($this->keyId, $this->keySecret, $this->endPoint);
//        $options = array(
//            OssClient::OSS_HEADERS => array(
//                'x-oss-meta-info'  => 'your info'
//            ),
//        );
            $ossClient->putObject($this->bucket, $fileName, file_get_contents($file['tmp_name']));
        } catch (OssException $e) {
            throw new Exception("oss upload failed【{$e->getMessage()}】");
        }
        return sprintf($this->ossDomain . '/' . $fileName);
    }

    /**
     * @param $url
     * @return string
     * @throws Exception
     */
    public function uploadByUrl(string $url)
    {
        $client = new Client();
        try {
            $response = $client->get($url);
        } catch (GuzzleException $e) {
            throw new Exception('请求图片url失败');
        }
        $contentType = $response->getHeader('Content-Type');
        if (empty($contentType)) {
            $extension = '';
        } else {
            $mimes     = new MimeTypes();
            $extension = $mimes->getExtension((string)$contentType[0]);
        }
        $fileName = str_replace('_', '', Uuid::uuid4()->toString()) . '.' . $extension;
        // todo 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录RAM控制台创建RAM账号。
        try {
            $ossClient = new OssClient($this->keyId, $this->keySecret, $this->endPoint);
//        $options = array(
//            OssClient::OSS_HEADERS => array(
//                'x-oss-meta-info'  => 'your info'
//            ),
//        );
            $ossClient->putObject($this->bucket, $fileName, file_get_contents($url));
        } catch (OssException $e) {
            throw new Exception("oss upload by url failed【{$e->getMessage()}】");
        }
        return sprintf($this->ossDomain . '/' . $fileName);
    }

    /**
     * @param $filePath
     * @return string
     * @throws Exception
     */
    public function uploadByPath(string $filePath)
    {
        if (!file_exists($filePath)) throw new Exception("文件{$filePath}不存在");
        $fileName = str_replace('_', '', Uuid::uuid4()->toString()) . '.' . pathinfo($filePath, PATHINFO_EXTENSION);;
        // todo 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录RAM控制台创建RAM账号。
        try {
            $ossClient = new OssClient($this->keyId, $this->keySecret, $this->endPoint);
//        $options = array(
//            OssClient::OSS_HEADERS => array(
//                'x-oss-meta-info'  => 'your info'
//            ),
//        );
            $ossClient->putObject($this->bucket, $fileName, file_get_contents($filePath));
        } catch (OssException $e) {
            throw new Exception("oss upload by path failed【{$e->getMessage()}】");
        }
        return sprintf($this->ossDomain . '/' . $fileName);
    }

    /**
     * @param QrCode $qrCode
     * @return string
     * @throws Exception
     */
    public function uploadWithQrcode(QrCode $qrCode)
    {
        $mime     = new MimeTypes();
        $fileName = str_replace('_', '', Uuid::uuid4()->toString()) . '.' . $mime->getExtension($qrCode->getContentType());
        try {
            $ossClient = new OssClient($this->keyId, $this->keySecret, $this->endPoint);
//        $options = array(
//            OssClient::OSS_HEADERS => array(
//                'x-oss-meta-info'  => 'your info'
//            ),
//        );
            $ossClient->putObject($this->bucket, $fileName, $qrCode->writeString());
        } catch (OssException $e) {
            throw new Exception("oss upload by data failed【{$e->getMessage()}】");
        }
        return sprintf($this->ossDomain . '/' . $fileName);
    }

    /**
     * @param string $fileName
     * @return bool
     * @throws Exception
     */
    public function delete(string $fileName)
    {
        try {
            $ossClient = new OssClient($this->keyId, $this->keySecret, $this->endPoint);
            $ossClient->deleteObject($this->bucket, $fileName);
        } catch (OssException $e) {
            throw new Exception("oss delete failed【{$e->getMessage()}】");
        }
        return true;
    }

    /**
     * @param string $folderPath
     * @return array
     * @throws Exception
     */
    public function uploadWithFolder(string $folderPath)
    {
        if (!file_exists($folderPath)) throw new Exception('文件夹不存在');
        $filesPath = [];
        foreach (scandir($folderPath) as $v) {
            if (in_array($v, ['.', '..'])) continue;
            $filesPath[] = $this->uploadByPath($folderPath . DIRECTORY_SEPARATOR . $v);
        }
        return $filesPath;
    }
}