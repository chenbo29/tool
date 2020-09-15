<?php

namespace chenbo29\Tool\inter;

use Endroid\QrCode\QrCode;

interface Upload
{
    public function uploadByFile($file);

    public function uploadByUrl($url);

    public function uploadByPath($filePath);

    public function uploadWithQrcode(QrCode $qrcode);
}