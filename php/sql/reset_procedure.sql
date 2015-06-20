-- -----------------------------------------------------
-- Schema cs546
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cs546` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `cs546` ;

-- -----------------------------------------------------
-- Table `cs546`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cs546`.`User` (
  `user_id` INT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NOT NULL,
  `user_email` VARCHAR(45) NOT NULL,
  `user_cellphone` INT UNSIGNED NOT NULL,
  `user_address` VARCHAR(100) NULL,
  `friends` VARCHAR(5000) NULL,
  `user_pwd` VARCHAR(45) NOT NULL,
  `retrieve_q1` VARCHAR(45) NOT NULL,
  `retrieve_q2` VARCHAR(45) NOT NULL,
  `retrieve_q3` VARCHAR(45) NOT NULL,
  `user_age` INT UNSIGNED NULL,
  `user_gender` VARCHAR(2) NULL,
  `image` VARCHAR(100) NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `user_cellphone_UNIQUE` (`user_cellphone` ASC),
  UNIQUE INDEX `user_email_UNIQUE` (`user_email` ASC),
  UNIQUE INDEX `user_name_UNIQUE` (`user_name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs546`.`User_Login`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cs546`.`User_Login` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id_cur` INT UNSIGNED ZEROFILL NOT NULL,
  `login_ip` VARCHAR(45) NOT NULL,
  `login_device` VARCHAR(45) NOT NULL,
  `expire` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_login_fk_idx` (`user_id_cur` ASC),
  CONSTRAINT `user_login_fk`
    FOREIGN KEY (`user_id_cur`)
    REFERENCES `cs546`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs546`.`Cmd`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cs546`.`Cmd` (
  `id` INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED ZEROFILL NOT NULL,
  `cmd` LONGTEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `cmd_user_id` (`user_id` ASC),
  CONSTRAINT `cmd_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `cs546`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs546`.`Message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cs546`.`Message` (
  `id` INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED ZEROFILL NOT NULL,
  `log` LONGTEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id` ASC),
  CONSTRAINT `msg_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `cs546`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cs546`.`Notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cs546`.`Notifications` (
  `id` INT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED ZEROFILL NOT NULL,
  `notifications` LONGTEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `index_user_id` (`user_id` ASC),
  CONSTRAINT `no_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `cs546`.`User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
