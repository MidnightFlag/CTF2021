-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 27 déc. 2020 à 22:02
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP :  7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `idor`
--

-- --------------------------------------------------------

--
-- Structure de la table `secret`
--

CREATE TABLE `secret` (
  `id` int(5) NOT NULL,
  `content` varchar(100) NOT NULL,
  `pseudo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `secret`
--

INSERT INTO `secret` (`id`, `content`, `pseudo`) VALUES
(142, 'MCTF{IDOR_1nj3t10n_t0_st34l_s3cr3ts}', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `pseudo` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`pseudo`) VALUES
('admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `secret`
--
ALTER TABLE `secret`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Pseudo` (`pseudo`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `secret`
--
ALTER TABLE `secret`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `secret`
--
ALTER TABLE `secret`
  ADD CONSTRAINT `fk_Pseudo` FOREIGN KEY (`pseudo`) REFERENCES `users` (`pseudo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
