<?php

require_once 'variables.php';
require_once $root.$site."config/db.php";
require_once $root.$site."config/translations.php";

function get_lang() {
	global $languages;
	$lang = isset($_GET['lang']) && in_array($_GET['lang'], array_keys($languages)) ? $_GET['lang']: 'en';
	return $lang;
}

function redirect_to_home() {
	header("Location: index.php");
	die;
}

function get_dir() {
	global $languages;
	$lang = isset($_GET['lang']) && in_array(strtolower($_GET['lang']), array_keys($languages)) ? $_GET['lang']: 'en';
	return ($lang == 'ar') ? 'rtl' : 'ltr';
}

function get_all_articles($lang) {
	global $conn;
	$sql = "SELECT * FROM article_translations WHERE language_code = :language_code";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":language_code", $lang);
	$stmt->execute();
	$all_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $all_articles;
}

function get_article($lang, $article_id) {
	global $conn;
	$sql = "SELECT * FROM article_translations at JOIN articles a ON at.article_id = a.id WHERE at.id=:id AND at.language_code=:language_code";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":language_code", $lang);
	$stmt->bindParam(":id", $article_id);
	$stmt->execute();
	$article_info = $stmt->fetch(PDO::FETCH_ASSOC);
	return $article_info;
}

function get_categories($lang) {
	global $conn;
	$sql = "SELECT * FROM category_translations ct WHERE ct.language_code = :language_code";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":language_code", $lang);
	$stmt->execute();
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $categories;
}

function get_category_translation($lang, $category_id, $columns=null) {
	global $conn;
	if($columns) {

		$sql = "SELECT $columns FROM category_translations ct WHERE ct.category_id = ? AND ct.language_code = ?";
	}else{

		$sql = "SELECT * FROM category_translations ct WHERE ct.category_id = ? AND ct.language_code = ?";
	}
	$stmt = $conn->prepare($sql);
	$stmt->execute([$category_id, $lang]);
	$category_info = $stmt->fetch(PDO::FETCH_ASSOC);
	return $category_info;
}

function uploadAndOptimizeFeaturedImage($uploaded_file) {
    $max_width = 1200;
    $max_height = 630;
    $max_file_size = 500 * 1024; // 500KB
    $quality = 80; // نسبة الجودة
    
    // التحقق من حجم الملف
    if ($uploaded_file['size'] > 1000 * 1024) { // 1MB
        throw new Exception('حجم الملف كبير جداً. الحد الأقصى 1MB');
    }
    
    //$upload_dir = '../uploads/articles/images/featured/';
    $upload_dir = FEATURED_UPLOAD_BASE_DIR;
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // الحصول على معلومات الصورة
    list($original_width, $original_height, $image_type) = getimagesize($uploaded_file['tmp_name']);
    
    // حساب الأبعاد الجديدة مع الحفاظ على النسبة
    $ratio = $original_width / $original_height;
    
    if ($ratio > 1.91) { // أوسع من المطلوب
        $new_width = $max_width;
        $new_height = $max_width / $ratio;
    } else { // أطول من المطلوب
        $new_height = $max_height;
        $new_width = $max_height * $ratio;
    }
    
    // إنشاء الصورة المصغرة المحسنة
    $optimized_image = imagecreatetruecolor($new_width, $new_height);
    
    // تحميل الصورة الأصلية حسب النوع
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $source_image = imagecreatefromjpeg($uploaded_file['tmp_name']);
            break;
        case IMAGETYPE_PNG:
            $source_image = imagecreatefrompng($uploaded_file['tmp_name']);
            // الحفاظ على الشفافية في PNG
            imagealphablending($optimized_image, false);
            imagesavealpha($optimized_image, true);
            $transparent = imagecolorallocatealpha($optimized_image, 255, 255, 255, 127);
            imagefilledrectangle($optimized_image, 0, 0, $new_width, $new_height, $transparent);
            break;
        case IMAGETYPE_WEBP:
            $source_image = imagecreatefromwebp($uploaded_file['tmp_name']);
            break;
        default:
            throw new Exception('نوع الصورة غير مدعوم');
    }
    
    // تحجيم الصورة
    imagecopyresampled($optimized_image, $source_image, 0, 0, 0, 0, 
                      $new_width, $new_height, $original_width, $original_height);
    
    // إنشاء اسم فريد للملف
    $file_extension = pathinfo($uploaded_file['name'], PATHINFO_EXTENSION);
    $unique_name = 'featured_opt_' . uniqid() . '.' . $file_extension;
    $optimized_path = $upload_dir . $unique_name;
    
    // حفظ الصورة المحسنة
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            imagejpeg($optimized_image, $optimized_path, $quality);
            break;
        case IMAGETYPE_PNG:
            imagepng($optimized_image, $optimized_path, 9); // ضغط PNG
            break;
        case IMAGETYPE_WEBP:
            imagewebp($optimized_image, $optimized_path, $quality);
            break;
    }
    
    // تحرير الذاكرة
    imagedestroy($source_image);
    imagedestroy($optimized_image);
    
    // إنشاء نسخة thumbnail أصغر
    createThumbnail($optimized_path, $upload_dir . 'thumb_' . $unique_name, 400, 250, 70);

	/**
	 Array
			(
				[main_image] => featured_opt_691cc29ce952a.jpg
				[thumb_image] => thumb_featured_opt_691cc29ce952a.jpg
				[original_size] => 198733
				[optimized_size] => 121507
				[reduction] => 38.86
			)
	 */
    return [
        'main_image' => $unique_name,
        'thumb_image' => 'thumb_' . $unique_name,
        'original_size' => $uploaded_file['size'],
        'optimized_size' => filesize($optimized_path),
        'reduction' => round((1 - filesize($optimized_path) / $uploaded_file['size']) * 100, 2)
    ];
}

function createThumbnail($source_path, $dest_path, $width, $height, $quality) {
    list($src_width, $src_height, $type) = getimagesize($source_path);
    
    switch ($type) {
        case IMAGETYPE_JPEG: $src_image = imagecreatefromjpeg($source_path); break;
        case IMAGETYPE_PNG: $src_image = imagecreatefrompng($source_path); break;
        case IMAGETYPE_WEBP: $src_image = imagecreatefromwebp($source_path); break;
        default: return false;
    }
    
    $thumb = imagecreatetruecolor($width, $height);
    
    // الحفاظ على الشفافية للPNG
    if ($type === IMAGETYPE_PNG) {
        imagealphablending($thumb, false);
        imagesavealpha($thumb, true);
        $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
        imagefilledrectangle($thumb, 0, 0, $width, $height, $transparent);
    }
    
    imagecopyresampled($thumb, $src_image, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
    
    switch ($type) {
        case IMAGETYPE_JPEG: imagejpeg($thumb, $dest_path, $quality); break;
        case IMAGETYPE_PNG: imagepng($thumb, $dest_path, 8); break;
        case IMAGETYPE_WEBP: imagewebp($thumb, $dest_path, $quality); break;
    }
    
    imagedestroy($src_image);
    imagedestroy($thumb);
    return true;
}

function category_exists($category_id) {
	global $conn;
	$sql = "SELECT id FROM categories WHERE id = ? LIMIT 1";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$category_id]);
	$category_row = $stmt->fetch(PDO::FETCH_ASSOC);
	return $stmt->rowCount();
}

function add_new_arabic_article($category_id, $slug, $featured_img, $title, $description, $meta_title, $meta_description) {
	global $conn;
	$sql = "INSERT INTO articles (category_id, slug, featured_img, views, status) VALUES (?, ?, ?, 0, 'published' )";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$category_id, $slug, $featured_img]);

	$sql = "INSERT INTO article_translations (article_id, language_code, title, description, meta_title, meta_description, created_at, updated_at) 
VALUES (LAST_INSERT_ID(), 'ar', ?, ?, ?, ?, CURRENT_DATE(), CURRENT_DATE())";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$title, $description, $meta_title, $meta_description]);
}

function check_img_ext($file) {
	$allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
	$file_name = $file['name'];
	$file_parts = explode('.', $file_name)  ;
	$file_ext = strtolower(end( $file_parts ));
	return in_array($file_ext, $allowed_exts) ? true : false;

	/*
	return $file_ext;
	*/
}

function get_article_from_translation($article_id, $columns=null) {
	global $conn;
	if($columns) {
		$sql = "SELECT $columns FROM articles WHERE id = ?";
	}else{
		$sql = "SELECT * FROM articles WHERE id = ?";

	}
	$stmt = $conn->prepare($sql);
	$stmt->execute([$article_id]);
	$main_article = $stmt->fetch(PDO::FETCH_ASSOC);
	return $main_article;
}


?>
