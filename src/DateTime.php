<?php

namespace tool;

/**
 * Class DateTime
 * @package tool
 */
class DateTime
{
    private static $instance;

    private function __construct()
    {
    }

    public static function instance() {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $time
     * @return string
     */
    public function ago($time)
    {
        $timeNow  = date("Y-m-d H:i:s", time());
        $timeNow  = strtotime($timeNow);
        $timeShow = strtotime($time);
        $dur      = $timeNow - $timeShow;
        if ($dur < 0) {
            return $time;
        } else {
            if ($dur < 60) {
                return $dur . '秒前';
            } else {
                if ($dur < 3600) {
                    return floor($dur / 60) . '分钟前';
                } else {
                    if ($dur < 86400) {
                        return floor($dur / 3600) . '小时前';
                    } else {
                        if ($dur < 259200) {
                            return floor($dur / 86400) . '天前';
                        } else {
                            return date('Y-m-d', $time);
                        }
                    }
                }
            }
        }
    }
}