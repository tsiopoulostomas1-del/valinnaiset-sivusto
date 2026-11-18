<?php
require_once __DIR__ . '/../asetukset.php';

/**
 * Palauttaa tietokantayhteyden. Yhteys avataan ensimmäisellä
 * kutsulla, ja seuraavat kutsut saavat saman yhteyden.
 */
function yhteys(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host=' . DB_PALVELIN . ';dbname=' . DB_NIMI . ';charset=utf8mb4',
            DB_KAYTTAJA,
            DB_SALASANA,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    return $pdo;
}