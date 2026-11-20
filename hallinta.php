<?php
require __DIR__ . '/inc/kirjautuminen.php';

vaadi_rooli(['paakayttaja']);

$otsikko = 'Hallinta';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1>Hei, <?= htmlspecialchars($_SESSION['nimi']) ?></h1>

<div class="kortti">
  <p>Täällä voit hallita opiskelijoiden valintoja ja lomakkeita.</p>
</div>
<?php require __DIR__ . '/osat/alaosa.php'; ?>