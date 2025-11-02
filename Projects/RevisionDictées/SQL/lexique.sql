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
-- Structure de la table `lexique`
--

CREATE TABLE `lexique` (
  `mot` varchar(100) NOT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `lemme` varchar(50) DEFAULT NULL,
  `desinence` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `lexique`
--

INSERT INTO `lexique` (`mot`, `categorie`, `lemme`, `desinence`) VALUES
('.', 'ponctuation', '.', ''),
('a', 'verbe', 'avoir', ''),
('abeille', 'nom', 'abeille', ''),
('après', 'préposition', 'après', ''),
('armoire', 'nom', 'armoire', ''),
('assiette', 'nom', 'assiette', ''),
('au', 'déterminant', 'à le', ''),
('aux', 'déterminant', 'à le', 'x'),
('avant', 'préposition', 'avant', ''),
('avec', 'préposition', 'avec', ''),
('bonnet', 'nom', 'bonnet', ''),
('bras', 'nom', 'bras', ''),
('ça', 'pronom', 'cela', ''),
('cahier', 'nom', 'cahier', ''),
('canapé', 'nom', 'canapé', ''),
('cartable', 'nom', 'cartable', ''),
('casserole', 'nom', 'casserole', ''),
('ce', 'déterminant', 'ce', ''),
('cela', 'pronom', 'cela', ''),
('ces', 'déterminant', 'ce', 's'),
('cet', 'déterminant', 'ce', ''),
('cette', 'déterminant', 'ce', ''),
('chaise', 'nom', 'chaise', ''),
('chante', 'verbe', 'chanter', 'e'),
('chat', 'nom', 'chat', ''),
('chaud', 'adjectif', 'chaud', ''),
('chaude', 'adjectif', 'chaud', 'e'),
('cheval', 'nom', 'cheval', ''),
('chez', 'préposition', 'chez', ''),
('chien', 'nom', 'chien', ''),
('ciel', 'nom', 'ciel', ''),
('cochon', 'nom', 'cochon', ''),
('contre', 'préposition', 'contre', ''),
('coq', 'nom', 'coq', ''),
('coquelicot', 'nom', 'coquelicot', ''),
('court', 'verbe', 'courir', 't'),
('coussin', 'nom', 'coussin', ''),
('couteau', 'nom', 'couteau', ''),
('dans', 'préposition', 'dans', ''),
('depuis', 'préposition', 'depuis', ''),
('derrière', 'préposition', 'derrière', ''),
('des', 'déterminant', 'de', 's'),
('devant', 'préposition', 'devant', ''),
('dort', 'verbe', 'dormir', 't'),
('du', 'déterminant', 'de', ''),
('durant', 'préposition', 'durant', ''),
('écharpe', 'nom', 'écharpe', ''),
('élève', 'nom', 'élève', ''),
('Elle', 'pronom', 'elle', ''),
('elles', 'pronom', 'elles', ''),
('en', 'préposition', 'en', ''),
('entre', 'préposition', 'entre', ''),
('est', 'verbe', 'être', 't'),
('eux', 'pronom', 'eux', ''),
('excepté', 'préposition', 'excepté', ''),
('finis', 'verbe', 'finir', 'is'),
('finissent', 'verbe', 'finir', 'issent'),
('finissez', 'verbe', 'finir', 'issez'),
('finissons', 'verbe', 'finir', 'issons'),
('finit', 'verbe', 'finir', 'it'),
('fleur', 'nom', 'fleur', ''),
('forêts', 'nom', 'forêt', 's'),
('fourchette', 'nom', 'fourchette', ''),
('garçon', 'nom', 'garçon', ''),
('griffe', 'nom', 'griffe', ''),
('herbe', 'nom', 'herbe', ''),
('hors', 'préposition', 'hors', ''),
('il', 'pronom', 'il', ''),
('ils', 'pronom', 'ils', ''),
('j\'', 'pronom', 'je', ''),
('jambe', 'nom', 'jambe', ''),
('jardin', 'nom', 'jardin', ''),
('je', 'pronom', 'je', ''),
('jusqu\'à', 'préposition', 'jusqu\'à', ''),
('l\'', 'déterminant', 'le', ''),
('la', 'déterminant', 'le', ''),
('lait', 'nom', 'lait', ''),
('lapin', 'nom', 'lapin', ''),
('le', 'déterminant', 'le', ''),
('les', 'déterminant', 'le', 's'),
('leur', 'déterminant', 'leur', ''),
('leurs', 'déterminant', 'leur', 's'),
('lève', 'verbe', 'lever', ''),
('lit', 'verbe', 'lire', ''),
('lui', 'pronom', 'lui', ''),
('m\'', 'pronom', 'me', ''),
('ma', 'déterminant', 'mon', ''),
('main', 'nom', 'main', ''),
('malgré', 'préposition', 'malgré', ''),
('mangé', 'verbe', 'manger', 'é'),
('manteau', 'nom', 'manteau', ''),
('matin', 'nom', 'matin', ''),
('me', 'pronom', 'me', ''),
('mes', 'déterminant', 'mon', 's'),
('met', 'verbe', 'mettre', 't'),
('moi', 'pronom', 'moi', ''),
('mon', 'déterminant', 'mon', ''),
('moustache', 'nom', 'moustache', ''),
('mouton', 'nom', 'mouton', ''),
('neige', 'nom', 'neige', ''),
('nos', 'déterminant', 'notre', 's'),
('notre', 'déterminant', 'notre', ''),
('nous', 'pronom', 'nous', ''),
('on', 'pronom', 'on', ''),
('ouvre', 'verbe', 'ouvrir', ''),
('papa', 'nom', 'papa', ''),
('papillon', 'nom', 'papillon', ''),
('par', 'préposition', 'par', ''),
('parc', 'nom', 'parc', ''),
('parle', 'verbe', 'parler', 'e'),
('parlent', 'verbe', 'parler', 'ent'),
('parles', 'verbe', 'parler', 'es'),
('parlez', 'verbe', 'parler', 'ez'),
('parlons', 'verbe', 'parler', 'ons'),
('parmi', 'préposition', 'parmi', ''),
('pendant', 'préposition', 'pendant', ''),
('personne', 'pronom', 'personne', ''),
('poils', 'nom', 'poil', 's'),
('pommes', 'nom', 'pomme', 's'),
('poule', 'nom', 'poule', ''),
('pour', 'préposition', 'pour', ''),
('prend', 'verbe', 'prendre', ''),
('prends', 'verbe', 'prendre', 's'),
('prenez', 'verbe', 'prendre', 'ez'),
('prennent', 'verbe', 'prendre', 'nent'),
('prenons', 'verbe', 'prendre', 'ons'),
('quelqu\'un', 'pronom', 'quelqu\'un', ''),
('rien', 'pronom', 'rien', ''),
('rose', 'nom', 'rose', ''),
('s\'', 'pronom', 'se', ''),
('sa', 'déterminant', 'son', ''),
('sans', 'préposition', 'sans', ''),
('se', 'pronom', 'se', ''),
('selon', 'préposition', 'selon', ''),
('ses', 'déterminant', 'son', 's'),
('soleil', 'nom', 'soleil', ''),
('son', 'déterminant', 'son', ''),
('soupe', 'nom', 'soupe', ''),
('souris', 'nom', 'souris', ''),
('sous', 'préposition', 'sous', ''),
('stylo', 'nom', 'stylo', ''),
('sur', 'préposition', 'sur', ''),
('t\'', 'pronom', 'te', ''),
('ta', 'déterminant', 'ton', ''),
('table', 'nom', 'table', ''),
('te', 'pronom', 'te', ''),
('tes', 'déterminant', 'ton', 's'),
('tête', 'nom', 'tête', ''),
('toi', 'pronom', 'toi', ''),
('ton', 'déterminant', 'ton', ''),
('trousse', 'nom', 'trousse', ''),
('tu', 'pronom', 'tu', ''),
('un', 'déterminant', 'un', ''),
('une', 'déterminant', 'un', 'e'),
('vers', 'préposition', 'vers', ''),
('via', 'préposition', 'via', ''),
('vole', 'verbe', 'voler', 'e'),
('vos', 'déterminant', 'votre', 's'),
('votre', 'déterminant', 'votre', ''),
('vous', 'pronom', 'vous', '');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `lexique`
--
ALTER TABLE `lexique`
  ADD PRIMARY KEY (`mot`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
