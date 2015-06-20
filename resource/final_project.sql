
DROP SCHEMA IF EXISTS `cs546` ;

CREATE SCHEMA IF NOT EXISTS `cs546` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
use `cs546`;

DROP TABLE IF EXISTS `User` ;

CREATE TABLE IF NOT EXISTS `User` (
  `user_id` INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(45) NOT NULL,
  `user_email` VARCHAR(45) NOT NULL,
  `user_cellphone` INT NOT NULL,
  `user_address` VARCHAR(100) NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


DROP TABLE IF EXISTS `User_Authentication` ;

CREATE TABLE IF NOT EXISTS `User_Authentication` (
  `id` INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT ZEROFILL UNSIGNED NOT NULL,
  `user_pwd` VARCHAR(45) NOT NULL,
  `retrive_q1` VARCHAR(45) NOT NULL,
  `retrive_q2` VARCHAR(45) NOT NULL,
  `retrive_q3` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_auth_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

DROP TABLE IF EXISTS `User_Login` ;

CREATE TABLE IF NOT EXISTS `User_Login` (
  `id` INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id_cur` INT ZEROFILL UNSIGNED NOT NULL,
  `login_ip` VARCHAR(45) NOT NULL,
  `login_device` VARCHAR(45) NOT NULL,
  `token` VARCHAR(45) NOT NULL,
  `expire` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `user_login_fk_idx` (`user_id_cur` ASC),
  CONSTRAINT `user_login_fk`
    FOREIGN KEY (`user_id_cur`)
    REFERENCES `User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

DROP TABLE IF EXISTS `Chat` ;

CREATE TABLE IF NOT EXISTS `Chat` (
  `id`  INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT ZEROFILL UNSIGNED NULL,
  `folder` VARCHAR(300) NULL,
  `friends` VARCHAR(5000) NULL,
  PRIMARY KEY (`id`),
  INDEX `chat_fk_idx` (`user_id` ASC),
  CONSTRAINT `chat_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

DROP TABLE IF EXISTS `Authorized_URL` ;

CREATE TABLE IF NOT EXISTS `Authorized_URL` (
  `id` INT ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT,
  `url_pattern` VARCHAR(45) NULL,
  `user_id` INT ZEROFILL UNSIGNED NULL,
  PRIMARY KEY (`id`),
  INDEX `auth_url_fk_idx` (`user_id` ASC),
  CONSTRAINT `auth_url_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `User` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

