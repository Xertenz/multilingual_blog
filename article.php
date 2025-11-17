<?php

require './config/db.php';
require_once "./config/functions.php";
$lang = get_lang();
$dir = get_dir();

$article_id = $_GET['id'];

if(isset($article_id) && $article_id != '' && (int)$article_id == $article_id) {
	$article_id = (int)$_GET['id'];
}else{
	redirect_to_home();
}

$article_info = get_article($lang, $article_id);
$category_info = get_category_translation($lang, $article_info['category_id']);

?>

<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= htmlspecialchars($article_info['meta_title']) ?></title>
		<meta name="description" content="<?= htmlspecialchars($article_info['meta_description']) ?>" />
		<link href="public/assets/css/style.css" rel="stylesheet">
	</head>
	<body>

	<?php require_once "./navbar.php" ?>

	<div class="article-wrapper">
		<article>
			<header>
				<h1><?= htmlspecialchars($article_info['title']) ?></h1>
				<p><?= htmlspecialchars($article_info['description']) ?></p>
			</header>
			<div class="article-info">
				<ul>
					<li><?= date("Y-m-d", strtotime($article_info['updated_at']))?></li>
					<li><?= $category_info['name'] ?></li>
				</ul>
			</div>
		</article>
	</div>
	
	</body>
</html>
