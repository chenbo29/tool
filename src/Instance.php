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
     * @param string $keyId 密钥id
     * @param string $keySecret 密钥secret
     * @param string $endPoint 地域节点
     * @param string $ossDomain 访问域名
     * @param string $bucket
     * @return Oss
     */
    public static function Oss(string $keyId, string $keySecret, string $endPoint, string $ossDomain, string $bucket) {
        return new Oss($keyId, $keySecret, $endPoint, $ossDomain, $bucket);
    }

    public static function Star() {
        return new Star();
    }
}