<!doctype html>
<html lang="fi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($otsikko) ?> | Ammatilliset valinnaiset</title>
  <link rel="stylesheet" href="css/tyyli.css">
</head>
<body>
<header class="ylapalkki">
  <div class="ylapalkki-sisus">
    <a class="sivuston-nimi" href="index.php">Ammatilliset valinnaiset</a>
    <?php if (kirjautunut()): ?>
      <nav class="valikko" aria-label="Päävalikko">
        <ul>
          <?php if ($_SESSION['rooli'] === 'opiskelija'): ?>
            <li><a href="opiskelija.php">Valinnaiset</a></li>
          <?php endif; ?>
          <?php if (in_array($_SESSION['rooli'], ['opettaja', 'paakayttaja'], true)): ?>
            <li><a href="opettaja.php">Valinnat</a></li>
          <?php endif; ?>
          <?php if ($_SESSION['rooli'] === 'paakayttaja'): ?>
            <li><a href="hallinta.php">Hallinta</a></li>
          <?php endif; ?>
        </ul>
      </nav>

      <form class="kayttaja" method="post" action="ulos.php">
        <span><?= htmlspecialchars($_SESSION['nimi']) ?> (<?= ROOLIT[$_SESSION['rooli']] ?>)</span>
        <button type="submit" class="painike-toissijainen">Kirjaudu ulos</button>
      </form>
    <?php endif; ?>
  </div>
</header>
<main>