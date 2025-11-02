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
-- Structure de la table `reponses`
--

CREATE TABLE `reponses` (
  `id` int(11) NOT NULL,
  `id_dictee` int(11) DEFAULT NULL,
  `id_eleve` int(11) DEFAULT NULL,
  `reponse` text,
  `erreurs` text,
  `date_saisie` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `reponses`
--

INSERT INTO `reponses` (`id`, `id_dictee`, `id_eleve`, `reponse`, `erreurs`, `date_saisie`) VALUES
(239, 80, 3, 'chien; chat; le lapin; une souri; Le chien cour dan le jardin', 'NOM (1 erreur):\n- souris ≠ souri (orthographe)\nVERBE (1 erreur):\n- court ≠ cour (désinence)\nPRÉPOSITION (1 erreur):\n- dans ≠ dan (orthographe)\nPONCTUATION (1 erreur):\n- . ≠ (omission)\n', '2025-04-10 00:00:00'),
(240, 81, 69, 'casserole; fourchete; une asiete; le coutau; La soupe es chaud', 'NOM (3 erreurs):\n- fourchette ≠ fourchete (orthographe)\n- assiette ≠ asiete (orthographe)\n- couteau ≠ coutau (orthographe)\nVERBE (1 erreur):\n- est ≠ es (désinence)\nPONCTUATION (1 erreur):\n- . ≠ (omission)\nADJECTIF (1 erreur):\n- chaude ≠ chaud (désinence)\n', '2025-03-07 00:00:00'),
(241, 81, 78, 'casserole; fourchet; une assiete; le couteau; La soupe est chaud', 'NOM (2 erreurs):\n- fourchette ≠ fourchet (orthographe)\n- assiette ≠ assiete (orthographe)\nPONCTUATION (1 erreur):\n- . ≠ (omission)\nADJECTIF (1 erreur):\n- chaude ≠ chaud (désinence)\n', '2025-03-06 00:00:00'),
(242, 82, 69, 'cochon; cheval; le mouton; un poul; Le coc chant le matin', 'NOM (2 erreurs):\n- poule ≠ poul (orthographe)\n- coq ≠ (omission)\nVERBE (1 erreur):\n- chante ≠ chant (désinence)\nDÉTERMINANT (1 erreur):\n- une ≠ un (désinence)\nPONCTUATION (1 erreur):\n- . ≠ (omission)\n', '2025-02-07 00:00:00'),
(243, 84, 81, 'main; jambe; la tete; un bras; Le garçon léve la main', 'NOM (1 erreur):\n- tête ≠ tete (accent)\nVERBE (1 erreur):\n- lève ≠ léve (accent)\nPONCTUATION (1 erreur):\n- . ≠ (omission)\n', '2025-05-17 00:00:00'),
(244, 45, 82, 'griffe; moustache; les poils; le lait; Le chat dort sur le coussin.', '', '2025-04-11 00:00:00');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dictee` (`id_dictee`),
  ADD KEY `id_eleve` (`id_eleve`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `reponses`
--
ALTER TABLE `reponses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=245;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`id_dictee`) REFERENCES `dictees` (`id`),
  ADD CONSTRAINT `reponses_ibfk_2` FOREIGN KEY (`id_eleve`) REFERENCES `eleves` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
