<?php

namespace IFaqih\IFImage\Component\Information;

use IFaqih\IFImage\Component\Main;

class Information extends Main
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function __info(string $image_file): void
    {
        if (file_exists($image_file)) {
            $name = basename($image_file);
            $image_file = getimagesize($image_file);
            static::$data = [
                'name'          =>  $name,
                'width'         =>  $image_file[0],
                'height'        =>  $image_file[1],
                'type'          =>  $image_file[2],
                'mime_type'     =>  image_type_to_mime_type($image_file[2]),
                'extension'     =>  image_type_to_extension($image_file[2]),
                'color_depth'   => (isset($image_file['bits']) ? $image_file['bits'] : null),
                'color_channel' => (isset($image_file['channels']) ? $image_file['channels'] : null)
            ];
        }
    }
}
