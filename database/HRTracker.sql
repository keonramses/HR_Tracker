DROP DATABASE IF EXISTS HRTracker;
CREATE DATABASE HRTracker;
USE HRTracker;

CREATE TABLE IF NOT EXISTS employee (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name varchar(1000) NOT NULL,
  local varchar(50) NOT NULL,
  cell varchar(50) NOT NULL,
  status varchar(50) NOT NULL,
  comment varchar(1000) NOT NULL,
  lastUpdated varchar(50) NOT NULL,
  team varchar(50) NOT NULL,
  isManager varchar(10) NOT NULL,
  hasSpecialRole varchar(10) NOT NULL,
  email varchar(30) NOT NULL,
  loginPwd varchar(255) NOT NULL,
  isAdmin varchar(30) NOT NULL
) Engine=InnoDB;

INSERT INTO `employee` (`id`, `name`, `local`, `cell`, `status`, `comment`, `lastUpdated`, `team`, `isManager`, `hasSpecialRole`, `email`, `loginPwd`, `isAdmin`) VALUES
(1, 'Bruce Wayne', '5359', '123-456-7890', 'Out', 'Just bought a new batmobile, taking it out for a spin with Alfred later.', '05-Mar-2022 @ <b>8:49 pm</b>', 'Accounting', 'Yes', 'Yes', 'test@email.com', '$2y$10$JNjxkOq70QTkT1SdoLwLUOJmyhirD2oBGxo3Z2Io.EiPRpxJFlW3i', 'Yes');

CREATE TABLE IF NOT EXISTS contact (
  contactID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  contactName varchar(1000) NOT NULL,
  contactLocal varchar(50) NOT NULL,
  contactCell varchar(50) NOT NULL
) Engine=InnoDB;

CREATE TABLE IF NOT EXISTS specialRole (
  roleID int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  roleName varchar(1000) NOT NULL,
  assignedTo varchar(1000) NOT NULL,
  lastUpdated varchar(50) NOT NULL
) Engine=InnoDB;