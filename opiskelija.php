<?php
require __DIR__ . '/inc/kirjautuminen.php';
require __DIR__ . '/inc/aineet.php';

vaadi_rooli(['opiskelija']);

$aineet = hae_aineet();

$koreittain = [];
foreach ($aineet as $aine) {
    $kori = (int)$aine['kori'];
    $koreittain[$kori][] = $aine;
}

$otsikko = 'Valinnaiset';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1>Hei, <?= htmlspecialchars($_SESSION['nimi']) ?></h1>

<p>Valitse sääntöjen mukaisesti: Jos valitset TAI-valinnaisen, voit ottaa vain sen. Muuten voit valita korkeintaan yhden kurin Alkuviikosta ja yhden Loppuviikosta.</p>

<?php foreach (KORIT as $kori => $nimi): ?>
  <section class="kori">
    <h2><?= htmlspecialchars($nimi) ?></h2>
    <?php if (!isset($koreittain[$kori]) || $koreittain[$kori] === []): ?>
      <p>Ei valinnaisia.</p>
    <?php else: ?>
      <div class="aineet">
        <?php foreach ($koreittain[$kori] as $aine): ?>
          <article class="aine">
            <div class="aine-tiedot">
              <h3><?= htmlspecialchars($aine['nimi']) ?></h3>
              <span class="aine-laajuus"><?= (int)$aine['laajuus'] ?> osp</span>
              <?php if ($aine['tai']): ?><span class="merkki merkki-tai">TAI</span><?php endif; ?>
              <?php if ($aine['taynna']): ?><span class="merkki merkki-taynna">Täynnä</span><?php endif; ?>
            </div>
            <p><?= nl2br(htmlspecialchars($aine['kuvaus'])) ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
<?php endforeach; ?>

<?php require __DIR__ . '/osat/alaosa.php'; ?>
