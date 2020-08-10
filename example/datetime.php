<?php
require_once __DIR__ . '/../src/Tool.php';
require_once __DIR__ . '/../src/DateTime.php';
echo \chenbo29\Tool::DateTime()->ago(strtotime('2019-10-28 09:00:00'));
\chenbo29\Tool::Oss();