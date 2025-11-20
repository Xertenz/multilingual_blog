<?php

// ⭐⭐ إعدادات المسارات للسيرفر المحلي ⭐⭐
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST']; // localhost أو 127.0.0.1

// المسار الأساسي للموقع
$root = $_SERVER['DOCUMENT_ROOT']."/";
$site = "multilingual_blog/";
define('SITE_URL', $protocol . '://' . $host . '/multilingual_blog');
define('BASE_PATH', $root.$site);

// مسارات الرفع
define('UPLOAD_BASE_DIR', BASE_PATH . 'uploads/articles/images/contents/');
define('UPLOAD_BASE_URL', SITE_URL . '/uploads/articles/images/contents/');

define('FEATURED_UPLOAD_BASE_DIR', BASE_PATH . 'uploads/articles/images/featured/');
define('FEATURED_UPLOAD_BASE_URL', SITE_URL . '/uploads/articles/images/featured/');


?>