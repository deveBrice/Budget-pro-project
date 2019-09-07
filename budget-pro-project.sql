-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 01 sep. 2019 à 21:20
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `budget-pro-project`
--

-- --------------------------------------------------------

--
-- Structure de la table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_card_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_card_number` int(11) NOT NULL,
  `currency_code` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_161498D3A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `card`
--

INSERT INTO `card` (`id`, `user_id`, `name`, `credit_card_type`, `credit_card_number`, `currency_code`, `value`) VALUES
(1, NULL, 'Brice', 'Master_card', 1, 758, 10000);

-- --------------------------------------------------------

--
-- Structure de la table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
CREATE TABLE IF NOT EXISTS `subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slogan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `subscription`
--

INSERT INTO `subscription` (`id`, `name`, `slogan`, `url`) VALUES
(21, 'gagner_plus', 'blabl', 'http://gagner_plus.com');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:simple_array)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649C912ED9D` (`api_key`),
  KEY `IDX_8D93D6499A1887DC` (`subscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `subscription_id`, `firstname`, `lastname`, `email`, `api_key`, `created_at`, `address`, `country`, `roles`, `password`) VALUES
(22, NULL, 'Tianna', 'Ziemann', 'rubye76@hotmail.com', 'S8@PL.INF', '1997-10-04 07:16:07', '346 Johns Neck Apt. 565\nWeimannfort, HI 71597', 'Vanuatu', 'ROLE_USER', 'a)bQsrun'),
(23, NULL, 'Caitlyn', 'Wisoky', 'beier.marc@ullrich.com', 'GMIH@P-B.GQZ', '1986-12-25 20:29:46', '844 Anais Orchard Suite 086\nGreenfelderton, OK 13002', 'Macedonia', 'ROLE_USER', '(?w4v9'),
(24, NULL, 'Josie', 'McDermott', 'lambert85@will.com', '%@0SW.OBT', '1996-08-13 15:05:49', '851 Leola Courts Apt. 456\nKilbackland, CO 61814', 'Mozambique', 'ROLE_USER', 'oAx\\AV7\\ert=[]'),
(25, NULL, 'Maci', 'Heidenreich', 'stanton.romaguera@marvin.com', 'E@3.BBL', '1987-08-25 15:22:11', '7379 Bradtke Flats\nZelmaberg, MA 67591', 'Micronesia', 'ROLE_USER', '!t<]M)h[L}e(o'),
(26, NULL, 'Judge', 'Adams', 'dledner@hotmail.com', 'C3VFH-@XA8-S.TCDH', '1993-03-02 06:02:42', '71605 Dorothea Common\nVitastad, ND 97781', 'China', 'ROLE_USER', 'c6d2ZEIr89IUW-\\y/,'),
(27, NULL, 'Andres', 'Von', 'fadel.mckayla@gmail.com', 'LID5@6.TV', '2009-09-08 22:31:45', '9026 Gibson Spring\nDamionbury, WY 10172-8628', 'Canada', 'ROLE_USER', '\"Ax$P2Y7VS>L\"uHq['),
(28, NULL, 'Judd', 'Schaefer', 'mhartmann@hotmail.com', 'PMx697%@YVT59X.TR', '2006-02-27 18:24:45', '17368 Eriberto Bridge Apt. 771\nWest Allene, MD 92520-0107', 'Italy', 'ROLE_USER', '(}B(E<N0E'),
(29, NULL, 'Jackie', 'Lowe', 'jvonrueden@yahoo.com', 'D@F.IMZ', '2018-09-18 10:56:07', '417 Ledner Stream\nOsinskiport, CT 80949-0690', 'Kenya', 'ROLE_USER', 'dy]Hush/#v$'),
(30, NULL, 'Herbert', 'Klocko', 'kassulke.bailee@yahoo.com', 'zM6|H@VUGH3P.PY', '1998-11-30 06:42:53', '4084 Champlin Brook Suite 620\nNorth Gladys, DE 20949-2880', 'Mexico', 'ROLE_USER', '\\A;=G<gx.$g4'),
(31, NULL, 'Antonia', 'Stracke', 'margarita46@yahoo.com', 'S@M7.JLLE', '1971-07-12 05:03:49', '37978 Wyman Hollow\nLake Ayanaside, CO 34081', 'Luxembourg', 'ROLE_USER', '}f=qSRq42V');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `FK_161498D3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6499A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscription` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
