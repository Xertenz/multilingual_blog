<?php
$lang = get_lang();
?>

<nav class="bg-red-200 mb-6">
	<div class="container mx-auto flex">
		<div class="logo-wrapper"></div>
		<div class="nav-menu-wrapper">
			<ul class="flex">
				<li>
					<a href="index.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['home'] ?></a>
				</li>
				<li>
					<a href="categories.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['categories'] ?></a>
				</li>
				<li>
					<a href="articles.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['articles'] ?></a>
				</li>
			</ul>
		</div>
	</div>
</nav>
