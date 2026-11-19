<?php
session_start([
    'cookie_httponly' => true,
    'cookie_samesite' => 'Lax',
]);

require_once __DIR__ . '/tietokanta.php';

/* Roolin tunnus kannassa => nimi sivulla. */
const ROOLIT = [
    'opiskelija'  => 'Opiskelija',
    'opettaja'    => 'Opettaja',
    'paakayttaja' => 'Pääkäyttäjä',
];

function kirjautunut(): bool
{
    return isset($_SESSION['kayttaja_id']);
}

/** Sivu, jolle käyttäjä ohjataan kirjautumisen jälkeen. */
function roolin_etusivu(string $rooli): string
{
    if ($rooli === 'paakayttaja') {
        return 'hallinta.php';
    }
    if ($rooli === 'opettaja') {
        return 'opettaja.php';
    }

    return 'opiskelija.php';
}

/** Kirjautumaton käyttäjä ohjataan kirjautumissivulle. */
function vaadi_kirjautuminen(): void
{
    if (!kirjautunut()) {
        header('Location: kirjaudu.php');
        exit;
    }
}