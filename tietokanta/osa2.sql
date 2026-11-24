-- Ammatilliset valinnaiset: tietokanta, osa 2.
-- Aja kerran phpMyAdminin SQL-välilehdellä luonti.sql:n jälkeen.

USE valinnaiset;

CREATE TABLE aine (
  id      INT AUTO_INCREMENT PRIMARY KEY,
  nimi    VARCHAR(100) NOT NULL,
  laajuus TINYINT NOT NULL,
  kuvaus  TEXT NOT NULL,
  tai     BOOLEAN NOT NULL DEFAULT FALSE,
  kori    TINYINT NOT NULL,
  taynna  BOOLEAN NOT NULL DEFAULT FALSE,
  luotu   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  -- 15 osp on alkuviikolla (kori 1) tai loppuviikolla (kori 2), 30 osp koko viikon (kori 3).
  CONSTRAINT aine_laajuus_ja_kori CHECK (
    (laajuus = 15 AND kori IN (1, 2)) OR (laajuus = 30 AND kori = 3)
  )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Esimerkkivalinnaiset.
INSERT INTO aine (nimi, laajuus, kuvaus, tai, kori, taynna) VALUES
('Pelinkehityksen perusteet', 15,
 'Teet pienen 2D-pelin pelimoottorilla: pelihahmo, törmäykset ja pisteet.', FALSE, 1, FALSE),
('Ensiapu ja työturvallisuus', 15,
 'Hätäensiapu ja työturvallisuuskortti. Toteutetaan yhdessä muiden alojen kanssa.', TRUE, 1, FALSE),
('Mobiilisovelluksen tekeminen', 15,
 'Teet oman äpin puhelimeen ja opit, mitä sovelluskauppaan julkaiseminen vaatii.', FALSE, 2, FALSE),
('Yrittäjyys ja oma idea', 15,
 'Kehität liikeidean ryhmässä ja esittelet sen yrittäjäraadille.', TRUE, 2, TRUE),
('Verkkokaupan toteutus', 30,
 'Rakennat verkkokaupan asiakkaalle: tuotteet, ostoskori, maksutapa ja ylläpito.', FALSE, 3, FALSE);