<?php

namespace IFaqih\IFImage\Component;

class Main
{
    protected static $data = [
        'name'          =>  null,
        'width'         =>  null,
        'height'        =>  null,
        'type'          =>  null,
        'mime_type'     =>  null,
        'extension'     =>  null,
        'color_depth'   =>  null,
        'color_channel' =>  null
    ];

    public function __construct()
    {
    }

    protected function getting_image_info(string $image_file)
    {
        $info = new \IFaqih\IFImage\Component\Information\Information();

        $info->__info($image_file);

        return (!empty(static::$data['name']) && !empty(static::$data['width']) && !empty(static::$data['height']) && !empty(static::$data['type']) && !empty(static::$data['mime_type']) && !empty(static::$data['extension']));
    }
}
