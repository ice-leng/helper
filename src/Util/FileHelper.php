<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/6/5
 * Time: 下午3:15
 */

namespace Lengbin\Helper\Util;

use Lengbin\Helper\YiiSoft\BaseFileHelper;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

/**
 * Class FileHelper
 * @package Lengbin\Helper\Directory
 */
class FileHelper extends BaseFileHelper
{
    /**
     * 网络路径读取文件
     *
     * @param string $url
     * @param int    $timeout 超时时间
     *
     * @return null|string
     */
    public static function getUrlFile(string $url, int $timeout = 10): ?string
    {
        $ctx = stream_context_create(['http' => ['timeout' => $timeout]]);
        $content = file_get_contents($url, 0, $ctx);
        if ($content) {
            return $content;
        }
        return null;
    }

    /**
     * 写文件，如果文件目录不存在，则递归生成
     *
     * @param string $file    文件名 路径+文件
     * @param string $content 内容
     * @param int    $flags
     *
     * @return bool
     */
    public static function putFile(string $file, string $content, $flags = 0): bool
    {
        $pathInfo = pathinfo($file);
        if (!empty($pathInfo['dirname'])) {
            if (file_exists($pathInfo['dirname']) === false) {
                if (mkdir($pathInfo['dirname'], 0755, true) === false) {
                    return false;
                }
                chmod($pathInfo['dirname'], 0755);
            }
        }
        return file_put_contents($file, $content, $flags);
    }

    /**
     * 获取文件后缀名
     *
     * @param $fileName
     *
     * @return string
     */
    public static function getExtension($fileName): string
    {
        $ext = explode('.', $fileName);
        $ext = array_pop($ext);
        return strtolower($ext);
    }

    /**
     * 读取文件最后几条内容
     *
     * @param string $file
     * @param int    $num
     *
     * @return array
     */
    public static function readFileLastContent(string $file, $num = 1): array
    {
        $lines = [];
        if (!is_file($file)) {
            return $lines;
        }
        $fp = fopen($file, "r");
        $pos = -2;
        $eof = "";
        $head = false;   //当总行数小于Num时，判断是否到第一行了
        while ($num > 0) {
            while ($eof !== "\n") {
                if (fseek($fp, $pos, SEEK_END) === 0) {
                    $eof = fgetc($fp);
                    $pos--;
                } else {
                    fseek($fp, 0, SEEK_SET);
                    $head = true;
                    break;
                }

            }
            array_unshift($lines, fgets($fp));
            if ($head) {
                break;
            }
            $eof = "";
            $num--;
        }
        fclose($fp);
        return $lines;
    }

    /**
     * 递归修改目录/文件权限
     *
     * @param string $path  路径
     * @param int    $chmod 权限
     *
     * @return bool
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function chmod($path, $chmod): bool
    {
        if (!is_dir($path)) {
            return chmod($path, $chmod);
        }
        $dh = opendir($path);
        while (($file = readdir($dh)) !== false) {
            if ($file !== '.' && $file !== '..') {
                $fullPath = $path . '/' . $file;
                if (is_link($fullPath)) {
                    return FALSE;
                } elseif (!is_dir($fullPath) && !chmod($fullPath, $chmod)) {
                    return FALSE;
                } elseif (!self::chmod($fullPath, $chmod)) {
                    return FALSE;
                }
            }
        }
        closedir($dh);
        if (chmod($path, $chmod)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 目录下是否有文件
     *
     * @param $path
     *
     * @return bool
     *
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function dirExistFile($path)
    {
        if (!is_dir($path)) {
            return false;
        }
        $files = scandir($path);
        // 删除  "." 和 ".."
        unset($files[0]);
        unset($files[1]);
        // 判断是否为空
        if (!empty($files[2])) {
            return true;
        }
        return false;
    }

    /**
     * @param string $path
     *
     * @return RecursiveIteratorIterator|SplFileInfo[]
     */
    public static function scan(string $path): RecursiveIteratorIterator
    {
        return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS));
    }

}
