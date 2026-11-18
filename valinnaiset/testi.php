<?php
require __DIR__ . '/inc/tietokanta.php';

$maara = yhteys()->query('SELECT COUNT(*) FROM kayttaja')->fetchColumn();

echo 'Yhteys toimii. Käyttäjiä kannassa: ' . $maara;