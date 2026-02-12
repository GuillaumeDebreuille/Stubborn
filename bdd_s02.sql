-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 12 fév. 2026 à 08:38
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
-- Base de données : `bdd_s02`
--

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260131115305', '2026-01-31 12:53:29', 148),
('DoctrineMigrations\\Version20260131122027', '2026-01-31 13:20:51', 89),
('DoctrineMigrations\\Version20260201105436', '2026-02-01 11:56:03', 159),
('DoctrineMigrations\\Version20260201113238', '2026-02-01 12:32:55', 10),
('DoctrineMigrations\\Version20260202215247', '2026-02-02 22:55:18', 146);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `size` varchar(5) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sweat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `size`, `quantity`, `sweat_id`) VALUES
(1, 'XS', 1, 1),
(2, 'S', 2, 1),
(3, 'M', 2, 1),
(4, 'L', 2, 1),
(5, 'XL', 2, 1),
(6, 'XS', 2, 2),
(7, 'S', 2, 2),
(8, 'M', 2, 2),
(9, 'L', 2, 2),
(10, 'XL', 2, 2),
(11, 'XS', 2, 3),
(12, 'S', 2, 3),
(13, 'M', 2, 3),
(14, 'L', 2, 3),
(15, 'XL', 2, 3),
(16, 'XS', 2, 4),
(17, 'S', 2, 4),
(18, 'M', 2, 4),
(19, 'L', 2, 4),
(20, 'XL', 2, 4),
(21, 'XS', 2, 5),
(22, 'S', 2, 5),
(23, 'M', 2, 5),
(24, 'L', 2, 5),
(25, 'XL', 2, 5),
(26, 'XS', 2, 6),
(27, 'S', 2, 6),
(28, 'M', 2, 6),
(29, 'L', 2, 6),
(30, 'XL', 2, 6),
(31, 'XS', 2, 7),
(32, 'S', 2, 7),
(33, 'M', 2, 7),
(34, 'L', 2, 7),
(35, 'XL', 2, 7),
(36, 'XS', 2, 8),
(37, 'S', 2, 8),
(38, 'M', 2, 8),
(39, 'L', 2, 8),
(40, 'XL', 2, 8),
(41, 'XS', 2, 9),
(42, 'S', 2, 9),
(43, 'M', 2, 9),
(44, 'L', 2, 9),
(45, 'XL', 2, 9),
(46, 'XS', 2, 10),
(47, 'S', 2, 10),
(48, 'M', 2, 10),
(49, 'L', 2, 10),
(50, 'XL', 2, 10);

-- --------------------------------------------------------

--
-- Structure de la table `sweat_shirt`
--

CREATE TABLE `sweat_shirt` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `sweat_shirt`
--

INSERT INTO `sweat_shirt` (`id`, `name`, `price`, `image`) VALUES
(1, 'Blackbelt**', 29.90, 'picture1.png'),
(2, 'BlueBelt.', 29.90, 'picture2.png'),
(3, 'Street.', 34.50, 'picture3.png'),
(4, 'Pokeball**', 45.00, 'picture4.png'),
(5, 'PinkLady', 29.90, 'picture5.png'),
(6, 'Snow', 32.00, 'picture6.png'),
(7, 'Greyback', 28.50, 'picture7.png'),
(8, 'BlueCloud', 45.00, 'picture8.png'),
(9, 'BornInUsa **', 59.90, 'picture9.png'),
(10, 'GreenSchool', 42.20, 'picture10.png');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `delivery_address` varchar(255) NOT NULL,
  `is_verified` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `delivery_address`, `is_verified`) VALUES
(18, 'test3535@gmail.com', '[]', '$2y$13$bBjrs6UqijZTNI/3taS5V.VY5RkuZRu/J5MMC9lKuNHRCHUY8l3Ne', 'Debr', '10 rue Tours', 1),
(19, 'admin@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$HQiqYVe2tNIEx9pkVYweNeEUfQ5me7gd1tFjfYy4i/Jd5qO6ae9j6', 'Admin1', 'rue polo', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4B365660EF044C42` (`sweat_id`);

--
-- Index pour la table `sweat_shirt`
--
ALTER TABLE `sweat_shirt`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `sweat_shirt`
--
ALTER TABLE `sweat_shirt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `FK_4B365660EF044C42` FOREIGN KEY (`sweat_id`) REFERENCES `sweat_shirt` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
