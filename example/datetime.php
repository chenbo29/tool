<?php

use chenbo29\Tool\Instance;

require_once __DIR__ . '/../vendor/autoload.php';
$keyId     = 'LTAI4GKXNcPx39WNGwNugGFg';
$keySecret = 'wTjMk1CTxqpCYeN9W3SzJDR2C9og2f';
$endPoint  = 'http://oss-cn-beijing.aliyuncs.com';
$ossDomain = 'http://oss.hongxingjiankang.com';
$bucket    = 'promotions';
try {
    var_dump(Instance::DateTime()->ago('2020-8-18 11:37:00'));
    var_dump(Instance::Star()->fontawesome(45, '#FFCC66'));
    var_dump(Instance::Oss('LTAI4GKXNcPx39WNGwNugGFg', 'wTjMk1CTxqpCYeN9W3SzJDR2C9og2f', 'http://oss-cn-beijing.aliyuncs.com', 'http://oss.hongxingjiankang.com', 'promotions')->uploadByUrl('https://img2018.cnblogs.com/blog/1580332/201901/1580332-20190129002421628-1234972420.png'));
    $test = Instance::Oss('LTAI4GKXNcPx39WNGwNugGFg', 'wTjMk1CTxqpCYeN9W3SzJDR2C9og2f', 'http://oss-cn-beijing.aliyuncs.com', 'http://oss.hongxingjiankang.com', 'promotions')->uploadByPath(__DIR__ . '/test.jpg');
    var_dump($test);
    var_dump(Instance::Oss($keyId, $keySecret, $endPoint, $ossDomain, $bucket)->delete(pathinfo($test, PATHINFO_BASENAME)));
} catch (Exception $e) {
    var_dump($e->getMessage());
}
