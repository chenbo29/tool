<?php


namespace chenbo29\Tool;


class File
{
    function sizeConvert($bytes)
    {
        $result  = $bytes;
        $bytes   = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT"  => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT"  => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT"  => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT"  => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT"  => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = strval(round($result, 2)) . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }
}