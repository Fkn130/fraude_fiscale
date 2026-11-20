-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 20 nov. 2026 à 13:59
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `fraude_fiscal`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `creer_event` varchar(50) DEFAULT NULL,
  `organiser_event` varchar(50) DEFAULT NULL,
  `planifier_event` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `evenement`
--

CREATE TABLE `evenement` (
  `id` int(11) NOT NULL,
  `even_jeux_video` varchar(50) DEFAULT NULL,
  `date_heure_even` datetime DEFAULT NULL,
  `id_1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sinscire`
--

CREATE TABLE `sinscire` (
  `id` int(11) NOT NULL,
  `id_1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `spectacteur`
--

CREATE TABLE `spectacteur` (
  `id` int(11) NOT NULL,
  `inscription` varchar(50) DEFAULT NULL,
  `nb_place` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `adress_mail` varchar(50) DEFAULT NULL,
  `identifiant` varchar(50) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `adress_mail`, `identifiant`, `mot_de_passe`) VALUES
(1, NULL, NULL, '', NULL, 'da39a3ee5e6b4b0d3255bfef95601890afd80709'),
(2, NULL, NULL, 'te-uyre', NULL, '7b52009b64fd0a2a49e6d8a939753077792b0554'),
(3, NULL, NULL, 'salut', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(4, NULL, NULL, 'furkan', NULL, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(5, NULL, NULL, 'furkan@homo.com', NULL, '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_1` (`id_1`);

--
-- Index pour la table `sinscire`
--
ALTER TABLE `sinscire`
  ADD PRIMARY KEY (`id`,`id_1`),
  ADD KEY `id_1` (`id_1`);

--
-- Index pour la table `spectacteur`
--
ALTER TABLE `spectacteur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `evenement`
--
ALTER TABLE `evenement`
  ADD CONSTRAINT `evenement_ibfk_1` FOREIGN KEY (`id_1`) REFERENCES `admin` (`id`);

--
-- Contraintes pour la table `sinscire`
--
ALTER TABLE `sinscire`
  ADD CONSTRAINT `sinscire_ibfk_1` FOREIGN KEY (`id`) REFERENCES `evenement` (`id`),
  ADD CONSTRAINT `sinscire_ibfk_2` FOREIGN KEY (`id_1`) REFERENCES `spectacteur` (`id`);

--
-- Contraintes pour la table `spectacteur`
--
ALTER TABLE `spectacteur`
  ADD CONSTRAINT `spectacteur_ibfk_1` FOREIGN KEY (`id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
