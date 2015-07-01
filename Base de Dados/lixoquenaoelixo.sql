SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `lixoquenaoelixo` DEFAULT CHARACTER SET latin1 ;
USE `lixoquenaoelixo` ;

-- -----------------------------------------------------
-- Table `lixoquenaoelixo`.`endereco`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lixoquenaoelixo`.`endereco` (
  `id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
  `cep` VARCHAR(45) NOT NULL ,
  `rua` VARCHAR(45) NOT NULL ,
  `numero` INT(11) NOT NULL ,
  `bairro` VARCHAR(45) NOT NULL ,
  `cidade` VARCHAR(45) NOT NULL ,
  `uf` VARCHAR(2) NOT NULL ,
  `complemento` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 26
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `lixoquenaoelixo`.`catador`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lixoquenaoelixo`.`catador` (
  `id` INT(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(45) NOT NULL ,
  `email` VARCHAR(45) NOT NULL ,
  `telefone` VARCHAR(45) NOT NULL ,
  `nascimento` DATE NOT NULL ,
  `endereco_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_catador_endereco1` (`endereco_id` ASC) ,
  CONSTRAINT `fk_catador_endereco1`
    FOREIGN KEY (`endereco_id` )
    REFERENCES `lixoquenaoelixo`.`endereco` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `lixoquenaoelixo`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lixoquenaoelixo`.`usuario` (
  `id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(100) NOT NULL ,
  `telefone` VARCHAR(45) NOT NULL ,
  `username` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  `tipo` INT(1) NOT NULL ,
  `endereco_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_usuario_endereco` (`endereco_id` ASC) ,
  CONSTRAINT `fk_usuario_endereco`
    FOREIGN KEY (`endereco_id` )
    REFERENCES `lixoquenaoelixo`.`endereco` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `lixoquenaoelixo`.`disponibilidade`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lixoquenaoelixo`.`disponibilidade` (
  `id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
  `dia` DATE NOT NULL ,
  `turno` VARCHAR(20) NOT NULL ,
  `responsavel` BIGINT(20) UNSIGNED ZEROFILL NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_disponibilidade_responsavel` (`responsavel` ASC) ,
  CONSTRAINT `fk_disponibilidade_responsavel`
    FOREIGN KEY (`responsavel` )
    REFERENCES `lixoquenaoelixo`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `lixoquenaoelixo`.`recolhimento`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lixoquenaoelixo`.`recolhimento` (
  `id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
  `data` DATETIME NOT NULL ,
  `papel` FLOAT NOT NULL ,
  `metal` FLOAT NOT NULL ,
  `eletronico` FLOAT NOT NULL ,
  `vidro` FLOAT NOT NULL ,
  `plastico` FLOAT NOT NULL ,
  `outros` FLOAT NOT NULL ,
  `total` FLOAT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `lixoquenaoelixo`.`solicitacao`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `lixoquenaoelixo`.`solicitacao` (
  `id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT ,
  `data` DATE NOT NULL ,
  `observacoes` TEXT NULL DEFAULT NULL ,
  `disponibilidade1_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL ,
  `disponibilidade2_id` BIGINT(20) UNSIGNED ZEROFILL NULL DEFAULT NULL ,
  `disponibilidade3_id` BIGINT(20) UNSIGNED ZEROFILL NULL DEFAULT NULL ,
  `papel` INT(11) NOT NULL ,
  `metal` INT(11) NOT NULL ,
  `eletronico` INT(11) NOT NULL ,
  `vidro` INT(11) NOT NULL ,
  `plastico` INT(11) NOT NULL ,
  `outros` INT(11) NOT NULL ,
  `status` VARCHAR(45) NOT NULL ,
  `usuario_id` BIGINT(20) UNSIGNED ZEROFILL NOT NULL ,
  `catador_id` INT(10) UNSIGNED ZEROFILL NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_solicitacao_disponibilidade1` (`disponibilidade1_id` ASC) ,
  INDEX `fk_solicitacao_disponibilidade2` (`disponibilidade2_id` ASC) ,
  INDEX `fk_solicitacao_disponibilidade3` (`disponibilidade3_id` ASC) ,
  INDEX `fk_solicitacao_usuario1` (`usuario_id` ASC) ,
  INDEX `fk_solicitacao_catador1` (`catador_id` ASC) ,
  CONSTRAINT `fk_solicitacao_catador1`
    FOREIGN KEY (`catador_id` )
    REFERENCES `lixoquenaoelixo`.`catador` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_solicitacao_disponibilidade1`
    FOREIGN KEY (`disponibilidade1_id` )
    REFERENCES `lixoquenaoelixo`.`disponibilidade` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_solicitacao_disponibilidade2`
    FOREIGN KEY (`disponibilidade2_id` )
    REFERENCES `lixoquenaoelixo`.`disponibilidade` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_solicitacao_disponibilidade3`
    FOREIGN KEY (`disponibilidade3_id` )
    REFERENCES `lixoquenaoelixo`.`disponibilidade` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `fk_solicitacao_usuario1`
    FOREIGN KEY (`usuario_id` )
    REFERENCES `lixoquenaoelixo`.`usuario` (`id` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = latin1;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
