<?php

require './config/db.php';
require_once "./config/functions.php";
$lang = get_lang();
$dir = get_dir();
$page_title = $languages[$lang]['nav']['articles'];

$all_articles = get_all_articles($lang);

?>

	<?php require_once './templates/header.php' ?>
	<?php require_once "./navbar.php" ?>

	<div class="articles-wrapper">
		<div class="container">
			<div class="row">
			<?php foreach ($all_articles as $article): ?>
				<div class="col-12 col-sm-6 col-md-4 col-lg-3">
					<article class="article">
						<a href='<?= "article.php?id=$article[article_id]&lang=$lang" ?>' class="article-link d-block">
							<div class="article-thumbnail">
								<?php
									$main_article_info = get_article_from_translation($article['article_id'], "featured_img");
									if($main_article_info['featured_img']):
										$thumb_path = FEATURED_UPLOAD_BASE_URL.'thumb_'.$main_article_info['featured_img'];
										$original_path = FEATURED_UPLOAD_BASE_URL . $main_article_info['featured_img'];
									?>
										<img src="<?php echo $thumb_path; ?>" 
											alt="<?php echo htmlspecialchars($article['title']); ?>"
											onerror="this.src='<?php echo $original_path; ?>'"
											loading="lazy"
											class="rounded-xl w-full"
											 />
									<?php else: ?>
										<div class="article-thumbnail no-image">
											📝 لا توجد صورة
										</div>
									<?php endif; ?>
							</div>
							<div class="article-info p-4">
								<h2 class="mb-2"><?= htmlspecialchars($article['title'], ENT_QUOTES, 'UTF-8') ?></h2>
								<!-- <span><?= $article['created_at'] ?></span> -->
								 <?php

									$article_info = get_article($lang, $article['article_id']);
									$category_info = get_category_translation($lang, $article_info['category_id']);
								 
									echo '<span class="">';
										echo $category_info['name'];
									echo '</span>';


								 ?>
							</div>
						</a>
					</article>
				</div>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	
	<?php require_once './templates/footer.php' ?>
