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

}