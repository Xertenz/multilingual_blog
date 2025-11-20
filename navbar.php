<?php
$lang = get_lang();
?>

<!--
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
-->

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
  <div class="container-fluid">
	<a class="navbar-brand" href="index.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['home'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="categories.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['categories'] ?></a>
        </li>
        <li class="nav-item">
					<a class="nav-link" href="articles.php?lang=<?=$lang?>"><?=$languages[$lang]['nav']['articles']?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Pricing</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
