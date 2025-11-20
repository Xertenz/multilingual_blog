<?php

//require_once "config/db.php"; no need
require_once "config/functions.php";
$lang = get_lang();
$dir = get_dir();
$page_title = $languages[$lang]['nav']['home'];

?>


	<?php require_once "./templates/header.php" ?>
	<?php require_once "./navbar.php" ?>
	<?php require_once "./templates/footer.php" ?>
	
