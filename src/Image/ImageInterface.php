<?php

namespace Lengbin\Helper\Image;

interface ImageInterface
{

    /**
     * 生成图片
     *
     * @param string $outputDir 输出目录， 默认为文件当前目录
     *
     * @return string / array xxx.jpeg / [xxxxx.jpeg, xxxx.jepg]
     *
     */
    public function generateImage($outputDir = '');

}
