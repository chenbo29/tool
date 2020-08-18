<?php


namespace chenbo29\Tool;


class Instance
{
    /**
     * @return DateTime
     */
    public static function DateTime() {
        ini_set('date.timezone', 'Asia/ShangHai');
        return new DateTime();
    }

    /**
     * @param $keyId 密钥id
     * @param $keySecret 密钥secret
     * @param $endPoint 地域节点
     * @param $ossDomain 访问域名
     * @param $bucket
     * @return Oss
     */
    public static function Oss($keyId, $keySecret, $endPoint, $ossDomain, $bucket) {
        return new Oss($keyId, $keySecret, $endPoint, $ossDomain, $bucket);
    }

    public static function Star() {
        return new Star();
    }
}