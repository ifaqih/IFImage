<?php

namespace IFaqih\IFImage\Component;

use Exception;

class Main
{
    protected static $file_name;

    protected static $image_file;

    protected static $image_size;

    protected static $image_type;

    protected static $image_manipulation;

    protected static $target_size;

    protected static $target_type;

    protected static $quality = 100;

    private static $instance;


    public function __construct()
    {
    }

    protected static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new self();
        }
        return static::$instance;
    }

    protected function __load(string $image_file): object|false
    {
        static::$file_name = basename($image_file);

        list($sourceWidth, $sourceHeight, $sourceType) = getimagesize($image_file);
        static::$image_size = [
            'width'     =>  $sourceWidth,
            'height'    =>  $sourceHeight
        ];

        static::$target_size = [
            'width'     =>  $sourceWidth,
            'height'    =>  $sourceHeight
        ];

        static::$image_type = $sourceType;

        switch ($sourceType) {
            case IMAGETYPE_JPEG:
                require_once __DIR__ . "/ImageType/JPEG.php";
                return \IFaqih\IFImage\Component\ImageType\JPEG::___load($image_file);
                break;
            case IMAGETYPE_PNG:
                require_once __DIR__ . "/ImageType/PNG.php";
                return \IFaqih\IFImage\Component\ImageType\PNG::___load($image_file);
                break;
            case IMAGETYPE_WEBP:
                require_once __DIR__ . "/ImageType/WEBP.php";
                return \IFaqih\IFImage\Component\ImageType\WEBP::___load($image_file);
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Merubah luas gambar.
     *
     * @param int $width target labar gambar.
     * @param int $height target tinggi gambar.
     * @return \IFaqih\IFImage\Component\Main
     * @method quality(int $quality): object
     * @method convert(string|int $image_type): object
     * @method save(string $target_file): bool
     */
    public function resize(int $width, int $height): object
    {
        static::$target_size = [
            'width'     =>  $width,
            'height'    =>  $height
        ];
        static::$image_manipulation = imagecreatetruecolor($width, $height);
        return self::getInstance();
    }

    /**
     * Menetapkan kualitas gambar.
     *
     * @param int $quality ukuran kualitas 0 sampai 100.
     * @return \IFaqih\IFImage\Component\Main
     * @method resize(int $width, int $height): object
     * @method convert(string|int $image_type): object
     * @method save(string $target_file): bool
     */
    public function quality(int $quality): object|false
    {
        if ($quality > 0 && $quality <= 100) {
            static::$quality = $quality;
            return self::getInstance();
        } else {
            return false;
        }
    }

    /**
     * Konversi gambar ke tipe gambar lain.
     *
     * @param string|int $image_type target tipe gambar (gunakan konstanta tipe gambar dari php atau gunakan string tipe gambar).
     * @return \IFaqih\IFImage\Component\Main
     * @method resize(int $width, int $height): object
     * @method quality(int $quality): object
     * @method save(string $target_file): bool
     */
    public function convert(string|int $image_type): object|false
    {
        $image_type = is_string($image_type) ? strtoupper($image_type) : $image_type;

        if (in_array($image_type, [
            IMAGETYPE_JPEG,
            IMAGETYPE_PNG,
            IMAGETYPE_GIF,
            IMAGETYPE_WEBP,
            "JPEG",
            "JPG",
            "PNG",
            "GIF",
            "WEBP"
        ])) {
            static::$target_type = match ($image_type) {
                IMAGETYPE_JPEG, "JPEG", "JPG"     =>  IMAGETYPE_JPEG,
                IMAGETYPE_PNG, "PNG"              => IMAGETYPE_PNG,
                IMAGETYPE_WEBP, "WEBP"            =>  IMAGETYPE_WEBP,
                default => false,
            };

            return self::getInstance();
        } else {
            return false;
        }
    }

    /**
     * Simpan gambar.
     *
     * @param string $target_dir direktori dimana gambar akan disimpan.
     * @param string $image_name nama gambar yang akan disimpan, tidak perlu menyertakan ekstensi file (default null).
     * @param int $flag flag untuk opsi saat menyimpan (default 0). Flag tersedia:
     *                          - IFIMAGE_NAME_WITH_SIZE : 1, menambahkan luas gambar pada nama file gambar.
     *                          - IFIMAGE_NAME_WITH_OLD_EXTENSION : 2, menambahkan ekstensi lama pada pada nama file gambar.
     *                          - IFIMAGE_FORCE_CREATE_DIRECTORY : 4, paksa membuat directory bila directory tujuan tidak tersedia.
     * @return bool
     */
    public function save(string $target_dir, string|null $image_name = null, int $flag = 0): bool
    {
        if (!empty(static::$file_name) && !empty(static::$image_file) && !empty(static::$image_size) && !empty(static::$image_type) && !empty(static::$instance)) {
            try {
                static::$target_type = static::$target_type ?? static::$image_type;

                $ex = explode(".", static::$file_name);
                $key_extension = count($ex) - 1;
                $extension = $ex[$key_extension];

                if (empty($image_name)) {
                    $image_name = "";

                    for ($i = 0; $i < $key_extension; $i++) {
                        $image_name .= $ex[$i];
                    }
                }

                if (($flag & IFIMAGE_NAME_WITH_SIZE) === IFIMAGE_NAME_WITH_SIZE) {
                    $image_name = $image_name . "-" . static::$target_size['width'] . "x" . static::$target_size['height'];
                }

                if (($flag & IFIMAGE_NAME_WITH_OLD_EXTENSION) === IFIMAGE_NAME_WITH_OLD_EXTENSION) {
                    $image_name = $image_name . "." . $extension;
                }

                $target_dir = str_replace('\\', '/', (in_array(substr($target_dir, -1), ['/', '\\']) ? $target_dir : $target_dir . "/"));

                if (($flag & IFIMAGE_FORCE_CREATE_DIRECTORY) === IFIMAGE_FORCE_CREATE_DIRECTORY) {
                    $target_dir = substr($target_dir, 0, (strlen($target_dir) - 1));
                    if (!file_exists($target_dir)) {
                        $ex = explode('/', $target_dir);
                        $target_dir = "";
                        foreach ($ex as $key => $value) {
                            $target_dir .= $value;
                            if (!in_array($value, ['', ' ', null])) {
                                if (!file_exists($target_dir) || !is_dir($target_dir)) {
                                    mkdir($target_dir);
                                }
                            }
                            $target_dir .= "/";
                        }
                    }
                    $target_dir = str_replace("//", "/", $target_dir . "/");
                }

                $target_file = $target_dir . $image_name;

                switch (static::$target_type) {
                    case IMAGETYPE_JPEG:
                        require_once __DIR__ . "/ImageType/JPEG.php";
                        return \IFaqih\IFImage\Component\ImageType\JPEG::___save($target_file);
                        break;
                    case IMAGETYPE_PNG:
                        require_once __DIR__ . "/ImageType/PNG.php";
                        return \IFaqih\IFImage\Component\ImageType\PNG::___save($target_file);
                        break;
                    case IMAGETYPE_WEBP:
                        require_once __DIR__ . "/ImageType/WEBP.php";
                        return \IFaqih\IFImage\Component\ImageType\WEBP::___save($target_file);
                        break;
                    default:
                        return false;
                        break;
                }
            } catch (Exception $e) {
                die("Error: " . $e->getMessage());
            }
        } else {
            return false;
        }
    }
}
