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
          <!-- Tee itse: Valinnat ja Hallinta -->
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
</main>
<footer class="alaosa">
  <p>Ammatilliset valinnaiset · harjoitusprojekti</p>
</footer>
</body>
</html>