<?php

namespace chenbo29\Tool\inter;

use Endroid\QrCode\QrCode;

interface Upload
{
    public function uploadByFile($file);

    public function uploadByUrl(string $url);

    public function uploadByPath(string $filePath);

    public function delete(string $fileName);

    public function uploadWithQrcode(QrCode $qrcode);

    public function uploadWithFolder(string $folderPath);
}