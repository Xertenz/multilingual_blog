<?php

require_once '../config/variables.php';
require_once $root.$site."config/functions.php";
$lang = get_lang();
$dir = get_dir();


$categories = get_categories("ar");

?>


<!DOCTYPE html>
<html lang=<?=$lang?>>
<head>
    <meta charset="utf-8">
    <title>إضافة مقالة جديدة</title>
</head>
<body dir=<?=$dir?>>
    <h1>إضافة مقالة جديدة</h1>
    <form method="post" enctype="multipart/form-data">
        <select name="category_id">
            <?php foreach ($categories as $category): ?>
            <option value=<?=$category["category_id"]?>><?= $category["name"] ?></option>
            <?php endforeach; ?>
        </select>
        <br />
        <input type="text" name="title" id='title' />
        <br />
        <input type="file" name="featured_img" id="featured_img" />
        <br />
        <input type="text" name="meta_title" id='meta_title' placeholder="عنوان الميتا" />
        <br />
        <input type="text" name="meta_description" id='meta_description' placeholder="وصف الميتا" />
        <br />
        <textarea name="content" id="editor"></textarea>
        <input type="submit" name="submit" value="Submit" />
    </form>

    <script src="public/assets/js/tinymce/tinymce.min.js"></script>
    <script src="public/assets/js/main.js">
    </script>

</body>
</html>

