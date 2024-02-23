-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 23 fév. 2024 à 19:14
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `note_student`
--

CREATE TABLE `note_student` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `qcms_id` int(11) DEFAULT NULL,
  `score` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `note_student`
--

INSERT INTO `note_student` (`id`, `users_id`, `qcms_id`, `score`) VALUES
(88, 10, 1, 50);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `note_student`
--
ALTER TABLE `note_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_36856BA967B3B43D` (`users_id`),
  ADD KEY `IDX_36856BA9D83BD9B9` (`qcms_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `note_student`
--
ALTER TABLE `note_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `note_student`
--
ALTER TABLE `note_student`
  ADD CONSTRAINT `FK_36856BA967B3B43D` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_36856BA9D83BD9B9` FOREIGN KEY (`qcms_id`) REFERENCES `qcm` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
