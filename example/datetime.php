<?php
require_once __DIR__ . '/../src/Tool.php';
require_once __DIR__ . '/../src/DateTime.php';
echo \tool\Tool::datetime()->ago(strtotime('2019-10-28 09:00:00'));