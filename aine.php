<?php
require __DIR__ . '/inc/kirjautuminen.php';
require __DIR__ . '/inc/aineet.php';

vaadi_rooli(['paakayttaja']);

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$tiedot = [
    'nimi' => '',
    'laajuus' => 15,
    'kori' => 1,
    'kuvaus' => '',
    'tai' => 0,
    'taynna' => 0,
];

if ($id !== null) {
    $tiedot = hae_aine($id);
    if ($tiedot === null) {
        http_response_code(404);
        $otsikko = 'Ei löydy';
        require __DIR__ . '/osat/ylaosa.php';
        echo '<h1>Valinnaista ei löydy</h1><p><a href="aineet.php">Takaisin listaan</a></p>';
        require __DIR__ . '/osat/alaosa.php';
        exit;
    }
}

$virheet = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$tiedot, $virheet] = lue_aine_lomake($_POST);

    if ($virheet === []) {
        tallenna_aine($id, $tiedot);
        aseta_ilmoitus('Valinnainen ' . $tiedot['nimi'] . ' tallennettiin.');
        header('Location: aineet.php');
        exit;
    }
}

$otsikko = $id === null ? 'Lisää valinnainen' : 'Muokkaa valinnaista';
require __DIR__ . '/osat/ylaosa.php';
?>
<h1><?= htmlspecialchars($otsikko) ?></h1>

<?php if ($virheet !== []): ?>
  <p class="virhe" role="alert">Tarkista merkityt kentät.</p>
<?php endif; ?>

<form method="post" class="kortti lomake">
  <label for="nimi">Nimi</label>
  <input type="text" id="nimi" name="nimi" required maxlength="100"
         value="<?= htmlspecialchars($tiedot['nimi']) ?>">
  <?php if (isset($virheet['nimi'])): ?>
    <p class="kentan-virhe"><?= htmlspecialchars($virheet['nimi']) ?></p>
  <?php endif; ?>

  <label for="laajuus">Laajuus</label>
  <select id="laajuus" name="laajuus">
    <?php foreach ([15, 30] as $osp): ?>
      <option value="<?= $osp ?>" <?= (int)$tiedot['laajuus'] === $osp ? 'selected' : '' ?>><?= $osp ?> osp</option>
    <?php endforeach; ?>
  </select>
  <?php if (isset($virheet['laajuus'])): ?>
    <p class="kentan-virhe"><?= htmlspecialchars($virheet['laajuus']) ?></p>
  <?php endif; ?>

  <label for="kori">Kori</label>
  <select id="kori" name="kori">
    <?php foreach (KORIT as $numero => $nimi): ?>
      <option value="<?= $numero ?>" <?= (int)$tiedot['kori'] === $numero ? 'selected' : '' ?>><?= $numero ?>: <?= htmlspecialchars($nimi) ?></option>
    <?php endforeach; ?>
  </select>
  <?php if (isset($virheet['kori'])): ?>
    <p class="kentan-virhe"><?= htmlspecialchars($virheet['kori']) ?></p>
  <?php endif; ?>

  <label for="kuvaus">Kuvaus</label>
  <textarea id="kuvaus" name="kuvaus" rows="5" required maxlength="2000"><?= htmlspecialchars($tiedot['kuvaus']) ?></textarea>
  <?php if (isset($virheet['kuvaus'])): ?>
    <p class="kentan-virhe"><?= htmlspecialchars($virheet['kuvaus']) ?></p>
  <?php endif; ?>

  <label class="valinta">
    <input type="checkbox" name="tai" <?= $tiedot['tai'] ? 'checked' : '' ?>>
    TAI-valinnainen
  </label>

  <label class="valinta">
    <input type="checkbox" name="taynna" <?= $tiedot['taynna'] ? 'checked' : '' ?>>
    Täynnä (ei voi enää valita)
  </label>

  <button type="submit">Tallenna</button>
  <a href="aineet.php">Peruuta</a>
</form>
<?php require __DIR__ . '/osat/alaosa.php'; ?>
