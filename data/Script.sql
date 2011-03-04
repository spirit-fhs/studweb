--<ScriptOptions statementTerminator=";"/>

ALTER TABLE `spirit`.`entry` DROP PRIMARY KEY;

DROP TABLE `spirit`.`entry`;

CREATE TABLE `spirit`.`entry` (
	`id` INT NOT NULL,
	`cruser` VARCHAR(255) NOT NULL,
	`subject` VARCHAR(255) NOT NULL,
	`text` TEXT NOT NULL,
	`crdate` TIMESTAMP DEFAULT 'CURRENT_TIMESTAMP' NOT NULL,
	PRIMARY KEY (`id`)
);

