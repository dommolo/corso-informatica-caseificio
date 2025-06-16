CREATE DATABASE `caseificio`;

CREATE TABLE `ProduzioneLatte` (
  `id_produzione` INT(11) NOT NULL AUTO_INCREMENT,
  `id_caseificio` INT(11) NOT NULL,
  `data` DATE,
  `quantita_latte_raccolta` DECIMAL(10,2),
  `quantita_latte_usata` DECIMAL(10,2),
  `forme_prodotte` INT(11),
  PRIMARY KEY (`id_produzione`),
  INDEX `fk_id_caseificio_idx` (`id_caseificio` ASC) VISIBLE,
  CONSTRAINT `fk_produzione_caseificio`
    FOREIGN KEY (`id_caseificio`)
    REFERENCES `caseificio`.`Caseificio` (`id_caseificio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE `Caseificio` (
  `id_caseificio` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100),
  `indirizzo` VARCHAR(255),
  `latitudine` FLOAT(11),
  `longitudine` FLOAT(11),
  `titolare` VARCHAR(100),
  `foto_caseificio` TEXT,
  PRIMARY KEY (`id_caseificio`));

CREATE TABLE `FormaFormaggio` (
  `id_forma` INT(11) NOT NULL AUTO_INCREMENT,
  `id_caseificio` INT(11) NOT NULL,
  `data_produzione` DATE,
  `numero_progressivo` INT(11),
  `stagionatura_mesi` INT(11),
  `prima_seconda_scelta` ENUM('12', '24', '30', '36'),
  PRIMARY KEY (`id_forma`),
  INDEX `fk_forma_caseificio_idx` (`id_caseificio` ASC) VISIBLE,
  CONSTRAINT `fk_forma_caseificio`
    FOREIGN KEY (`id_caseificio`)
    REFERENCES `caseificio`.`Caseificio` (`id_caseificio`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE `Vendita` (
  `id_vendita` INT(11) NOT NULL AUTO_INCREMENT,
  `id_forma` INT(11),
  `data_vendita` DATE,
  `id_acquirente` INT(11),
  `quantita_venduta` INT(11),
  PRIMARY KEY (`id_vendita`),
  INDEX `fk_vendita_forma_idx` (`id_forma` ASC) VISIBLE,
  INDEX `fk_vendita_acquirente_idx` (`id_acquirente` ASC) VISIBLE,
  CONSTRAINT `fk_vendita_forma`
    FOREIGN KEY (`id_forma`)
    REFERENCES `caseificio`.`FormaFormaggio` (`id_forma`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_vendita_acquirente`
    FOREIGN KEY (`id_acquirente`)
    REFERENCES `caseificio`.`Acquirente` (`id_acquirente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE `Acquirente` (
  `id_acquirente` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_acquirente` VARCHAR(100),
  `tipo_acquirente` ENUM('grande distribuzione', 'grossista', 'privato'),
  PRIMARY KEY (`id_acquirente`));