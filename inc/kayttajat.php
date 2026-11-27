<?php
require_once __DIR__ . '/tietokanta.php';

/** Kaikki käyttäjät roolin ja nimen mukaan järjestettynä. */
function hae_kayttajat(): array
{
    return yhteys()
        ->query('SELECT id, sahkoposti, nimi, rooli, ryhma FROM kayttaja ORDER BY rooli, nimi')
        ->fetchAll();
}

/** Yksi käyttäjä, tai null jos sitä ei ole. Salasanan tiivistettä ei haeta. */
function hae_kayttaja(int $id): ?array
{
    $kysely = yhteys()->prepare('SELECT id, sahkoposti, nimi, rooli, ryhma FROM kayttaja WHERE id = ?');
    $kysely->execute([$id]);

    return $kysely->fetch() ?: null;
}

/** Onko sähköposti jo jollakulla muulla kuin käyttäjällä $id? */
function sahkoposti_kaytossa(string $sahkoposti, ?int $id): bool
{
    $kysely = yhteys()->prepare('SELECT id FROM kayttaja WHERE sahkoposti = ? AND id <> ?');
    $kysely->execute([$sahkoposti, $id ?? 0]);

    return $kysely->fetch() !== false;
}

/**
 * Lukee lomakkeen tiedot ja tarkistaa ne. Palauttaa [tiedot, virheet].
 *
 * $id on muokattavan käyttäjän id (uudella null) ja $oma_id kirjautuneen
 * pääkäyttäjän id: omaa pääkäyttäjän roolia ei voi poistaa.
 */
function lue_kayttaja_lomake(array $lomake, ?int $id, int $oma_id): array
{
    $tiedot = [
        'sahkoposti' => trim($lomake['sahkoposti'] ?? ''),
        'nimi'       => trim($lomake['nimi'] ?? ''),
        'rooli'      => $lomake['rooli'] ?? '',
        'ryhma'      => strtoupper(trim($lomake['ryhma'] ?? '')),
        'salasana'   => $lomake['salasana'] ?? '',
    ];

    $virheet = [];

    if (filter_var($tiedot['sahkoposti'], FILTER_VALIDATE_EMAIL) === false
        || mb_strlen($tiedot['sahkoposti']) > 190) {
        $virheet['sahkoposti'] = 'Sähköpostiosoite ei kelpaa.';
    } elseif (sahkoposti_kaytossa($tiedot['sahkoposti'], $id)) {
        $virheet['sahkoposti'] = 'Sähköposti on jo toisella käyttäjällä.';
    }

    if ($tiedot['nimi'] === '' || mb_strlen($tiedot['nimi']) > 100) {
        $virheet['nimi'] = 'Nimi puuttuu tai on yli 100 merkkiä.';
    }

    if (!isset(ROOLIT[$tiedot['rooli']])) {
        $virheet['rooli'] = 'Valitse rooli.';
    } elseif ($id === $oma_id && $tiedot['rooli'] !== 'paakayttaja') {
        $virheet['rooli'] = 'Et voi poistaa itseltäsi pääkäyttäjän roolia.';
    }

    // Ryhmä kuuluu vain opiskelijalle.
    if ($tiedot['rooli'] === 'opiskelija') {
        if (!preg_match('/^[A-Z0-9]{2,20}$/', $tiedot['ryhma'])) {
            $virheet['ryhma'] = 'Opiskelijan ryhmätunnus on 2–20 kirjainta tai numeroa, esim. TIEV25.';
        }
    } else {
        $tiedot['ryhma'] = null;
    }

    // Tyhjä salasana: uusi käyttäjä ilman salasanaa, muokatessa salasana ei muutu.
    if ($tiedot['salasana'] === '') {
        $tiedot['salasana'] = null;
    } elseif (mb_strlen($tiedot['salasana']) < 8) {
        $virheet['salasana'] = 'Salasanassa pitää olla vähintään 8 merkkiä.';
    }

    return [$tiedot, $virheet];
}

/** Lisää uuden käyttäjän ($id null) tai päivittää olemassa olevan. */
function tallenna_kayttaja(?int $id, array $tiedot): void
{
    $tiiviste = $tiedot['salasana'] === null ? null : password_hash($tiedot['salasana'], PASSWORD_DEFAULT);

    if ($id === null) {
        yhteys()->prepare(
            'INSERT INTO kayttaja (sahkoposti, nimi, rooli, ryhma, salasana) VALUES (?, ?, ?, ?, ?)'
        )->execute([$tiedot['sahkoposti'], $tiedot['nimi'], $tiedot['rooli'], $tiedot['ryhma'], $tiiviste]);
        return;
    }

    yhteys()->prepare(
        'UPDATE kayttaja SET sahkoposti = ?, nimi = ?, rooli = ?, ryhma = ? WHERE id = ?'
    )->execute([$tiedot['sahkoposti'], $tiedot['nimi'], $tiedot['rooli'], $tiedot['ryhma'], $id]);

    if ($tiiviste !== null) {
        yhteys()->prepare('UPDATE kayttaja SET salasana = ? WHERE id = ?')->execute([$tiiviste, $id]);
    }
}