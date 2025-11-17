<?php

require './config/db.php';
require_once "./config/functions.php";
$lang = get_lang();
$dir = get_dir();
$all_categories = get_categories($lang);

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

	<div class="categories-wrapper">
		<?php foreach ($all_categories as $category): ?>
		<article class="category">
			<a href='<?= "category.php?id=$category[id]&lang=$lang" ?>' class="category-link">
				<h2><?= htmlspecialchars($category['name']) ?></h2>
				<span><?= htmlspecialchars($category['description']) ?></span>
				<hr />
			</a>
		</article>
		<?php endforeach; ?>
	</div>
	
	</body>
</html>
