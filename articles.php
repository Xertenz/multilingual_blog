<?php

require './config/db.php';
require_once "./config/functions.php";
$lang = get_lang();
$dir = get_dir();
$all_articles = get_all_articles($lang);

?>

<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= $languages[$lang]['articles'] ?></title>
		<link href="public/assets/css/style.css" rel="stylesheet">
	</head>
	<body>

	<?php require_once "./navbar.php" ?>

	<div class="articles-wrapper">
		<?php foreach ($all_articles as $article): ?>
		<article class="article">
			<a href='<?= "article.php?id=$article[id]&lang=$lang" ?>' class="article-link">
				<h2><?= htmlspecialchars($article['title']) ?></h2>
				<span><?= htmlspecialchars($article['created_at']) ?></span>
				<hr />
			</a>
		</article>
		<?php endforeach; ?>
	</div>
	
	</body>
</html>
