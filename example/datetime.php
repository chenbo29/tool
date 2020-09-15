<?php

use chenbo29\Tool\Instance;

require_once __DIR__ . '/../vendor/autoload.php';
try {
    var_dump(Instance::DateTime()->ago('2020-8-18 11:37:00'));
    var_dump(Instance::Star()->fontawesome(45, '#FFCC66'));
    var_dump(Instance::Oss('LTAI4GKXNcPx39WNGwNugGFg', 'wTjMk1CTxqpCYeN9W3SzJDR2C9og2f', 'http://oss-cn-beijing.aliyuncs.com', 'http://oss.hongxingjiankang.com', 'promotions')->uploadByUrl('https://img2018.cnblogs.com/blog/1580332/201901/1580332-20190129002421628-1234972420.png'));
    var_dump(Instance::Oss('LTAI4GKXNcPx39WNGwNugGFg', 'wTjMk1CTxqpCYeN9W3SzJDR2C9og2f', 'http://oss-cn-beijing.aliyuncs.com', 'http://oss.hongxingjiankang.com', 'promotions')->uploadByPath(__DIR__ . '/test.jpg'));
} catch (Exception $e) {
    var_dump($e->getMessage());
}
