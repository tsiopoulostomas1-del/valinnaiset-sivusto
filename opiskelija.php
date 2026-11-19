<?php
require __DIR__ . '/inc/kirjautuminen.php';

vaadi_kirjautuminen();

$otsikko = 'Valinnaiset';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1>Hei, <?= htmlspecialchars($_SESSION['nimi']) ?></h1>

<div class="kortti">
  <p>Tällä sivulla näet pian ammatilliset valinnaiset ja voit tehdä valintasi.</p>
</div>
<?php require __DIR__ . '/osat/alaosa.php'; ?>