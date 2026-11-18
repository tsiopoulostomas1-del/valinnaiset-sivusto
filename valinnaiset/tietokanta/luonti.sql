-- Ammatilliset valinnaiset: tietokanta, osa 1.
-- Aja kerran phpMyAdminin SQL-välilehdellä.

CREATE DATABASE valinnaiset
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE valinnaiset;

CREATE TABLE kayttaja (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  sahkoposti VARCHAR(190) NOT NULL UNIQUE,
  nimi       VARCHAR(100) NOT NULL,
  rooli      ENUM('opiskelija', 'opettaja', 'paakayttaja') NOT NULL,
  ryhma      VARCHAR(20) NULL,
  salasana   VARCHAR(255) NULL,
  luotu      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Testitunnukset. Salasanat on tallennettu tiivisteinä (password_hash).
--   opiskelija@example.com    Opiskelija2026
--   opettaja@example.com      Opettaja2026
--   paakayttaja@example.com   Paakayttaja2026
INSERT INTO kayttaja (sahkoposti, nimi, rooli, ryhma, salasana) VALUES
('opiskelija@example.com', 'Olli Opiskelija', 'opiskelija', 'TIEV25',
 '$2y$10$HuTjuy6n7vbvK44F2/06Aew.fJ6hnZT0ErvxmRRIWqidNyjMTGQJu'),
('opettaja@example.com', 'Outi Opettaja', 'opettaja', NULL,
 '$2y$10$0LHO.e8LJYAhGWiOqOJChOELJaQmsGlThT1OzjnzmWg0giFe3inzW'),
('paakayttaja@example.com', 'Paavo Pääkäyttäjä', 'paakayttaja', NULL,
 '$2y$10$s4sxp3s5fY8q24OblXRqwO8OwqSv929RwLsJO.W35X2poR2ez5weS');