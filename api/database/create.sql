-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema polls_cms
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema polls_cms
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `polls_cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `polls_cms` ;

-- -----------------------------------------------------
-- Table `polls_cms`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `polls_cms`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`user_id`));


-- -----------------------------------------------------
-- Table `polls_cms`.`poll`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `polls_cms`.`poll` (
  `poll_id` INT NOT NULL AUTO_INCREMENT,
  `poll_title` VARCHAR(255) NOT NULL,
  `create_date` DATETIME NOT NULL,
  PRIMARY KEY (`poll_id`));


-- -----------------------------------------------------
-- Table `polls_cms`.`question`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `polls_cms`.`question` (
  `question_id` INT NOT NULL AUTO_INCREMENT,
  `poll_id` INT NOT NULL,
  `question_text` VARCHAR(255) NOT NULL,
  `allow_multiple_answers` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`question_id`, `poll_id`),
  INDEX `fk_question_poll_idx` (`poll_id` ASC),
  CONSTRAINT `fk_question_poll`
    FOREIGN KEY (`poll_id`)
    REFERENCES `polls_cms`.`poll` (`poll_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `polls_cms`.`answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `polls_cms`.`answer` (
  `answer_id` INT NOT NULL AUTO_INCREMENT,
  `question_id` INT NOT NULL,
  `poll_id` INT NOT NULL,
  `answer_text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`answer_id`, `question_id`, `poll_id`),
  INDEX `fk_answer_question1_idx` (`question_id` ASC, `poll_id` ASC),
  CONSTRAINT `fk_answer_question1`
    FOREIGN KEY (`question_id` , `poll_id`)
    REFERENCES `polls_cms`.`question` (`question_id` , `poll_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `polls_cms`.`user_answer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `polls_cms`.`user_answer` (
  `user_id` INT NOT NULL,
  `poll_id` INT NOT NULL,
  `question_id` INT NOT NULL,
  `answer_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `poll_id`, `question_id`, `answer_id`),
  INDEX `fk_user_answer_answer1_idx` (`answer_id` ASC, `question_id` ASC, `poll_id` ASC),
  INDEX `fk_user_answer_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_answer_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `polls_cms`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_answer_answer1`
    FOREIGN KEY (`answer_id` , `question_id` , `poll_id`)
    REFERENCES `polls_cms`.`answer` (`answer_id` , `question_id` , `poll_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
