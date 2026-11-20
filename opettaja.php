<?php
require __DIR__ . '/inc/kirjautuminen.php';

vaadi_rooli(['opettaja']);

$otsikko = 'Valinnat';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1>Hei, <?= htmlspecialchars($_SESSION['nimi']) ?></h1>

<div class="kortti">
  <p>Opiskelijoiden valinnat. Tälle sivulle tulee valintojen hallinta.</p>
</div>
<?php require __DIR__ . '/osat/alaosa.php'; ?>