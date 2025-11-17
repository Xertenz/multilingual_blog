<?php

$servername = "localhost";
$database = "multilingual_blog";
$username = "ahmed";
$password = "toor";


try {
	$conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo 'Connected successfully';
}catch(PDOException $e) {
	//echo "connection failed: ".$e->getMessage();
	echo 'error in connecting to database';
	die();
}


?>
