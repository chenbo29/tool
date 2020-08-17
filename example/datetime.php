<?php
require_once __DIR__ . '/../src/Instance.php';
require_once __DIR__ . '/../src/DateTime.php';
use Tool\Instance;
echo Instance::DateTime()->ago(strtotime('2019-10-28 09:00:00'));