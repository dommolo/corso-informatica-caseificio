CREATE DATABASE `libreria`;
CREATE TABLE IF NOT EXISTS `libreria`.`libri` (
  `id_libro` BIGINT NOT NULL AUTO_INCREMENT,
  `codice` VARCHAR(255) NOT NULL,
  `titolo` VARCHAR(255) NOT NULL,
  `autore` VARCHAR(255) NOT NULL,
  `casa_editrice` VARCHAR(255) NOT NULL,
  `isbn` VARCHAR(32) NOT NULL,
  `genere` VARCHAR(64) NOT NULL,
  `immagine` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id_libro`));