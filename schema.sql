-- Disable auto increment
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- Start transaction
START TRANSACTION;

-- Drop database
DROP DATABASE IF EXISTS doodledesk;

-- Create database
CREATE DATABASE doodledesk DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE doodledesk;

-- Create tables
CREATE TABLE user (
	id INT NOT NULL PRIMARY KEY,
	email VARCHAR(100) NOT NULL UNIQUE,
	username VARCHAR(100) NOT NULL UNIQUE,
	password VARCHAR(100) NOT NULL,
	notes JSON NOT NULL DEFAULT "[]"
);

-- Add auto increment
ALTER TABLE user MODIFY id INT NOT NULL AUTO_INCREMENT;

-- Commit transaction
COMMIT;
