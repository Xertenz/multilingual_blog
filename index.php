<?php

require_once "config/db.php";
require_once "config/functions.php";
$lang = get_lang();
$dir = get_dir();

?>

<!DOCTYPE html>
<html lang="<?=$lang?>" dir="<?=$dir?>">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>this is the title here</title>
		<link href="public/assets/css/style.css" rel="stylesheet">
	</head>
	<body>

	<?php require_once "./navbar.php" ?>
	
	</body>
</html>
