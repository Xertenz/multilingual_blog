<?php

require_once 'variables.php';
require_once $root.$site."config/db.php";
require_once $root.$site."config/translations.php";

function get_lang() {
	global $languages;
	$lang = isset($_GET['lang']) && in_array($_GET['lang'], array_keys($languages)) ? $_GET['lang']: 'en';
	return $lang;
}

function redirect_to_home() {
	header("Location: index.php");
	die;
}

function get_dir() {
	global $languages;
	$lang = isset($_GET['lang']) && in_array(strtolower($_GET['lang']), array_keys($languages)) ? $_GET['lang']: 'en';
	return ($lang == 'ar') ? 'rtl' : 'ltr';
}

function get_all_articles($lang) {
	global $conn;
	$sql = "SELECT * FROM article_translations WHERE language_code = :language_code";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":language_code", $lang);
	$stmt->execute();
	$all_articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $all_articles;
}

function get_article($lang, $article_id) {
	global $conn;
	$sql = "SELECT * FROM article_translations at JOIN articles a ON at.article_id = a.id WHERE a.id=:id AND at.language_code=:language_code";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":language_code", $lang);
	$stmt->bindParam(":id", $article_id);
	$stmt->execute();
	$article_info = $stmt->fetch(PDO::FETCH_ASSOC);
	return $article_info;
}

function get_categories($lang) {
	global $conn;
	$sql = "SELECT * FROM category_translations ct WHERE ct.language_code = :language_code";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(":language_code", $lang);
	$stmt->execute();
	$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $categories;
}

function get_category_translation($lang, $category_id) {
	global $conn;
	$sql = "SELECT * FROM category_translations ct WHERE ct.category_id = ? AND ct.language_code = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$category_id, $lang]);
	$category_info = $stmt->fetch(PDO::FETCH_ASSOC);
	return $category_info;
}



?>
