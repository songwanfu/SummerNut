<?php
namespace app\models;
use Yii;


class Common
{

    /**
     * 转换字节大小
     * @param $filesize
     * @return string
     */
    public static function transByte($filesize)
    {
        $arr = array("B", "KB", "MB", "GB");
        $i = 0;
        while ($filesize >= 1024) {
            $filesize /= 1024;
            $i++;
        }
        return (round($filesize, 2) . $arr[$i]);
    }

     /**
     * [getTime 获取当前时间]
     * @return [type] [description]
     */
    public static function getTime()
    {
        return date('Y-m-d H:i:s', time());
    }

    public static function parseJsonToStr($json)
    {
        $arr = json_decode($json, true);
        $str = '';
        foreach ($arr as $k => $v) {
            $str .= $k . ':' . $v . '<br>';
        }
        return $str;
    }

    public static function getAwayTime($timestamp)
    {
        $currentTime = time();
        $oldTime = strtotime($timestamp);
        $time = $currentTime - $oldTime;
        if ($time > 86400) {
            return $timestamp;
        } 
        if ($time < 86400 && $time > 3600) {

            return (floor($time / 3600) . Yii::t('app', 'hours ago'));
        }
        if ($time < 3600 && $time > 60) {
            return (floor($time / 60) . Yii::t('app', 'minuts ago'));
        }
        if ($time < 60) {
            return ($time . Yii::t('app', 'seconds ago'));
        }
    }

    public static function transTime($time)
    {
        if ($time > 3600) {
            $h = $time / 3600;
            $h = floor($h);
            $m = ($time - $h * 3600) / 60;

            return (round($h, 0) . Yii::t('app', 'hours') . round($m, 0) . Yii::t('app', 'minuts'));
        }
        if ($time < 3600 && $time > 60) {
            $m = $time / 60;
            return floor($m) . Yii::t('app', 'minuts');
        }
        return $time . Yii::t('app', 'seconds');
    }

}
