<?php

namespace Lengbin\Helper\Util;

class BcmathHelper
{

    /**
     * 相加
     *
     * @param string $left
     * @param string $right
     * @param int    $scale
     *
     * @return string
     */
    public static function bcAdd(string $left, string $right, int $scale = 2): string
    {
        return bcadd($left, $right, $scale);
    }

    /**
     * 相减
     * @param string $left
     * @param string $right
     * @param int    $scale
     *
     * @return string
     */
    public static function bcSub(string $left, string $right, int $scale = 2): string
    {
        return bcsub($left, $right, $scale);
    }

    /**
     * 相乘
     * @param string $left
     * @param string $right
     * @param int    $scale
     *
     * @return string
     */
    public static function bcMul(string $left, string $right, int $scale = 2): string
    {
        return bcmul($left, $right, $scale);
    }

    /**
     * 相除
     * @param string $left
     * @param string $right
     * @param int    $scale
     *
     * @return string
     */
    public static function bcDiv(string $left, string $right, int $scale = 2): string
    {
        return bcdiv($left, $right, $scale);
    }

    /**
     * 获得 百分比
     *
     * @param string $dividend
     * @param string $divisor
     * @param int    $scale
     *
     * @return string
     */
    public static function getRate(string $dividend, string $divisor, int $scale = 2): string
    {
        if ($divisor <= 0 || $dividend <= 0) {
            return '0%';
        }
        return bcdiv(bcmul($dividend, "100", $scale), $divisor, $scale) . '%';
    }
}
