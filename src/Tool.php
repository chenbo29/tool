<?php


namespace chenbo29;


class Tool
{
    /**
     * @return DateTime
     */
    public static function DateTime() {
        return new DateTime();
    }

    /**
     * @param $keyId 密钥id
     * @param $keySecret 密钥secret
     * @param $endPoint
     * @param $ossDomain
     * @param $bucket
     * @return Oss
     */
    public static function Oss($keyId, $keySecret, $endPoint, $ossDomain, $bucket) {
        return new Oss($keyId, $keySecret, $endPoint, $ossDomain, $bucket);
    }
}