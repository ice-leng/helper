<?php

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/6/5
 * Time: 下午1:22
 */

namespace Lengbin\Helper\Util;

use Lengbin\Helper\YiiSoft\Arrays\ArrayHelper;
use Lengbin\Helper\YiiSoft\StringHelper;

/**
 * Class FormatHelper
 *
 * @package Lengbin\Helper\Util
 */
class FormatHelper
{

    /**
     * 字节格式化
     *
     * @param int $size 字节
     *
     * @return string
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function formatBytes($size)
    {
        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

    /**
     * 金额格式化
     *
     * @param $number
     * @param $decimals
     *
     * @return string
     */
    public static function formatNumbers($number, $decimals)
    {
        return sprintf("%.{$decimals}f", $number);
    }

    /**
     * 数字随机数
     *
     * @param int $length 位数
     *
     * @return string
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function randNum($length = 6)
    {
        $min = pow(10, ($length - 1));
        $max = pow(10, $length) - 1;
        $mem = rand($min, $max);
        return $mem;
    }

    /**
     * 字母数字混合随机数
     *
     * @param int $num 位数
     *
     * @return string
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function randStr($num = 10)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $string = "";
        for ($i = 0; $i < $num; $i++) {
            $string .= substr($chars, rand(0, strlen($chars)), 1);
        }
        return $string;
    }

    /**
     * 数字金额转换为中文
     *
     * @param double $num 数字
     * @param bool   $sim 大小写
     *
     * @return string
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function numberToChinese($num, $sim = false)
    {
        if (!is_numeric($num)) {
            return '含有非数字非小数点字符！';
        }
        $char = $sim ? [
            '零',
            '一',
            '二',
            '三',
            '四',
            '五',
            '六',
            '七',
            '八',
            '九',
        ] : [
            '零',
            '壹',
            '贰',
            '叁',
            '肆',
            '伍',
            '陆',
            '柒',
            '捌',
            '玖',
        ];
        $unit = $sim ? ['', '十', '百', '千', '', '万', '亿', '兆'] : ['', '拾', '佰', '仟', '', '萬', '億', '兆'];
        $retval = '';
        $num = sprintf("%01.2f", $num);
        [$num, $dec] = explode('.', $num);
        // 小数部分
        if ($dec['0'] > 0) {
            $retval .= "{$char[$dec['0']]}角";
        }
        if ($dec['1'] > 0) {
            $retval .= "{$char[$dec['1']]}分";
        }
        // 整数部分
        if ($num > 0) {
            $retval = "元" . $retval;
            $f = 1;
            $out = [];
            $str = strrev(intval($num));
            for ($i = 0, $c = strlen($str); $i < $c; $i++) {
                if ($str[$i] > 0) {
                    $f = 0;
                }
                if ($f == 1 && $str[$i] == 0) {
                    $out[$i] = "";
                } else {
                    $out[$i] = $char[$str[$i]];
                }
                $out[$i] .= $str[$i] != '0' ? $unit[$i % 4] : '';
                if ($i > 1 and $str[$i] + $str[$i - 1] == 0) {
                    $out[$i] = '';
                }
                if ($i % 4 == 0) {
                    $out[$i] .= $unit[4 + floor($i / 4)];
                }
            }
            $retval = join('', array_reverse($out)) . $retval;
        }
        return $retval;
    }

    /**
     * 下划线转驼峰
     * 思路:
     * step1.原字符串转小写,原字符串中的分隔符用空格替换,在字符串开头加上分隔符
     * step2.将字符串中每个单词的首字母转换为大写,再去空格,去字符串首部附加的分隔符.
     */
    public static function camelize($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        return lcfirst(str_replace(' ', '', $value));
    }

    /**
     * 驼峰命名转下划线命名
     * 思路:
     * 小写和大写紧挨一起的地方,加上分隔符,然后全部转小写
     */
    public static function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    /**
     * 验证请求参数字段
     * 支持别名
     *
     * @param array  $requests      请求参数
     * @param array  $validateField 验证字段，支持别名  ['别名' => 字段， 0 => 字段]
     * @param string $defaults
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function validateParams(array $requests, array $validateField, $defaults = '')
    {
        $data = [];
        foreach ($validateField as $key => $field) {
            $default = is_array($defaults) ? ArrayHelper::getValue($defaults, $field) : $defaults;
            $param = ArrayHelper::getValue($requests, $field, $default);
            $index = is_int($key) ? $field : $key;
            $data[$index] = $param;
        }
        return $data;
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

    /**
     * 影藏身份证
     *
     * @param string $idcard
     *
     * @return string|string[]
     */
    public static function hidcard(string $idcard): string
    {
        return strlen($idcard) == 15 ? substr_replace($idcard, "*****", 6, 5) : (strlen($idcard) == 18 ? substr_replace($idcard, "********", 6, 8) : $idcard);
    }
}
