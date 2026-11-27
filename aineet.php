<?php
require __DIR__ . '/inc/kirjautuminen.php';
require __DIR__ . '/inc/aineet.php';

vaadi_rooli(['paakayttaja']);

$aineet = hae_aineet();

$otsikko = 'Valinnaisten ylläpito';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1>Valinnaisten ylläpito</h1>

<p><a href="aine.php">Lisää valinnainen</a></p>

<?php if ($aineet === []): ?>
  <p>Valinnaisia ei vielä ole.</p>
<?php else: ?>
  <div class="taulukko-kehys">
    <table class="taulukko">
      <thead>
        <tr>
          <th>Nimi</th>
          <th>Laajuus</th>
          <th>Kori</th>
          <th>Tiedot</th>
          <th>Toiminnot</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($aineet as $aine): ?>
          <tr>
            <td><?= htmlspecialchars($aine['nimi']) ?></td>
            <td><?= (int)$aine['laajuus'] ?> osp</td>
            <td><?= htmlspecialchars(KORIT[(int)$aine['kori']]) ?></td>
            <td>
              <?php if ($aine['tai']): ?><span class="merkki">TAI</span><?php endif; ?>
              <?php if ($aine['taynna']): ?><span class="merkki merkki-taynna">Täynnä</span><?php endif; ?>
            </td>
            <td class="toiminnot">
              <a href="aine.php?id=<?= (int)$aine['id'] ?>">Muokkaa</a>
              <form method="post" action="poista_aine.php"
                    onsubmit="return confirm('Poistetaanko tämä valinnainen?');">
                <input type="hidden" name="id" value="<?= (int)$aine['id'] ?>">
                <button type="submit" class="painike-linkki">Poista</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
<?php require __DIR__ . '/osat/alaosa.php'; ?>
