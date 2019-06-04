<?php


namespace App\Helper;


class Util
{
    /**
     * @param $params
     * @return array
     */
    public static function stripHtmlTags($params)
    {
        return array_map(function ($v) {
            return strip_tags($v);
        }, $params);
    }

    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomShortCode($length = 4)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}