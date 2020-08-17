<?php
require_once __DIR__ . '/../vendor/autoload.php';
echo  \chenbo29\Tool\Instance::DateTime()->ago(strtotime('2019-10-28 09:00:00'));