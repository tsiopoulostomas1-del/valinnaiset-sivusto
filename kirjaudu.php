<?php
require __DIR__ . '/inc/kirjautuminen.php';

// Kirjautunut käyttäjä ei tarvitse kirjautumissivua.
if (kirjautunut()) {
    header('Location: ' . roolin_etusivu($_SESSION['rooli']));
    exit;
}

$virhe = '';
$sahkoposti = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sahkoposti = trim($_POST['sahkoposti'] ?? '');
    $salasana = $_POST['salasana'] ?? '';

    $kysely = yhteys()->prepare(
        'SELECT id, nimi, rooli, salasana FROM kayttaja WHERE sahkoposti = ?'
    );
    $kysely->execute([$sahkoposti]);
    $kayttaja = $kysely->fetch();

    if ($kayttaja && $kayttaja['salasana'] !== null
        && password_verify($salasana, $kayttaja['salasana'])) {
        session_regenerate_id(true);
        $_SESSION['kayttaja_id'] = (int)$kayttaja['id'];
        $_SESSION['nimi'] = $kayttaja['nimi'];
        $_SESSION['rooli'] = $kayttaja['rooli'];

        header('Location: ' . roolin_etusivu($kayttaja['rooli']));
        exit;
    }

    $virhe = 'Sähköposti tai salasana ei täsmää.';
}

$otsikko = 'Kirjaudu';
require __DIR__ . '/osat/ylaosa.php';
?>
<div class="kirjautuminen kortti">
  <h1>Kirjaudu</h1>
    <?php if ($virhe !== ''): ?>
    <p class="virhe" role="alert"><?= htmlspecialchars($virhe) ?></p>
  <?php endif; ?>

  <form method="post">
    <label for="sahkoposti">Sähköposti</label>
    <input type="email" id="sahkoposti" name="sahkoposti" required
           autocomplete="username">

    <label for="salasana">Salasana</label>
    <input type="password" id="salasana" name="salasana" required
           autocomplete="current-password">

    <button type="submit">Kirjaudu</button>
  </form>
</div>
<?php require __DIR__ . '/osat/alaosa.php'; ?>