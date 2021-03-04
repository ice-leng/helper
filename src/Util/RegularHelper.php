<?php

namespace Lengbin\Helper\Util;

use Lengbin\Helper\YiiSoft\StringHelper;

class RegularHelper
{
    /**
     * 正则
     *
     * @param string $url
     *
     * @return bool
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function checkUrl(string $url): bool
    {
        if (StringHelper::isEmpty($url)) {
            return false;
        }
        $rule = "/((http|https):\/\/)+(\w+)[\w\/\.\-]*/";
        return preg_match($rule, $url);
    }

    /**
     * 正则
     *
     * @param string $url
     *
     * @return bool
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function checkImage($url): bool
    {
        if (StringHelper::isEmpty($url)) {
            return false;
        }
        $rule = "/((http|https):\/\/)?\w+\.(jpg|jpeg|gif|png)/";
        return preg_match($rule, $url);
    }

    /**
     * 密码
     *
     * @param $password
     *
     * @return bool
     */
    public static function checkPassword($password): bool
    {
        if (StringHelper::isEmpty($password)) {
            return false;
        }
        $rule = "^(?=.*[a-zA-Z0-9].*)(?=.*[a-zA-Z\\W].*)(?=.*[0-9\\W].*).{6,20}$";
        return preg_match($rule, $password);
    }
}
