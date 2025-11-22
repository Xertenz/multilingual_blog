<?php

require './config/db.php';
require_once "./config/functions.php";
$lang = get_lang();
$dir = get_dir();

// Get article id and check it to be an 'int' number
$article_id = $_GET['id'];
if(isset($article_id) && $article_id != '' && (int)$article_id == $article_id) {
	$article_id = (int)$_GET['id'];
}else{
	redirect_to_home($lang);
}

// Get info about the article and it's category
$article_info = get_article($lang, $article_id);
$category_info = get_category_translation($lang, $article_info['category_id']);

// Get meta title and meta description
$page_title = htmlspecialchars($article_info['meta_title'], ENT_QUOTES, 'UTF-8');
$meta_description = htmlspecialchars($article_info['meta_description'], ENT_QUOTES, 'UTF-8');

?>

	<?php require_once './templates/header.php'; ?>

	<?php require_once "./navbar.php" ?>

	<div class="article-wrapper">
		<div class="container">
			<article>
				<div class="article-title">
					<h1 class=""><?= htmlspecialchars($article_info['title'], ENT_QUOTES, 'UTF-8') ?></h1>
				</div>
				<div class="article-content">
					<p><?= $article_info['description'] ?></p>
					</div>
				<div class="article-info">
					<ul>
						<li><?= date("Y-m-d", strtotime($article_info['updated_at']))?></li>
						<li><?= $category_info['name'] ?></li>
					</ul>
				</div>
			</article>
		</div>
	</div>
	
	<?php require_once './templates/footer.php'; ?>
