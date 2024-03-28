<?php

namespace IFaqih\IFImage;

require_once __DIR__ . "/../component/Void.php";

use IFaqih\IFImage\Component\Main;

class Image extends Main
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Load Image.
     *
     * @param string $image_file gambar yang akan diload.
     * @return \IFaqih\IFImage\Component\Main
     * @method resize(int $width, int $height): object
     * @method quality(int $quality): object
     * @method convert(string|int $image_type): object
     * @method save(string $target_file): bool
     */
    public static function load(string $image_file)
    {
        $main = new self();

        return $main->__load($image_file);
    }
}
