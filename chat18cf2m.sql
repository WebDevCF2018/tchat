-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 27 avr. 2018 à 14:06
-- Version du serveur :  5.7.19
-- Version de PHP :  7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `chat18cf2m`
--

-- --------------------------------------------------------

--
-- Structure de la table `themessage`
--

DROP TABLE IF EXISTS `themessage`;
CREATE TABLE IF NOT EXISTS `themessage` (
  `idmessage` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `thedatetime` timestamp NOT NULL,
  `thecontent` varchar(800) DEFAULT NULL,
  `theuser_idutil` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`idmessage`),
  KEY `fk_themessage_theuser_idx` (`theuser_idutil`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `theuser`
--

DROP TABLE IF EXISTS `theuser`;
CREATE TABLE IF NOT EXISTS `theuser` (
  `idutil` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `themail` varchar(255) NOT NULL,
  `thelogin` varchar(50) NOT NULL,
  `thepwd` varchar(64) NOT NULL,
  `thekey` varchar(64) DEFAULT NULL,
  `thevalidate` tinyint(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`idutil`),
  UNIQUE KEY `thelogin_UNIQUE` (`thelogin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `themessage`
--
ALTER TABLE `themessage`
  ADD CONSTRAINT `fk_themessage_theuser` FOREIGN KEY (`theuser_idutil`) REFERENCES `theuser` (`idutil`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
