<?php
$otsikko = 'Kirjaudu';
require __DIR__ . '/osat/ylaosa.php';
?>
<div class="kirjautuminen kortti">
  <h1>Kirjaudu</h1>

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