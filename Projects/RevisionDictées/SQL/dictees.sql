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
-- Structure de la table `dictees`
--

CREATE TABLE `dictees` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) DEFAULT NULL,
  `contenu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `dictees`
--

INSERT INTO `dictees` (`id`, `titre`, `contenu`) VALUES
(45, 'Le chat', 'griffe; moustache; les poils; le lait; Le chat dort sur le coussin.'),
(46, 'Les fleurs', 'coquelicot, rose, les forêts, le parc, Elle a mangé dans l\'herbe.'),
(80, 'Les animaux', 'chien; chat; le lapin; une souris; Le chien court dans le jardin.'),
(81, 'La cuisine', 'casserole; fourchette; une assiette; le couteau; La soupe est chaude.'),
(82, 'La ferme', 'cochon; cheval; le mouton; une poule; Le coq chante le matin.'),
(83, 'L’école', 'stylo; cahier; une trousse; le cartable; L’élève ouvre son cahier.'),
(84, 'Le corps humain', 'main; jambe; la tête; un bras; Le garçon lève la main.'),
(85, 'La maison', 'table; armoire; une chaise; le canapé; Papa lit sur le canapé.'),
(86, 'Le printemps', 'fleur; soleil; une abeille; le papillon; Le papillon vole dans le ciel.'),
(87, 'L’hiver', 'neige; bonnet; une écharpe; le manteau; Il met son manteau chaud.');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `dictees`
--
ALTER TABLE `dictees`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `dictees`
--
ALTER TABLE `dictees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
