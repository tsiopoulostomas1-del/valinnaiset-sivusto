<?php
require __DIR__ . '/inc/kirjautuminen.php';

vaadi_rooli(['paakayttaja']);

$otsikko = 'Hallinta';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1>Hallinta</h1>

<div class="kortti">
  <h2>Käyttäjät</h2>
  <p>Lisää, muokkaa ja poista opiskelijoita, opettajia ja pääkäyttäjiä.</p>
  <p><a href="kayttajat.php">Käyttäjien ylläpito</a></p>
</div>

<div class="kortti">
  <h2>Valinnaiset</h2>
  <p>Lisää, muokkaa ja poista ammatillisia valinnaisia.</p>
  <p><a href="aineet.php">Valinnaisten ylläpito</a></p>
</div>
<?php require __DIR__ . '/osat/alaosa.php'; ?>