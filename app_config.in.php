<?php

# ไฟล์นี้จะถูก include ในไฟล์ index.php ของแต่ละ ci project
# เพิื่อให้สามารถ กำหนด config ต่างๆ ที่ให้ร่วมกัน
# การต้ังชื่อ constant ต้องมี APP นำหน้า

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */

define('APP_ENVIRONMENT', 'development');
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') { //HTTPS 
    $myproto = 'https://';
} else {
    $myproto = 'http://';
}

define('APP_HOST_ADDRESS', getDomian());
define('APP_DB_HOST', 'localhost');
define('APP_DB_NAME', 'cmu_web');
define('APP_DB_USERNAME', 'root');
define('APP_DB_PASSWORD', '1234');
define('APP_SESSION', 'cmu_web_session');


define('APP_BASE_URL', getDomian());

define('APP_PHYSICAL_PATH', realpath(dirname(__FILE__)) . '/');
function getDomian()
{
    $domin_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/';
    $sub_dir = explode('/', $_SERVER['PHP_SELF']);
    $sub_dir = array_filter($sub_dir);

    $sub_dir = current($sub_dir);
    if (!empty($sub_dir) && $sub_dir != 'index.php') {
        $subName = $sub_dir . '/';
    } else {
        $subName = '/';
    }
    $domin_link = $domin_link . $subName;
    return $domin_link;
}



