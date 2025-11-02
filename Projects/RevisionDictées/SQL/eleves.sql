-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 08 Mai 2025 à 13:04
-- Version du serveur :  10.1.48-MariaDB-0ubuntu0.18.04.1
-- Version de PHP :  7.2.24-0ubuntu0.18.04.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `leteillierm`
--

-- --------------------------------------------------------

--
-- Structure de la table `eleves`
--

CREATE TABLE `eleves` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `niveau` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `eleves`
--

INSERT INTO `eleves` (`id`, `nom`, `niveau`) VALUES
(1, 'Riam', 'CM1'),
(2, 'Yasmine', 'CM1'),
(3, 'Alice', 'CM1'),
(4, 'Lucas', 'CM1'),
(5, 'Emma', 'CM1'),
(6, 'Léo', 'CM1'),
(7, 'Chloé', 'CM1'),
(8, 'Nathan', 'CM1'),
(9, 'Jade', 'CM1'),
(10, 'Gabriel', 'CM1'),
(11, 'Lina', 'CM1'),
(12, 'Raphaël', 'CM1'),
(13, 'Louise', 'CM1'),
(14, 'Hugo', 'CM1'),
(15, 'Léa', 'CM1'),
(16, 'Arthur', 'CM1'),
(17, 'Zoé', 'CM1'),
(18, 'Ethan', 'CM1'),
(19, 'Manon', 'CM1'),
(20, 'Louis', 'CM1'),
(21, 'Anna', 'CM1'),
(22, 'Tom', 'CM1'),
(68, 'Mélina', 'CE2'),
(69, 'Axel', 'CE2'),
(70, 'Nina', 'CE2'),
(71, 'Bastien', 'CE2'),
(72, 'Louna', 'CE2'),
(73, 'Matéo', 'CE2'),
(74, 'Soline', 'CE2'),
(75, 'Noé', 'CE2'),
(76, 'Elsa', 'CE2'),
(77, 'Ilan', 'CE2'),
(78, 'Amélie', 'CE2'),
(79, 'Téo', 'CE2'),
(80, 'Maëlle', 'CE2'),
(81, 'Eliott', 'CE2'),
(82, 'Célia', 'CE2'),
(83, 'Noham', 'CE2'),
(84, 'Amandine', 'CE2'),
(85, 'Elias', 'CE2'),
(86, 'Clémence', 'CE2'),
(87, 'Naël', 'CE2'),
(88, 'Élise', 'CE2'),
(89, 'Adrien', 'CE2'),
(90, 'Cassandra', 'CE2'),
(91, 'Ismaël', 'CE2'),
(92, 'Léonie', 'CE2');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `eleves`
--
ALTER TABLE `eleves`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `eleves`
--
ALTER TABLE `eleves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
