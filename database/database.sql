-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server versie:                10.4.28-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Versie:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Databasestructuur van situatieassistent wordt geschreven
CREATE DATABASE IF NOT EXISTS `situatieassistent` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `situatieassistent`;

-- Structuur van  tabel situatieassistent.companies wordt geschreven
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(112) NOT NULL,
  `uuid` varchar(112) NOT NULL DEFAULT uuid_short(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel situatieassistent.companies: ~1 rows (ongeveer)
INSERT INTO `companies` (`id`, `name`, `uuid`) VALUES
	(1, 'Marktplaats', '100623022125219866');

-- Structuur van  tabel situatieassistent.departments wordt geschreven
CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(112) NOT NULL,
  `uuid` varchar(112) NOT NULL DEFAULT uuid_short(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel situatieassistent.departments: ~1 rows (ongeveer)
INSERT INTO `departments` (`id`, `name`, `uuid`) VALUES
	(1, 'CSD', '100599963704098817');

-- Structuur van  tabel situatieassistent.dialogs wordt geschreven
CREATE TABLE IF NOT EXISTS `dialogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `qa` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `panel` varchar(255) NOT NULL,
  `previous_dialog` varchar(255) NOT NULL,
  `next_dialogs` varchar(255) NOT NULL,
  `next_dialogs_urls` varchar(255) NOT NULL,
  `is_root` int(11) NOT NULL DEFAULT 0,
  `uuid` varchar(50) NOT NULL DEFAULT uuid_short(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel situatieassistent.dialogs: ~5 rows (ongeveer)
INSERT INTO `dialogs` (`id`, `title`, `qa`, `department`, `panel`, `previous_dialog`, `next_dialogs`, `next_dialogs_urls`, `is_root`, `uuid`) VALUES
	(15, 'Account geblokkeerd', 'Welke vraag heb je?', '100599963704098817', '100599963704098818', '', 'Hoe kan ik mijn wachtwoord wijzigen?, Ik kan niet inloggen op mijn account., Hoe kan ik mijn account beveiligen?, Ik denk dat mijn account is gehackt.', '100623022125219870', 1, '100623022125219857'),
	(24, 'Hoe kan ik mijn wachtwoord wijzigen?', 'Om je wachtwoord te wijzigen, ga naar de instellingen van je account en kies de optie \'Wachtwoord wijzigen\'. Je wordt dan gevraagd om je huidige wachtwoord in te voeren en het nieuwe wachtwoord te bevestigen.', '100599963704098817', '100599963704098818', '100623022125219857', '', '', 0, '100623022125219867'),
	(25, 'Ik kan niet inloggen op mijn account.', 'Als je problemen hebt met inloggen, controleer dan of je de juiste gebruikersnaam en wachtwoord gebruikt. Als het probleem aanhoudt, gebruik dan de \'Wachtwoord vergeten\' optie om je wachtwoord opnieuw in te stellen.', '100599963704098817', '100599963704098818', '100623022125219857', '', '', 0, '100623022125219868'),
	(26, 'Hoe kan ik mijn account beveiligen?', 'Om je account te beveiligen, activeer tweestapsverificatie. Ga naar de beveiligingsinstellingen en volg de instructies om een extra beveiligingslaag toe te voegen aan je account.', '100599963704098817', '100599963704098818', '100623022125219857', '', '', 0, '100623022125219869'),
	(27, 'Ik denk dat mijn account is gehackt.', 'Als je vermoedt dat je account is gehackt, wijzig dan onmiddellijk je wachtwoord en meld het verdachte activiteiten aan onze ondersteuning. We zullen je helpen de nodige stappen te ondernemen.', '100599963704098817', '100599963704098818', '100623022125219857', '', '', 0, '100623022125219870');

-- Structuur van  tabel situatieassistent.dialog_panels wordt geschreven
CREATE TABLE IF NOT EXISTS `dialog_panels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(112) NOT NULL DEFAULT '',
  `department` varchar(112) NOT NULL,
  `uuid` varchar(112) NOT NULL DEFAULT uuid_short(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel situatieassistent.dialog_panels: ~3 rows (ongeveer)
INSERT INTO `dialog_panels` (`id`, `name`, `department`, `uuid`) VALUES
	(1, 'Account & Veiligheid', '100599963704098817', '100599963704098818'),
	(2, 'Adverteren', '100599963704098817', '100599963704098836'),
	(3, 'Kopen', '100599963704098817', '100599963704098837');

-- Structuur van  tabel situatieassistent.users wordt geschreven
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(112) NOT NULL,
  `password` varchar(112) NOT NULL,
  `full_name` varchar(112) NOT NULL,
  `company` varchar(112) NOT NULL,
  `department` varchar(112) NOT NULL,
  `isAdmin` int(11) DEFAULT NULL,
  `uuid` varchar(112) NOT NULL DEFAULT uuid(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumpen data van tabel situatieassistent.users: ~1 rows (ongeveer)
INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `company`, `department`, `isAdmin`, `uuid`) VALUES
	(5, 'Demo', '$2y$10$TvgXoVbljukbPp6KcWkHZO1kQRQ55GlWkL.Kd7aZaiXO0FO1uPE8W', 'demo', 'Marktplaats', 'CSD', 1, 'dad388f7-9b4c-11ee-bb58-d880831e28d0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
