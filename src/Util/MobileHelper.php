<?php
declare(strict_types=1);

namespace Lengbin\Helper\Util;

class MobileHelper
{
    const REGEX_MOBILE_EXACT = "/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\\d{8}$/";

    /**
     * @param string $mobile
     *
     * @return bool
     */
    public static function isMobile(string $mobile): bool
    {
        if (empty($mobile)) {
            return false;
        }
        if (strpos($mobile, '+86') === 0) {
            $mobile = substr($mobile, 3);
        }
        return (bool)preg_match(self::REGEX_MOBILE_EXACT, $mobile);
    }

    /**
     * 影藏手机号
     *
     * @param string $mobile
     *
     * @return string|string[]
     */
    public static function hideMobile(string $mobile): string
    {
        return substr_replace($mobile, '****', 3, 4);
    }
}
