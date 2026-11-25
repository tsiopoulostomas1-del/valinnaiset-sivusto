<?php
require __DIR__ . '/inc/kirjautuminen.php';
require __DIR__ . '/inc/aineet.php';

vaadi_rooli(['paakayttaja']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id > 0) {
    poista_aine($id);
}

header('Location: aineet.php');
exit;
