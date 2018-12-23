<?php

ini_set('display_errors', 1);

define('DSN', 'mysql:dbhost=localhost;dbname=book_db');
define('DB_USERNAME', 'dbuser');
define('DB_PASSWORD', '1234');

define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

define('MAX_FILE_SIZE', 1*1024*1024);//1MB
define('PROFILE_IMAGES_DIR', __DIR__ . '/../public_html/image/profile_images');
define('BOOK_IMAGES_DIR', __DIR__ . '/../public_html/image/book_images');


require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/../lib/autoload.php');

session_start();