-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 12 mai 2025 à 12:13
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionof`
--

-- --------------------------------------------------------

--
-- Structure de la table `control`
--

DROP TABLE IF EXISTS `control`;
CREATE TABLE IF NOT EXISTS `control` (
  `idControl` int NOT NULL AUTO_INCREMENT,
  `idOF` varchar(50) NOT NULL,
  `idPersonnel` int NOT NULL,
  `numeroJeton` int NOT NULL,
  `testeur` varchar(50) NOT NULL,
  `epaisseur` decimal(8,2) NOT NULL,
  `diametre` decimal(8,2) NOT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `dateControl` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `conformite` tinyint(1) NOT NULL,
  PRIMARY KEY (`idControl`),
  KEY `control_personnel_FK` (`idPersonnel`),
  KEY `control_ordreFabrication_FK` (`idOF`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `control`
--

INSERT INTO `control` (`idControl`, `idOF`, `idPersonnel`, `numeroJeton`, `testeur`, `epaisseur`, `diametre`, `couleur`, `dateControl`, `conformite`) VALUES
(70, 'OF35653', 13, 1, 'Dupont', '2.30', '23.00', 'Blanc', '2025-04-24 11:43:25', 1),
(71, 'OF35653', 13, 2, 'Dupont', '2.50', '24.00', 'Blanc', '2025-04-24 11:43:26', 0),
(72, 'OF35653', 13, 3, 'Dupont', '2.70', '25.00', 'Blanc', '2025-04-24 11:43:26', 0),
(73, 'OF35653', 13, 4, 'Dupont', '2.30', '23.00', 'Blanc', '2025-04-24 11:43:26', 1);

-- --------------------------------------------------------

--
-- Structure de la table `fichelivraison`
--

DROP TABLE IF EXISTS `fichelivraison`;
CREATE TABLE IF NOT EXISTS `fichelivraison` (
  `idLivraison` int NOT NULL AUTO_INCREMENT,
  `idOF` varchar(50) NOT NULL,
  `idPersonnel` int NOT NULL,
  `dateLivraison` datetime NOT NULL,
  PRIMARY KEY (`idLivraison`),
  UNIQUE KEY `unique_fichelivraison_per_of` (`idOF`),
  KEY `fk_ficheLivraison_personnel` (`idPersonnel`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `fichelivraison`
--

INSERT INTO `fichelivraison` (`idLivraison`, `idOF`, `idPersonnel`, `dateLivraison`) VALUES
(71, 'OF35653', 12, '2025-04-19 11:40:00'),
(72, 'OF4562', 12, '2025-04-18 11:40:00');

-- --------------------------------------------------------

--
-- Structure de la table `inventaire`
--

DROP TABLE IF EXISTS `inventaire`;
CREATE TABLE IF NOT EXISTS `inventaire` (
  `idInventaire` int NOT NULL AUTO_INCREMENT,
  `dateSoumission` date NOT NULL,
  `idPersonnel` int NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'en cours',
  PRIMARY KEY (`idInventaire`),
  KEY `fk_inventaire_personnel` (`idPersonnel`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inventaire`
--

INSERT INTO `inventaire` (`idInventaire`, `dateSoumission`, `idPersonnel`, `status`) VALUES
(37, '2025-04-24', 13, 'En attente'),
(38, '2025-04-24', 13, 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `inventaire_details`
--

DROP TABLE IF EXISTS `inventaire_details`;
CREATE TABLE IF NOT EXISTS `inventaire_details` (
  `idDetail` int NOT NULL AUTO_INCREMENT,
  `idInventaire` int NOT NULL,
  `ancienne_quantite` decimal(10,2) DEFAULT NULL,
  `nouvelle_quantite` decimal(10,2) DEFAULT NULL,
  `idProduit` int NOT NULL,
  PRIMARY KEY (`idDetail`),
  KEY `fk_details_produit` (`idProduit`),
  KEY `idInventaire` (`idInventaire`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `inventaire_details`
--

INSERT INTO `inventaire_details` (`idDetail`, `idInventaire`, `ancienne_quantite`, `nouvelle_quantite`, `idProduit`) VALUES
(30, 37, '13.00', '17.00', 26),
(31, 37, '44.00', '50.00', 27),
(32, 37, '26.00', '23.00', 28),
(33, 38, '13.00', '16.00', 26),
(34, 38, '44.00', '46.00', 27),
(35, 38, '26.00', '28.00', 28);

-- --------------------------------------------------------

--
-- Structure de la table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `idLog` int NOT NULL AUTO_INCREMENT,
  `dateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(500) NOT NULL,
  `idPersonnel` int NOT NULL,
  `idOF` varchar(50) NOT NULL,
  PRIMARY KEY (`idLog`),
  KEY `log_personnel_FK` (`idPersonnel`),
  KEY `log_ordreFabrication0_FK` (`idOF`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `log`
--

INSERT INTO `log` (`idLog`, `dateTime`, `action`, `idPersonnel`, `idOF`) VALUES
(29, '2025-04-24 11:22:38', 'Création OF', 13, 'OF0156'),
(30, '2025-04-24 11:27:57', 'Création OF', 13, 'OF4562'),
(31, '2025-04-24 11:30:31', 'Création OF', 13, 'OF35653'),
(32, '2025-04-24 11:40:28', 'Enregistrement fiche livraison', 12, 'OF35653'),
(33, '2025-04-24 11:40:42', 'Enregistrement fiche livraison', 12, 'OF4562'),
(34, '2025-04-24 11:43:26', 'Contrôle Jeton', 13, 'OF35653'),
(35, '2025-05-12 14:09:28', 'Création OF', 12, 'Of3784r'),
(36, '2025-05-12 14:11:46', 'Création OF', 12, 'OF4359');

-- --------------------------------------------------------

--
-- Structure de la table `ordrefabrication`
--

DROP TABLE IF EXISTS `ordrefabrication`;
CREATE TABLE IF NOT EXISTS `ordrefabrication` (
  `idOF` varchar(50) NOT NULL,
  `dateDebut` datetime NOT NULL,
  `dateButoire` datetime NOT NULL,
  `boiteFilme` tinyint(1) NOT NULL,
  `nbreCaisse` int NOT NULL,
  `couleur` varchar(50) NOT NULL,
  `nbreJetonParBoite` int NOT NULL,
  `nbreBoite` int NOT NULL,
  `idRecette` int NOT NULL,
  `idPersonnel` int NOT NULL,
  `idProgramme` int NOT NULL,
  `statut` varchar(500) NOT NULL DEFAULT 'en cours',
  PRIMARY KEY (`idOF`),
  KEY `ordreFabrication_recette_FK` (`idRecette`),
  KEY `ordreFabrication_personnel0_FK` (`idPersonnel`),
  KEY `ordreFabrication_programme1_FK` (`idProgramme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `ordrefabrication`
--

INSERT INTO `ordrefabrication` (`idOF`, `dateDebut`, `dateButoire`, `boiteFilme`, `nbreCaisse`, `couleur`, `nbreJetonParBoite`, `nbreBoite`, `idRecette`, `idPersonnel`, `idProgramme`, `statut`) VALUES
('OF0156', '2025-04-24 11:22:00', '2025-05-11 11:22:00', 1, 2, 'Blanc', 4, 3, 25, 13, 1, 'en cours'),
('OF35653', '2025-04-22 11:29:00', '2025-05-11 11:29:00', 0, 3, 'Rouge', 8, 3, 26, 13, 1, 'terminé'),
('Of3784r', '2025-05-15 14:08:00', '2025-05-24 14:09:00', 1, 2, 'Blanc', 4, 2, 25, 12, 1, 'en cours'),
('OF4359', '2025-05-12 14:11:00', '2025-05-31 14:11:00', 1, 2, 'Blanc', 4, 3, 25, 12, 1, 'en cours'),
('OF4562', '2025-04-27 11:27:00', '2025-05-10 11:27:00', 1, 1, 'Blanc', 6, 4, 27, 13, 1, 'terminé');

--
-- Déclencheurs `ordrefabrication`
--
DROP TRIGGER IF EXISTS `trigger_maj_stock_apres_creation_of`;
DELIMITER $$
CREATE TRIGGER `trigger_maj_stock_apres_creation_of` AFTER INSERT ON `ordrefabrication` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE idProduit_ INT;
    DECLARE qteUtilisee DECIMAL(10,2);
    DECLARE cur CURSOR FOR
        SELECT idProduit, quantite FROM recette_produit WHERE idRecette = NEW.idRecette;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO idProduit_, qteUtilisee;
        IF done THEN
            LEAVE read_loop;
        END IF;

        UPDATE produit
        SET quantite = quantite - qteUtilisee
        WHERE idProduit = idProduit_;
    END LOOP;

    CLOSE cur;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `personnels`
--

DROP TABLE IF EXISTS `personnels`;
CREATE TABLE IF NOT EXISTS `personnels` (
  `idPersonnel` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mdp` varchar(500) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`idPersonnel`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `personnels`
--

INSERT INTO `personnels` (`idPersonnel`, `nom`, `prenom`, `email`, `mdp`, `role`) VALUES
(12, 'admin', 'admin', 'admin@gmail.com', '$2y$12$1l4.xMEcRSz0NYDsxeSwIu7HEWvChWk5F5H9EEVBJzkYfQaW0qvnq', 'Superviseur'),
(13, 'toto', 'titi', 'toto@gmail.com', '$2y$12$1o8IMPO8VNNXt4OIoHVqS.6BXW7Fdcx8729VA3epMeMUQ8hCtMIH.', 'Technicien');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `quantite` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idProduit`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`idProduit`, `nom`, `quantite`) VALUES
(26, 'produit1', '11.70'),
(27, 'produit2', '40.00'),
(28, 'produit3', '26.38');

-- --------------------------------------------------------

--
-- Structure de la table `programme`
--

DROP TABLE IF EXISTS `programme`;
CREATE TABLE IF NOT EXISTS `programme` (
  `idProgramme` int NOT NULL,
  `boite` varchar(50) NOT NULL,
  `positionBox` varchar(50) NOT NULL,
  `positionRegul` varchar(50) NOT NULL,
  `film` varchar(50) NOT NULL,
  `nbreBriquette` int NOT NULL,
  `taillecaisse` varchar(50) NOT NULL,
  `gravitaire` tinyint(1) NOT NULL,
  PRIMARY KEY (`idProgramme`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `programme`
--

INSERT INTO `programme` (`idProgramme`, `boite`, `positionBox`, `positionRegul`, `film`, `nbreBriquette`, `taillecaisse`, `gravitaire`) VALUES
(1, '>Grande', 'Portrait', 'Paysage', 'Petite', 2, 'Grande', 0),
(2, 'Petite', 'Paysage', 'Paysage', 'Petite', 4, 'Petite', 1);

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `idRecette` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`idRecette`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`idRecette`, `nom`) VALUES
(25, 'recette1'),
(26, 'recette2'),
(27, 'recette3');

-- --------------------------------------------------------

--
-- Structure de la table `recette_produit`
--

DROP TABLE IF EXISTS `recette_produit`;
CREATE TABLE IF NOT EXISTS `recette_produit` (
  `idRecette` int NOT NULL,
  `idProduit` int NOT NULL,
  `quantite` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idRecette`,`idProduit`),
  KEY `recette_produit_produit0_FK` (`idProduit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `recette_produit`
--

INSERT INTO `recette_produit` (`idRecette`, `idProduit`, `quantite`) VALUES
(25, 26, '1.04'),
(25, 27, '2.30'),
(26, 26, '5.20'),
(26, 28, '3.10'),
(27, 27, '3.70'),
(27, 28, '1.02');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `control`
--
ALTER TABLE `control`
  ADD CONSTRAINT `fk_control_ordreFabrication` FOREIGN KEY (`idOF`) REFERENCES `ordrefabrication` (`idOF`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_control_personnel` FOREIGN KEY (`idPersonnel`) REFERENCES `personnels` (`idPersonnel`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fichelivraison`
--
ALTER TABLE `fichelivraison`
  ADD CONSTRAINT `fk_ficheLivraison_ordreFabrication` FOREIGN KEY (`idOF`) REFERENCES `ordrefabrication` (`idOF`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_ficheLivraison_personnel` FOREIGN KEY (`idPersonnel`) REFERENCES `personnels` (`idPersonnel`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inventaire`
--
ALTER TABLE `inventaire`
  ADD CONSTRAINT `fk_inventaire_personnel` FOREIGN KEY (`idPersonnel`) REFERENCES `personnels` (`idPersonnel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `inventaire_details`
--
ALTER TABLE `inventaire_details`
  ADD CONSTRAINT `fk_inventaire_details_inventaire` FOREIGN KEY (`idInventaire`) REFERENCES `inventaire` (`idInventaire`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inventaire_details_produit` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ordreFabrication0_FK` FOREIGN KEY (`idOF`) REFERENCES `ordrefabrication` (`idOF`),
  ADD CONSTRAINT `log_personnel_FK` FOREIGN KEY (`idPersonnel`) REFERENCES `personnels` (`idPersonnel`);

--
-- Contraintes pour la table `ordrefabrication`
--
ALTER TABLE `ordrefabrication`
  ADD CONSTRAINT `fk_ordreFabrication_programme` FOREIGN KEY (`idProgramme`) REFERENCES `programme` (`idProgramme`) ON DELETE CASCADE,
  ADD CONSTRAINT `ordreFabrication_personnel0_FK` FOREIGN KEY (`idPersonnel`) REFERENCES `personnels` (`idPersonnel`),
  ADD CONSTRAINT `ordreFabrication_programme1_FK` FOREIGN KEY (`idProgramme`) REFERENCES `programme` (`idProgramme`),
  ADD CONSTRAINT `ordreFabrication_recette_FK` FOREIGN KEY (`idRecette`) REFERENCES `recette` (`idRecette`);

--
-- Contraintes pour la table `recette_produit`
--
ALTER TABLE `recette_produit`
  ADD CONSTRAINT `recette_produit_produit0_FK` FOREIGN KEY (`idProduit`) REFERENCES `produit` (`idProduit`),
  ADD CONSTRAINT `recette_produit_recette_FK` FOREIGN KEY (`idRecette`) REFERENCES `recette` (`idRecette`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
