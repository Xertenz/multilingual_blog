<?php

require './config/db.php';
require_once "./config/functions.php";
$lang = get_lang();
$dir = get_dir();
$page_title = $languages[$lang]['nav']['categories'];

$all_categories = get_categories($lang);

?>

	<?php require_once "./templates/header.php" ?>
	<?php require_once "./navbar.php" ?>

	<div class="categories-wrapper">
		<div class="container">
			<div class="row">
			<?php foreach ($all_categories as $category): ?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3">
					<article class="category">
						<a href='<?= "category.php?id=$category[id]&lang=$lang" ?>' class="category-link">
							<h2><?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?></h2>
							<span><?= htmlspecialchars($category['description'], ENT_QUOTES, 'UTF-8') ?></span>
							<hr />
						</a>
					</article>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	
	<?php require_once "./templates/footer.php" ?>
