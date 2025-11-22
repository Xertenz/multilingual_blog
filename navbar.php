<?php
$lang = get_lang();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
  <div class="container">
	<a class="navbar-brand" href="index.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['home'] ?></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?= SITE_URL ?>/categories.php?lang=<?=$lang?>"><?= $languages[$lang]['nav']['categories'] ?></a>
        </li>
        <li class="nav-item">
					<a class="nav-link" href="<?=SITE_URL?>/articles.php?lang=<?=$lang?>"><?=$languages[$lang]['nav']['articles']?></a>
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
