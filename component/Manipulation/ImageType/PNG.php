<?php

namespace IFaqih\IFImage\Component\Manipulation\ImageType;

class PNG extends AbstractType
{

    public static function ___load(string $image_file): object
    {
        static::$image_file = imagecreatefrompng($image_file);
        return static::getInstance();
    }

    public static function ___save(string $target_file): bool
    {
        static::$image_manipulation = static::$image_manipulation ?? imagecreatetruecolor(static::$target_size['width'], static::$target_size['height']);

        static::$quality = (static::$quality / 100) * 9;
        static::$quality = ((static::$quality < 1) ? intval(ceil(static::$quality)) : intval(static::$quality));

        // Mengisi offest gambar target dengan warna transparan
        imagesavealpha(static::$image_manipulation, true);
        $offset = imagecolorallocatealpha(static::$image_manipulation, 255, 255, 255, 127);
        $offset = imagecolortransparent(static::$image_manipulation, $offset);

        imagefill(static::$image_manipulation, 0, 0, $offset);

        self::process_image();

        $save_new_image = imagepng(static::$image_manipulation, $target_file . ".png", static::$quality);

        self::destroy_image();

        return $save_new_image;
    }
}
