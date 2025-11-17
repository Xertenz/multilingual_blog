<?php
$lang = get_lang();
?>

<nav>
	<div class="container">
		<div class="logo-wrapper"></div>
		<div class="nav-menu-wrapper">
			<ul>
				<li>
					<a href="index.php?lang=<?=$lang?>"><?= $languages[$lang]['home'] ?></a>
				</li>
				<li>
					<a href="categories.php?lang=<?=$lang?>"><?= $languages[$lang]['categories'] ?></a>
				</li>
				<li>
					<a href="articles.php?lang=<?=$lang?>"><?= $languages[$lang]['articles'] ?></a>
				</li>
			</ul>
		</div>
	</div>
</nav>
