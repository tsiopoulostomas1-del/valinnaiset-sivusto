<?php
require_once __DIR__ . '/tietokanta.php';

/* Kori => mitä se tarkoittaa. */
const KORIT = [
    1 => 'Alkuviikko',
    2 => 'Loppuviikko',
    3 => 'Koko viikko',
];

/** Kaikki valinnaiset korin ja nimen mukaan järjestettynä. */
function hae_aineet(): array
{
    return yhteys()
        ->query('SELECT * FROM aine ORDER BY kori, nimi')
        ->fetchAll();
}

/** Yksi valinnainen, tai null jos sitä ei ole. */
function hae_aine(int $id): ?array
{
    $kysely = yhteys()->prepare('SELECT * FROM aine WHERE id = ?');
    $kysely->execute([$id]);

    return $kysely->fetch() ?: null;
}

/**
 * Lukee lomakkeen tiedot ja tarkistaa ne.
 * Palauttaa [tiedot, virheet]. Virheet on tyhjä taulukko, kun kaikki on kunnossa.
 */
function lue_aine_lomake(array $lomake): array
{
    $tiedot = [
        'nimi'    => trim($lomake['nimi'] ?? ''),
        'laajuus' => (int)($lomake['laajuus'] ?? 0),
        'kori'    => (int)($lomake['kori'] ?? 0),
        'kuvaus'  => trim($lomake['kuvaus'] ?? ''),
        'tai'     => isset($lomake['tai']) ? 1 : 0,
        'taynna'  => isset($lomake['taynna']) ? 1 : 0,
    ];

    $virheet = [];

    if ($tiedot['nimi'] === '' || mb_strlen($tiedot['nimi']) > 100) {
        $virheet['nimi'] = 'Nimi puuttuu tai on yli 100 merkkiä.';
    }
    if (!in_array($tiedot['laajuus'], [15, 30], true)) {
        $virheet['laajuus'] = 'Valitse laajuus.';
    }
    if (!isset(KORIT[$tiedot['kori']])) {
        $virheet['kori'] = 'Valitse kori.';
    } elseif ($tiedot['laajuus'] === 30 && $tiedot['kori'] !== 3) {
        $virheet['kori'] = '30 osp:n valinnainen on aina koko viikon (kori 3).';
    } elseif ($tiedot['laajuus'] === 15 && $tiedot['kori'] === 3) {
        $virheet['kori'] = '15 osp:n valinnainen on alku- tai loppuviikolla (kori 1 tai 2).';
    }
    if ($tiedot['kuvaus'] === '' || mb_strlen($tiedot['kuvaus']) > 2000) {
        $virheet['kuvaus'] = 'Kuvaus puuttuu tai on yli 2000 merkkiä.';
    }

    return [$tiedot, $virheet];
}

/** Lisää uuden valinnaisen ($id null) tai päivittää olemassa olevan. */
function tallenna_aine(?int $id, array $tiedot): void
{
    $arvot = [$tiedot['nimi'], $tiedot['laajuus'], $tiedot['kuvaus'],
              $tiedot['tai'], $tiedot['kori'], $tiedot['taynna']];

    if ($id === null) {
        yhteys()->prepare(
            'INSERT INTO aine (nimi, laajuus, kuvaus, tai, kori, taynna) VALUES (?, ?, ?, ?, ?, ?)'
        )->execute($arvot);
    } else {
        $arvot[] = $id;
        yhteys()->prepare(
            'UPDATE aine SET nimi = ?, laajuus = ?, kuvaus = ?, tai = ?, kori = ?, taynna = ? WHERE id = ?'
        )->execute($arvot);
    }
}

/** Poistaa valinnaisen. */
function poista_aine(int $id): void
{
    yhteys()->prepare('DELETE FROM aine WHERE id = ?')->execute([$id]);
}