<?php

namespace IFaqih\IFImage\Component\ImageType;

use IFaqih\IFImage\Component\Main;

abstract class AbstractType extends Main
{



    public function __construct()
    {
        parent::__construct();
    }

    protected static function process_image(): void
    {
        // Menghitung proporsi gambar yang harus diresize
        $sourceRatio = static::$image_size['width'] / static::$image_size['height'];
        $targetRatio = static::$target_size['width'] / static::$target_size['height'];

        // Menyesuaikan perbandingan gambar sumber dan target
        if ($sourceRatio > $targetRatio) {
            $resizeWidth = static::$target_size['width'];
            $resizeHeight = intval(static::$target_size['width'] / $sourceRatio);
        } else {
            $resizeWidth = intval(static::$target_size['height'] * $sourceRatio);
            $resizeHeight = static::$target_size['height'];
        }

        // Menyalin dan meresize gambar sumber ke gambar target
        imagecopyresampled(static::$image_manipulation, static::$image_file, round((static::$target_size['width'] - $resizeWidth) / 2), round((static::$target_size['height'] - $resizeHeight) / 2), 0, 0, $resizeWidth, $resizeHeight, static::$image_size['width'], static::$image_size['height']);

        return;
    }

    protected static function destroy_image(): void
    {
        imagedestroy(static::$image_file);
        imagedestroy(static::$image_manipulation);

        return;
    }

    abstract public static function ___load(string $image_file): object;

    abstract public static function ___save(string $target_file): bool;
}
