<?php

namespace IFaqih\IFImage;

require_once __DIR__ . "/../component/Information/Void.php";


use IFaqih\IFImage\Component\Information\Information;

class ImageInfo extends Information
{

    /**
     * Mendapatkan informasi dari gambar.
     *
     * @param string $image_file Path file gambar.
     * @return object{name:string,width:int,height:int,type:int,mime_type:string,extension:string,color_depth:int,color_channel:int}
     * @property string name Nama file.
     * @property int width Lebar gambar.
     * @property int height Tinggi gambar.
     * @property int type Tipe gambar (konstanta IMAGETYPE).
     * @property string mime_type Tipe mime gambar.
     * @property string extension Ekstensi gambar.
     * @property int color_depth Kedalaman warna gambar (dalam bit).
     * @property int color_channel Jumlah saluran warna primer gambar.
     */
    public static function info(string $image_file): object
    {
        $info = new self();
        $info->__info($image_file);

        return json_decode(json_encode(static::$data));
    }
}
