<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= $page_title ?></title>
		<?php if(isset($meta_description)): ?>
		<meta name="description" content="<?= $meta_description ?>" />
		<?php endif; ?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400..700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
		<link href='public/assets/css/style.css' rel='stylesheet' />
		<?php
		if (preg_match("/admin/", $_SERVER["REQUEST_URI"])) {
			echo '<link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">';
		}else{
			echo '<link href="public/assets/css/bootstrap.min.css" rel="stylesheet">';
		}
		?>
		<!-- <script src="https://cdn.tailwindcss.com"></script> -->
	</head>
	<body lang="<?=$lang?>" dir="<?=$dir?>">