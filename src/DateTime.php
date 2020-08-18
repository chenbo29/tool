<?php

namespace chenbo29\Tool;

/**
 * Class DateTime
 * @package tool
 */
class DateTime
{
    /**
     * @param $time
     * @return string
     * @throws \Exception
     */
    public function ago($time)
    {
        $y = date_diff(new \DateTime($time), new \DateTime())->y;
        $m = date_diff(new \DateTime($time), new \DateTime())->m;
        $d = date_diff(new \DateTime($time), new \DateTime())->d;
        $h = date_diff(new \DateTime($time), new \DateTime())->h;
        $i = date_diff(new \DateTime($time), new \DateTime())->i;
        $s = date_diff(new \DateTime($time), new \DateTime())->s;
        if ($y > 0) return "{$y}年前";
        if ($m > 0) return "{$m}月前";
        if ($d > 0) return "{$d}天前";
        if ($h > 0) return "{$h}小时前";
        if ($i > 0) return "{$i}分钟前";
        if ($s > 0) return "{$s}秒前";
        return '刚刚';
    }
}