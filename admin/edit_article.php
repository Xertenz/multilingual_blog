<?php

require_once '../config/variables.php';
require_once $root.$site."config/functions.php";
$lang = get_lang();
$dir = get_dir();

// Get article id and check it to be an 'int' number
$article_id = $_GET['id'];
if(isset($article_id) && $article_id != '' && (int)$article_id == $article_id) {
	$article_id = (int)$_GET['id'];
}else{
	redirect_to_home($lang);
}

$article_info = get_article($lang, $article_id);
//$cat_translation = get_category_translation($lang, $article_info['category_id']);
$categories = get_categories($lang);

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

    $slug = htmlspecialchars($_POST['slug'], ENT_QUOTES, 'UTF-8');
    if(strlen($slug) == 0) {
        $errors[] = "يجب اضافة slug ليظهر في رابط المقالة";
    }
	//Checking slug existence
	if(is_article_slug_exists($slug, $article_info["id"])) {
		$errors[] = "هذا الـ slug موجود بالفعل لمقالة بهذه اللغة";
	}

    $description = $_POST['content'];
    if(strlen($description) == 0) {
        $errors[] = "يجب وضع شرح المقال بالكامل";
    }


    $meta_title = htmlspecialchars( trim($_POST['meta_title']) , ENT_QUOTES, 'UTF-8');
    if(strlen($meta_title) == 0) {
        $errors[] = "يجب إعطاء عنوان ليظهر في وسم title لصفحة المقال";
    }
    $meta_description = htmlspecialchars( trim($_POST['meta_description']) , ENT_QUOTES, 'UTF-8');
    if(strlen($meta_description) == 0) {
        $errors[] = "يجب إعطاء وصف للمقال ليظهر في محركات البحث ";
    }


    if(count($errors) == 0) {

        $featured_img = $_FILES['featured_img'];
        if($featured_img['error'] != 0) {
            //$errors[] = "يجب رفع ملف للمقال";
            update_article($lang, $article_id, $cat_id, $slug, $title, $description, $meta_title, $meta_description);
            $article_info = get_article($lang, $article_id);
        }elseif( !check_img_ext($featured_img) ) {
            $errors[] = "يجب رفع صورة للمقالة وليس ملف اخر";
        }else{
            update_article($lang, $article_id, $cat_id, $slug, $title, $description, $meta_title, $meta_description, $featured_img);
        }





        /*
        $featured_img_info = uploadAndOptimizeFeaturedImage($featured_img);
        $featured_img_main_name = $featured_img_info['main_image'];


        add_new_arabic_article($cat_id, $slug, $featured_img_main_name, $title, $description, $meta_title, $meta_description);
        */
    }
}

?>

		<?php
			$page_title = "تعديل المقالة";
			require_once 'templates/header.php'; 
		?>
		<?php require_once $root.$site."navbar.php"; ?>
		<div class="article-form-wrapper pb-5">
			<div class="container">
				<h1 class="text-center mb-3">تعديل المقالة</h1>
				<?php
				if($_SERVER['REQUEST_METHOD'] == "POST") {
					if(count($errors) != 0) {
						foreach($errors as $error) {
							echo "<div class='p-2 mb-2 text-danger bg-danger-subtle border border-danger-subtle rounded-3'>";
								echo "<p class='m-0 fw-bold'>$error</p>";
							echo "</div>";
						}
					}else{
						echo "<div class='p-2 mb-2 text-success bg-success-subtle border border-success-subtle rounded-3'>";
							echo "<p class='m-0 fw-bold'>تم تعديل المقالة بنجاح</p>";
						echo "</div>";
					}
				}
				?>
				<form method="post" enctype="multipart/form-data">
						<div class="mb-3 row">
								<label for="category_id" class="col-sm-3 col-form-label">التصنيف</label>
								<div class="col-sm-3">
									<select name="category_id" id="category_id" class="form-control rounded-0">
											<?php foreach ($categories as $category): ?>
											<option value=<?=$category["category_id"]?> <?= $category['category_id'] == $article_info['category_id'] ? "selected":"" ?>><?= htmlspecialchars($category["name"], ENT_QUOTES, 'UTF-8') ?></option>
											<?php endforeach; ?>
									</select>
								</div>
						</div>

						<div class="mb-3">
							<div class="row">
								<div class="col-12 col-sm-8 mb-3 mb-sm-0">
									<input type="text" name="title" id='title' class="form-control rounded-0" placeholder="عنوان المقالة" autocomplete="off" value="<?= $article_info['title'] ?>" />
								</div>
								<div class="col-12 col-sm-4">
									<input type="text" name="slug" id='slug' class="form-control rounded-0" placeholder="رابط slug" autocomplete="off" value="<?= $article_info['slug'] ?>" />
								</div>
							</div>
						</div>
						<div class="mb-3">
							<div class="row">
								<label for="featured_img" class="col-12 col-sm-4 col-form-label">اختر صورة featured</label>
								<div class="col-12 col-sm-8">
									<input type="file" name="featured_img" id="featured_img" class="form-control rounded-0" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="mb-3 col-12 col-sm-6">
									<input type="text" name="meta_title" id='meta_title' class="form-control rounded-0" placeholder="عنوان الميتا" autocomplete="off"  value="<?= $article_info['meta_title'] ?>"/>
							</div>
							<div class="mb-3 col-12 col-sm-6">
								<input type="text" name="meta_description" id='meta_description' class="form-control rounded-0" placeholder="وصف الميتا" autocomplete="off" value="<?=  $article_info['meta_description'] ?>"/>
							</div>
						</div>
						<div class="mb-3">
							<textarea name="content" id="editor" class=""><?= $article_info['description'] ?></textarea>
						</div>
						<div>
							<input type="submit" name="submit" value="إنشاء المقال" class="btn btn-primary rounded-0" />
						</div>
				</form>
			</div>
		</div>

    <script src="public/assets/js/tinymce/tinymce.min.js"></script>
    <script src="public/assets/js/main.js">
    </script>

</body>
</html>

