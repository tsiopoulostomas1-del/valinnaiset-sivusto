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

/** Sivu vain annetuille rooleille. Muut saavat virheen 403. */
function vaadi_rooli(array $roolit): void
{
    vaadi_kirjautuminen();

    if (!in_array($_SESSION['rooli'], $roolit, true)) {
        http_response_code(403);
        $otsikko = 'Ei oikeutta';
        require __DIR__ . '/../osat/ylaosa.php';
        echo '<h1>Ei oikeutta</h1>';
        echo '<p>Tämä sivu ei kuulu sinun roolillesi. ';
        echo '<a href="' . roolin_etusivu($_SESSION['rooli']) . '">Omalle etusivulle</a></p>';
        require __DIR__ . '/../osat/alaosa.php';
        exit;
    }
}

/** Tallentaa ilmoituksen näytettäväksi seuraavalla sivulla. */
function aseta_ilmoitus(string $teksti): void
{
    $_SESSION['ilmoitus'] = $teksti;
}

/** Palauttaa ilmoituksen ja poistaa sen, jottei se näy uudelleen. */
function ota_ilmoitus(): ?string
{
    $teksti = $_SESSION['ilmoitus'] ?? null;
    unset($_SESSION['ilmoitus']);

    return $teksti;
}