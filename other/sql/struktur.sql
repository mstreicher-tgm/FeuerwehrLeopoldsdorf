DROP DATABASE IF EXISTS `Feuerwehr`;
CREATE DATABASE `Feuerwehr`;
USE `Feuerwehr`;

DROP TABLE IF EXISTS `userdata`;
CREATE TABLE `userdata` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `vorname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nachname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `standesbuchnummer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dienstgrad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `passwort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `berechtigung` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` BOOLEAN NOT NULL,
  PRIMARY KEY (`id`), UNIQUE (`standesbuchnummer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `dienstgraddata`;
CREATE TABLE `dienstgraddata` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `kuerzel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dienstgrad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `funktion` TEXT COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`), UNIQUE (`kuerzel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `fahrzeugdata`;
CREATE TABLE `fahrzeugdata` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `funkbezeichnung` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fahrzeug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` INT(1) NOT NULL,
  `kommentar` TEXT COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`), UNIQUE (`funkbezeichnung`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS `geraetedata`;
CREATE TABLE `geraetedata` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT,
  `geraet` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `standort` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` INT(1) NOT NULL,
  `kommentar` TEXT COLLATE utf8_unicode_ci NULL,
  PRIMARY KEY (`id`), UNIQUE (`geraet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

























  DROP TABLE IF EXISTS `securitytokens`;
  CREATE TABLE `securitytokens` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_id` int(10) NOT NULL,
    `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `securitytoken` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
