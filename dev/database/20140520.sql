
CREATE TABLE `User` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`email` VARCHAR( 255 ) NOT NULL UNIQUE ,
`password` VARCHAR( 40 ) NOT NULL ,
`name` VARCHAR( 150 ) NOT NULL UNIQUE ,
`role` ENUM('player', 'administrator', 'gamemaster') NOT NULL DEFAULT 'player' ,
`avatar` VARCHAR( 255 ) NULL ,
`gender` ENUM('female', 'male') NULL ,
`birthyear` CHAR( 4 ) NULL ,
`website` VARCHAR( 255 ) NULL ,
`twitter` VARCHAR( 255 ) NULL ,
`facebook` VARCHAR( 255 ) NULL ,
`googleplus` VARCHAR( 255 ) NULL ,
`skype` VARCHAR( 255 ) NULL ,
`country` CHAR( 2 ) NULL ,
`showChatTimes` TINYINT NOT NULL DEFAULT 1 ,
`reverseCards` TINYINT NOT NULL DEFAULT 1 ,
`onHoverDetails` TINYINT NOT NULL DEFAULT 1 ,
`handCorner` ENUM('left', 'right') NOT NULL DEFAULT 'left' ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Card` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`rules` TEXT NOT NULL ,
`face` VARCHAR( 255 ) NOT NULL ,
`back` VARCHAR( 255 ) NULL ,
`backFrom` ENUM('default', 'own', 'deck') NOT NULL DEFAULT 'default' ,
`cardscapeRevisionId` INT UNSIGNED NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Deck` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 255 ) NOT NULL ,
`createdOn` DATETIME NOT NULL ,
`back` VARCHAR( 255 ) NULL ,
`ownerId` INT UNSIGNED NOT NULL ,
`active` TINYINT NOT NULL DEFAULT 1 ,
CONSTRAINT `fkDeckUser` FOREIGN KEY (`ownerId`) REFERENCES `User`(`id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `DeckCard` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`deckId` INT UNSIGNED NOT NULL,
`cardId` INT UNSIGNED NOT NULL,
CONSTRAINT `fkDCDeck` FOREIGN KEY (`deckId`) REFERENCES `Deck`(`id`),
CONSTRAINT `fkDCCard` FOREIGN KEY (`cardId`) REFERENCES `Card`(`id`)
) ENGINE=InnoDB character set utf8 collate utf8_unicode_ci ;

CREATE TABLE `Token` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`image` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `State` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`image` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Dice` (
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`face` TINYINT NOT NULL DEFAULT 6 ,
`name` VARCHAR( 150 ) NOT NULL ,
`description` TEXT NULL ,
`enabled` TINYINT NOT NULL DEFAULT 1 ,
`active` TINYINT NOT NULL DEFAULT 1 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;

CREATE TABLE `Counter`(
`id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT ,
`name` VARCHAR( 150 ) NOT NULL ,
`startValue` INT NOT NULL ,
`step` INT NOT NULL DEFAULT 1 ,
`enabled` TINYINT NOT NULL DEFAULT 1 ,
`description` TEXT NULL ,
`active` TINYINT NOT NULL DEFAULT 1
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
