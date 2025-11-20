<?php

require_once '../config/variables.php';
require_once $root.$site."config/functions.php";
$lang = get_lang();
$dir = get_dir();

$categories = get_categories("ar");

$errors = [];
// Inserting article data
if($_SERVER['REQUEST_METHOD'] == "POST") {


    $cat_id = (int)$_POST['category_id'];
    if(!category_exists($cat_id)) {
        $errors[] = "هذا التصنيف ليس ضمن التصنيفات";
    }

    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    if(strlen($title) == 0) {
        $errors[] = "يجب إعطاء عنوان للمقال";
    }
    $description = $_POST['content'];
    if(strlen($description) == 0) {
        $errors[] = "يجب وضع شرح المقال بالكامل";
    }
    $featured_img = $_FILES['featured_img'];

    if($featured_img['error'] != 0) {
        $errors[] = "يجب رفع ملف للمقال";
    }elseif( !check_img_ext($featured_img) ) {
        $errors[] = "يجب رفع صورة للمقالة وليس ملف اخر";
    }

    $meta_title = htmlspecialchars( trim($_POST['meta_title']) , ENT_QUOTES, 'UTF-8');
    if(strlen($meta_title) == 0) {
        $errors[] = "يجب إعطاء عنوان ليضهر في وسم title لصفحة المقال";
    }
    $meta_description = htmlspecialchars( trim($_POST['meta_description']) , ENT_QUOTES, 'UTF-8');
    if(strlen($meta_description) == 0) {
        $errors[] = "يجب إعطاء وصف للمقال ليضهر في محركات البحث ";
    }

    if(count($errors) == 0) {
        $featured_img_info = uploadAndOptimizeFeaturedImage($featured_img);
        $featured_img_main_name = $featured_img_info['main_image'];


        add_new_arabic_article($cat_id, $featured_img_main_name, $title, $description, $meta_title, $meta_description);
    }
}

?>

<!DOCTYPE html>
<html lang=<?=$lang?> dir=<?=$dir?>>
<head>
    <meta charset="utf-8">
    <title>إضافة مقالة جديدة</title>
</head>
<body>
    <h1>إضافة مقالة جديدة</h1>
    <?php
    if(count($errors) != 0) {
        foreach($errors as $error) {
            echo $error."<br />";
        }
    }
    ?>
    <form method="post" enctype="multipart/form-data">
        <select name="category_id">
            <?php foreach ($categories as $category): ?>
            <option value=<?=$category["category_id"]?>><?= htmlspecialchars($category["name"], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>
        <br />
        <input type="text" name="title" id='title' placeholder="عنوان المقالة" value="<?= array_key_exists('title', $_POST) ? $_POST['title'] : "" ?>" />
        <br />
        <input type="file" name="featured_img" id="featured_img" />
        <br />
        <input type="text" name="meta_title" id='meta_title' placeholder="عنوان الميتا"  value="<?= array_key_exists('meta_title', $_POST) ? $_POST['meta_title'] : "" ?>"/>
        <br />
        <input type="text" name="meta_description" id='meta_description' placeholder="وصف الميتا"  value="<?= array_key_exists('meta_description', $_POST) ? $_POST['meta_description'] : "" ?>"/>
        <br />
        <textarea name="content" id="editor"><?= array_key_exists('content', $_POST) ? $_POST['content'] : "" ?></textarea>
        <input type="submit" name="submit" value="Submit" />
    </form>

    <script src="public/assets/js/tinymce/tinymce.min.js"></script>
    <script src="public/assets/js/main.js">
    </script>

</body>
</html>

