SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `u668252900_m2l` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `u668252900_m2l` ;

-- -----------------------------------------------------
-- Table `u668252900_m2l`.`Type_Employe`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u668252900_m2l`.`Type_Employe` (
  `id_Type_Employe` INT(11) NOT NULL AUTO_INCREMENT,
  `Statut` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  PRIMARY KEY (`id_Type_Employe`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `u668252900_m2l`.`Employe`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u668252900_m2l`.`Employe` (
  `id_Employe` INT(11) NOT NULL AUTO_INCREMENT,
  `nom_Employe` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `Prenom_Employe` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `Pseudo` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  `mdp` CHAR(32) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `type_Employe` INT(11) NOT NULL,
  `credit` INT(11) NULL DEFAULT '3000',
  `Superieur` INT(11) NULL DEFAULT NULL,
  `date_naissance` DATE NULL DEFAULT NULL,
  `mail` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id_Employe`),
  UNIQUE INDEX `Pseudo` (`Pseudo` ASC),
  INDEX `fk_Employe_Type_Employe_idx` (`type_Employe` ASC),
  INDEX `fk_Employe_Employe1_idx` (`Superieur` ASC),
  CONSTRAINT `fk_Employe_Employe1`
    FOREIGN KEY (`Superieur`)
    REFERENCES `u668252900_m2l`.`Employe` (`id_Employe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Employe_Type_Employe`
    FOREIGN KEY (`type_Employe`)
    REFERENCES `u668252900_m2l`.`Type_Employe` (`id_Type_Employe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `u668252900_m2l`.`Prestataire`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u668252900_m2l`.`Prestataire` (
  `id_Prestataire` INT(11) NOT NULL AUTO_INCREMENT,
  `nom_Prestataire` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `rue_Prestataire` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  `ville_Prestataire` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  `codePostal_Prestataire` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id_Prestataire`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `u668252900_m2l`.`Formation`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u668252900_m2l`.`Formation` (
  `id_Formation` INT(11) NOT NULL AUTO_INCREMENT,
  `titre_Formation` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL,
  `description_forma` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  `date_Formation` DATETIME NOT NULL,
  `duree_Formation` INT(11) NOT NULL,
  `credit` INT(11) NOT NULL,
  `id_Prestataire` INT(11) NOT NULL,
  PRIMARY KEY (`id_Formation`),
  INDEX `fk_Formation_Prestataire1_idx` (`id_Prestataire` ASC),
  CONSTRAINT `fk_Formation_Prestataire1`
    FOREIGN KEY (`id_Prestataire`)
    REFERENCES `u668252900_m2l`.`Prestataire` (`id_Prestataire`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `u668252900_m2l`.`Selectionner`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u668252900_m2l`.`Selectionner` (
  `id_Employe` INT(11) NOT NULL,
  `id_Formation` INT(11) NOT NULL,
  `etat` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id_Employe`, `id_Formation`),
  INDEX `fk_Employe_has_Formation_Formation1_idx` (`id_Formation` ASC),
  INDEX `fk_Employe_has_Formation_Employe1_idx` (`id_Employe` ASC),
  CONSTRAINT `fk_Employe_has_Formation_Employe1`
    FOREIGN KEY (`id_Employe`)
    REFERENCES `u668252900_m2l`.`Employe` (`id_Employe`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Employe_has_Formation_Formation1`
    FOREIGN KEY (`id_Formation`)
    REFERENCES `u668252900_m2l`.`Formation` (`id_Formation`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
