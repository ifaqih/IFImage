<?php

try {
    define('IFIMAGE_NAME_WITH_SIZE', 1);
    define('IFIMAGE_NAME_WITH_OLD_EXTENSION', 2);
    define('IFIMAGE_FORCE_CREATE_DIRECTORY', 4);

    require_once "Main.php";
    require_once "ImageType/AbstractType.php";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
