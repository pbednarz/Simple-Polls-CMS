-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema polls
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema polls
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `polls`;
CREATE SCHEMA IF NOT EXISTS `polls` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `polls` ;

-- -----------------------------------------------------
-- Table `polls`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`user` ;

CREATE TABLE IF NOT EXISTS `polls`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `birth_date` DATETIME NULL,
  `sex` VARCHAR(255) NULL,
  `create_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`));


-- -----------------------------------------------------
-- Table `polls`.`poll`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`poll` ;

CREATE TABLE IF NOT EXISTS `polls`.`poll` (
  `poll_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `create_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`poll_id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC));


-- -----------------------------------------------------
-- Table `polls`.`question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`question` ;

CREATE TABLE IF NOT EXISTS `polls`.`question` (
  `question_id` INT NOT NULL AUTO_INCREMENT,
  `poll_id` INT NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  `allow_multiple_answers` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`question_id`, `poll_id`),
  INDEX `fk_question_poll_idx` (`poll_id` ASC),
  CONSTRAINT `fk_question_poll`
    FOREIGN KEY (`poll_id`)
    REFERENCES `polls`.`poll` (`poll_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `polls`.`answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`answer` ;

CREATE TABLE IF NOT EXISTS `polls`.`answer` (
  `answer_id` INT NOT NULL AUTO_INCREMENT,
  `question_id` INT NOT NULL,
  `poll_id` INT NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`answer_id`, `question_id`, `poll_id`),
  INDEX `fk_answer_question1_idx` (`question_id` ASC, `poll_id` ASC),
  CONSTRAINT `fk_answer_question1`
    FOREIGN KEY (`question_id` , `poll_id`)
    REFERENCES `polls`.`question` (`question_id` , `poll_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `polls`.`admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`admin` ;

CREATE TABLE IF NOT EXISTS `polls`.`admin` (
  `admin_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `create_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`admin_id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC));


-- -----------------------------------------------------
-- Table `polls`.`user_answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`user_answer` ;

CREATE TABLE IF NOT EXISTS `polls`.`user_answer` (
  `user_id` INT NOT NULL,
  `poll_id` INT NOT NULL,
  `question_id` INT NOT NULL,
  `answer_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `poll_id`, `question_id`, `answer_id`),
  INDEX `fk_user_has_answer_answer1_idx` (`answer_id` ASC, `question_id` ASC, `poll_id` ASC),
  INDEX `fk_user_has_answer_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_has_answer_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `polls`.`user` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_answer_answer1`
    FOREIGN KEY (`answer_id` , `question_id` , `poll_id`)
    REFERENCES `polls`.`answer` (`answer_id` , `question_id` , `poll_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
