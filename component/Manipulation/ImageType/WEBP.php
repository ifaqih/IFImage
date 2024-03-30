<?php

namespace IFaqih\IFImage\Component\Manipulation\ImageType;

class WEBP extends AbstractType
{

    public static function ___load(string $image_file): object
    {
        static::$image_file = imagecreatefromwbmp($image_file);
        return static::getInstance();
    }

    public static function ___save(string $target_file): bool
    {
        static::$image_manipulation = static::$image_manipulation ?? imagecreatetruecolor(static::$target_size['width'], static::$target_size['height']);

        // Mengisi offest gambar target dengan warna transparan
        imagesavealpha(static::$image_manipulation, true);
        $offset = imagecolorallocatealpha(static::$image_manipulation, 255, 255, 255, 127);
        $offset = imagecolortransparent(static::$image_manipulation, $offset);

        imagefill(static::$image_manipulation, 0, 0, $offset);

        self::process_image();

        $save_new_image = imagewebp(static::$image_manipulation, $target_file . ".webp", static::$quality);

        self::destroy_image();

        return $save_new_image;
    }
}
