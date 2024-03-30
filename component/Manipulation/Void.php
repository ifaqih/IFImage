<?php

try {
    define('IFIMAGE_NAME_WITH_SIZE', 1);
    define('IFIMAGE_NAME_WITH_OLD_EXTENSION', 2);
    define('IFIMAGE_NAME_WITH_OLD_EXTENSION_IF_CONVERT', 4);
    define('IFIMAGE_FORCE_CREATE_DIRECTORY', 8);

    require_once __DIR__ . "/../Main.php";
    require_once __DIR__ . "/../Information/Information.php";
    require_once __DIR__ . "/Manipulation.php";
    require_once __DIR__ . "/ImageType/AbstractType.php";
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
