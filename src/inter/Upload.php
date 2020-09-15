<?php

namespace chenbo29\Tool\inter;

interface Upload
{
    public function uploadByFile($file);

    public function uploadByUrl($url);

    public function uploadByPath($filePath);
}