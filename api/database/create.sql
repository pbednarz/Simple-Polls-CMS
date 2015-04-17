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
  `userId` INT NOT NULL AUTO_INCREMENT,
  `birthDate` DATETIME NULL,
  `sex` VARCHAR(255) NULL,
  `createDate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`userId`));


-- -----------------------------------------------------
-- Table `polls`.`poll`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`poll` ;

CREATE TABLE IF NOT EXISTS `polls`.`poll` (
  `pollId` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `createDate` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pollId`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC));


-- -----------------------------------------------------
-- Table `polls`.`question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`question` ;

CREATE TABLE IF NOT EXISTS `polls`.`question` (
  `questionId` INT NOT NULL AUTO_INCREMENT,
  `pollId` INT NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  `allowMultipleAnswers` TINYINT(1) NULL DEFAULT 1,
  PRIMARY KEY (`questionId`, `pollId`),
  INDEX `fk_question_pollIdx` (`pollId` ASC),
  CONSTRAINT `fk_question_poll`
    FOREIGN KEY (`pollId`)
    REFERENCES `polls`.`poll` (`pollId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `polls`.`answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`answer` ;

CREATE TABLE IF NOT EXISTS `polls`.`answer` (
  `answerId` INT NOT NULL AUTO_INCREMENT,
  `questionId` INT NOT NULL,
  `pollId` INT NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`answerId`, `questionId`, `pollId`),
  INDEX `fk_answer_question1_idx` (`questionId` ASC, `pollId` ASC),
  CONSTRAINT `fk_answer_question1`
    FOREIGN KEY (`questionId` , `pollId`)
    REFERENCES `polls`.`question` (`questionId` , `pollId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `polls`.`admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`admin` ;

CREATE TABLE IF NOT EXISTS `polls`.`admin` (
  `adminId` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `createTime` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`adminId`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC));


-- -----------------------------------------------------
-- Table `polls`.`user_answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `polls`.`user_answer` ;

CREATE TABLE IF NOT EXISTS `polls`.`user_answer` (
  `userId` INT NOT NULL,
  `pollId` INT NOT NULL,
  `questionId` INT NOT NULL,
  `answerId` INT NOT NULL,
  PRIMARY KEY (`userId`, `pollId`, `questionId`, `answerId`),
  INDEX `fk_user_has_answer_answer1_idx` (`answerId` ASC, `questionId` ASC, `pollId` ASC),
  INDEX `fk_user_has_answer_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_user_has_answer_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `polls`.`user` (`userId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_answer_answer1`
    FOREIGN KEY (`answerId` , `questionId` , `pollId`)
    REFERENCES `polls`.`answer` (`answerId` , `questionId` , `pollId`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
