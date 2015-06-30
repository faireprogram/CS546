
drop schema if exists `cs546` ;

create schema `cs546`;
use `cs546`;

CREATE TABLE `user` (
  `user_id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_name` varchar(45) NOT NULL,
  `user_email` varchar(45) NOT NULL,
  `user_cellphone` int(10) unsigned NOT NULL,
  `user_address` varchar(100) DEFAULT NULL,
  `friends` varchar(5000) DEFAULT NULL,
  `user_pwd` varchar(45) NOT NULL,
  `user_age` int(10) unsigned DEFAULT NULL,
  `user_gender` varchar(2) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_cellphone_UNIQUE` (`user_cellphone`),
  UNIQUE KEY `user_email_UNIQUE` (`user_email`),
  UNIQUE KEY `user_name_UNIQUE` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;


CREATE TABLE `operation` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned zerofill NOT NULL,
  `operations` longtext,
  PRIMARY KEY (`id`),
  KEY `index_user_id` (`user_id`),
  CONSTRAINT `no_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `cmd` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned zerofill NOT NULL,
  `cmd` longtext,
  PRIMARY KEY (`id`),
  KEY `cmd_user_id` (`user_id`),
  CONSTRAINT `cmd_fk` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;


CREATE TABLE `message` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `abuser` varchar(20) NOT NULL,
  `log` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;


CREATE TABLE `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id_cur` int(10) unsigned zerofill NOT NULL,
  `login_ip` varchar(45) NOT NULL,
  `login_device` varchar(45) NOT NULL,
  `token` varchar(20) NOT NULL,
  `scope` text,
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_login_fk_idx` (`user_id_cur`),
  CONSTRAINT `user_login_fk` FOREIGN KEY (`user_id_cur`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;



