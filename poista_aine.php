<?php
require __DIR__ . '/inc/kirjautuminen.php';
require __DIR__ . '/inc/aineet.php';

vaadi_rooli(['paakayttaja']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: aineet.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    $aine = hae_aine($id);
    if ($aine === null) {
        aseta_ilmoitus('Valinnaista ei löytynyt. Se on ehkä jo poistettu.');
    } else {
        poista_aine($id);
        aseta_ilmoitus('Valinnainen ' . $aine['nimi'] . ' poistettiin.');
    }
}

header('Location: aineet.php');
exit;
