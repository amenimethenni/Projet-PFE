-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.14 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Export de la structure de la base pour gestion_des_achats
CREATE DATABASE IF NOT EXISTS `gestion_des_achats` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `gestion_des_achats`;

-- Export de la structure de la table gestion_des_achats. achat
CREATE TABLE IF NOT EXISTS `achat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_achat` date NOT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `unite_id` int(11) DEFAULT NULL,
  `renouvellement_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_26A984567F2DEE08` (`facture_id`),
  KEY `IDX_26A98456EC4A74AB` (`unite_id`),
  KEY `IDX_26A984562D421B0` (`renouvellement_id`),
  CONSTRAINT `FK_26A984562D421B0` FOREIGN KEY (`renouvellement_id`) REFERENCES `renouvellement` (`id`),
  CONSTRAINT `FK_26A984567F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`),
  CONSTRAINT `FK_26A98456EC4A74AB` FOREIGN KEY (`unite_id`) REFERENCES `unite` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.achat : ~2 rows (environ)
DELETE FROM `achat`;
/*!40000 ALTER TABLE `achat` DISABLE KEYS */;
INSERT INTO `achat` (`id`, `date_achat`, `facture_id`, `unite_id`, `renouvellement_id`) VALUES
	(22, '2017-05-15', NULL, NULL, NULL),
	(23, '2017-05-15', 1, NULL, 1);
/*!40000 ALTER TABLE `achat` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. demande
CREATE TABLE IF NOT EXISTS `demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_demande` date NOT NULL,
  `fichier_bcn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lien_bcn` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numero_bcn` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unite_id` int(11) DEFAULT NULL,
  `unite_demandeuse_id` int(11) DEFAULT NULL,
  `achat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2694D7A5EC4A74AB` (`unite_id`),
  KEY `IDX_2694D7A5C9BD029E` (`unite_demandeuse_id`),
  KEY `IDX_2694D7A5FE95D117` (`achat_id`),
  CONSTRAINT `FK_2694D7A5C9BD029E` FOREIGN KEY (`unite_demandeuse_id`) REFERENCES `unite` (`id`),
  CONSTRAINT `FK_2694D7A5EC4A74AB` FOREIGN KEY (`unite_id`) REFERENCES `unite` (`id`),
  CONSTRAINT `FK_2694D7A5FE95D117` FOREIGN KEY (`achat_id`) REFERENCES `achat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.demande : ~3 rows (environ)
DELETE FROM `demande`;
/*!40000 ALTER TABLE `demande` DISABLE KEYS */;
INSERT INTO `demande` (`id`, `date_demande`, `fichier_bcn`, `lien_bcn`, `numero_bcn`, `unite_id`, `unite_demandeuse_id`, `achat_id`) VALUES
	(6, '2017-05-09', 'cahier des charges - Copie.docx', NULL, '1', 2, 2, 22),
	(7, '2017-05-09', '2014.csv', NULL, '2', 4, 3, 22),
	(8, '2017-05-15', NULL, NULL, '522', 2, 1, NULL);
/*!40000 ALTER TABLE `demande` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. demande_has_etat_demande
CREATE TABLE IF NOT EXISTS `demande_has_etat_demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etat_demande_id` int(11) DEFAULT NULL,
  `demande_id` int(11) DEFAULT NULL,
  `dateEtat` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AA64193529A5620D` (`etat_demande_id`),
  KEY `IDX_AA64193580E95E18` (`demande_id`),
  CONSTRAINT `FK_AA64193529A5620D` FOREIGN KEY (`etat_demande_id`) REFERENCES `etat_demande` (`id`),
  CONSTRAINT `FK_AA64193580E95E18` FOREIGN KEY (`demande_id`) REFERENCES `demande` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.demande_has_etat_demande : ~7 rows (environ)
DELETE FROM `demande_has_etat_demande`;
/*!40000 ALTER TABLE `demande_has_etat_demande` DISABLE KEYS */;
INSERT INTO `demande_has_etat_demande` (`id`, `etat_demande_id`, `demande_id`, `dateEtat`) VALUES
	(8, 1, 6, '2017-05-09 13:55:53'),
	(9, 1, 7, '2017-05-09 13:57:24'),
	(26, 2, 6, '2017-05-10 10:48:19'),
	(49, 6, 6, '2017-05-15 09:43:20'),
	(50, 1, 8, '2017-05-15 15:52:10'),
	(51, 2, 8, '2017-05-15 15:53:55'),
	(52, 6, 8, '2017-05-15 15:55:45');
/*!40000 ALTER TABLE `demande_has_etat_demande` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. devis
CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur_id` int(11) DEFAULT NULL,
  `numero` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateDevis` date NOT NULL,
  `fichierDevis` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `achat_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B27C52B670C757F` (`fournisseur_id`),
  KEY `IDX_8B27C52BFE95D117` (`achat_id`),
  CONSTRAINT `FK_8B27C52B670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur` (`id`),
  CONSTRAINT `FK_8B27C52BFE95D117` FOREIGN KEY (`achat_id`) REFERENCES `achat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.devis : ~6 rows (environ)
DELETE FROM `devis`;
/*!40000 ALTER TABLE `devis` DISABLE KEYS */;
INSERT INTO `devis` (`id`, `fournisseur_id`, `numero`, `dateDevis`, `fichierDevis`, `achat_id`) VALUES
	(64, 1, '1', '2017-05-15', NULL, 22),
	(65, 2, '2', '2017-05-15', NULL, 22),
	(66, 3, '3', '2017-05-15', NULL, 22),
	(67, 1, '55', '2017-05-15', NULL, 23),
	(68, 2, '45', '2017-05-15', NULL, 23),
	(69, 3, '54', '2017-05-15', NULL, 23);
/*!40000 ALTER TABLE `devis` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. etat_demande
CREATE TABLE IF NOT EXISTS `etat_demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.etat_demande : ~5 rows (environ)
DELETE FROM `etat_demande`;
/*!40000 ALTER TABLE `etat_demande` DISABLE KEYS */;
INSERT INTO `etat_demande` (`id`, `libelle`) VALUES
	(1, 'Brouillon'),
	(2, 'Validée'),
	(3, 'Proposé pour renouvellement'),
	(4, 'Renouvelée'),
	(5, 'Refusée'),
	(6, 'Achetée');
/*!40000 ALTER TABLE `etat_demande` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. etat_renouvellement
CREATE TABLE IF NOT EXISTS `etat_renouvellement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.etat_renouvellement : ~1 rows (environ)
DELETE FROM `etat_renouvellement`;
/*!40000 ALTER TABLE `etat_renouvellement` DISABLE KEYS */;
INSERT INTO `etat_renouvellement` (`id`, `libelle`) VALUES
	(1, 'brouillon'),
	(2, 'Validé'),
	(3, 'Validé par le contrôle des dépenses'),
	(4, 'Refusé par le contrôle des dépenses'),
	(5, 'Validé par la trésorerie'),
	(6, 'Refusé par la trésorerie');
/*!40000 ALTER TABLE `etat_renouvellement` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. facture
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fournisseur_id` int(11) DEFAULT NULL,
  `numero` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateFacture` date NOT NULL,
  `fichierFacture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FE866410670C757F` (`fournisseur_id`),
  CONSTRAINT `FK_FE866410670C757F` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.facture : ~1 rows (environ)
DELETE FROM `facture`;
/*!40000 ALTER TABLE `facture` DISABLE KEYS */;
INSERT INTO `facture` (`id`, `fournisseur_id`, `numero`, `dateFacture`, `fichierFacture`) VALUES
	(1, 1, '1', '2017-05-15', '0');
/*!40000 ALTER TABLE `facture` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. fonctionnalite
CREATE TABLE IF NOT EXISTS `fonctionnalite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F83CB48AFC2B591` (`module_id`),
  CONSTRAINT `FK_8F83CB48AFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.fonctionnalite : ~22 rows (environ)
DELETE FROM `fonctionnalite`;
/*!40000 ALTER TABLE `fonctionnalite` DISABLE KEYS */;
INSERT INTO `fonctionnalite` (`id`, `module_id`, `libelle`) VALUES
	(1, 1, 'Ajouter'),
	(2, 1, 'Modifier'),
	(3, 1, 'Activer/Désactiver'),
	(4, 1, 'Lister'),
	(5, 2, 'Lister'),
	(6, 2, 'Ajouter'),
	(7, 2, 'Modifier'),
	(8, 2, 'Supprimer'),
	(9, 4, 'Lister'),
	(10, 4, 'Ajouter'),
	(11, 4, 'Modifier'),
	(12, 4, 'Supprimer'),
	(13, 6, 'Lister'),
	(14, 6, 'Ajouter'),
	(15, 6, 'Modifier'),
	(16, 6, 'Supprimer'),
	(17, 4, 'Valider'),
	(18, 4, 'Refuser'),
	(19, 7, 'Ajouter'),
	(20, 7, 'Lister'),
	(21, 7, 'Modifier'),
	(22, 7, 'Supprimer'),
	(23, 7, 'Valider'),
	(24, 7, 'Refuser'),
	(25, 7, 'Validé par le contrôle des dépenses'),
	(26, 7, 'Refusé par le contrôle des dépenses'),
	(27, 7, 'Validé par la trésorerie'),
	(28, 7, 'Refusé par la trésorerie');
/*!40000 ALTER TABLE `fonctionnalite` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. fos_user
CREATE TABLE IF NOT EXISTS `fos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profil_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `crb_id` int(11) DEFAULT NULL,
  `unite_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_957A647992FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_957A6479A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_957A6479C05FB297` (`confirmation_token`),
  KEY `IDX_957A6479275ED078` (`profil_id`),
  KEY `IDX_957A6479B49F4C52` (`crb_id`),
  KEY `IDX_957A6479EC4A74AB` (`unite_id`),
  CONSTRAINT `FK_957A6479275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`id`),
  CONSTRAINT `FK_957A6479B49F4C52` FOREIGN KEY (`crb_id`) REFERENCES `unite` (`id`),
  CONSTRAINT `FK_957A6479EC4A74AB` FOREIGN KEY (`unite_id`) REFERENCES `unite` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.fos_user : ~3 rows (environ)
DELETE FROM `fos_user`;
/*!40000 ALTER TABLE `fos_user` DISABLE KEYS */;
INSERT INTO `fos_user` (`id`, `profil_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `nom`, `prenom`, `crb_id`, `unite_id`) VALUES
	(1, 3, 'anas', 'anas', 'anassaaid@gmail.com', 'anassaaid@gmail.com', 1, NULL, '$2y$13$cru1uD6tJxUNrhx0FD.V7.YYSAGAXyE4eGHEOEATvFbwOtMjF9BS.', '2017-05-16 10:38:53', NULL, NULL, 'a:0:{}', 'SAAID', 'Anas', 3, 2),
	(2, 1, 'ameni', 'ameni', 'methenniameni6@gmail.com', 'methenniameni6@gmail.com', 1, NULL, '$2y$13$IuNF/JYwPjHNAtbUr7Ujv.nC1XGr7vwIqRChJT6G6ucPEI2.W3cPK', '2017-05-06 06:21:27', NULL, NULL, 'a:0:{}', 'METHENNI', 'Ameni', 3, 1),
	(3, 1, 'rania', 'rania', 'raniahamrouni21@gmail.com', 'raniahamrouni21@gmail.com', 1, NULL, '$2y$13$Hlgru5dOijK3lma82H6CpumuqzUC/xjLdvZD2ZD1As9Mp4lalELfy', '2017-05-16 11:49:17', NULL, NULL, 'a:0:{}', 'HAMROUNI', 'Rania', 4, 4);
/*!40000 ALTER TABLE `fos_user` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. fournisseur
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matriculeFiscal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.fournisseur : ~3 rows (environ)
DELETE FROM `fournisseur`;
/*!40000 ALTER TABLE `fournisseur` DISABLE KEYS */;
INSERT INTO `fournisseur` (`id`, `libelle`, `matriculeFiscal`, `adresse`, `tel`) VALUES
	(1, 'Fournisseur 1', 'matricule 1', 'Adresse 1', 'Tel 1'),
	(2, 'Fournisseur 2', 'matricule 2', 'Adresse 2', 'Tel 2'),
	(3, 'Fournisseur 3', 'mtricule 3', 'Adresse 3', 'Tel 3');
/*!40000 ALTER TABLE `fournisseur` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. ligne_demande
CREATE TABLE IF NOT EXISTS `ligne_demande` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) DEFAULT NULL,
  `demande_id` int(11) DEFAULT NULL,
  `qte` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B90DE99CF347EFB` (`produit_id`),
  KEY `IDX_B90DE99C80E95E18` (`demande_id`),
  CONSTRAINT `FK_B90DE99C80E95E18` FOREIGN KEY (`demande_id`) REFERENCES `demande` (`id`),
  CONSTRAINT `FK_B90DE99CF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.ligne_demande : ~5 rows (environ)
DELETE FROM `ligne_demande`;
/*!40000 ALTER TABLE `ligne_demande` DISABLE KEYS */;
INSERT INTO `ligne_demande` (`id`, `produit_id`, `demande_id`, `qte`) VALUES
	(8, 1, 6, 1),
	(9, 2, 6, 3),
	(10, 2, 7, 1),
	(11, 1, 8, 10),
	(12, 2, 8, 15);
/*!40000 ALTER TABLE `ligne_demande` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. ligne_devis
CREATE TABLE IF NOT EXISTS `ligne_devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) DEFAULT NULL,
  `devis_id` int(11) DEFAULT NULL,
  `qte` double NOT NULL,
  `prix_ht` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remise` double NOT NULL,
  `tauxTva_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_888B2F1BF347EFB` (`produit_id`),
  KEY `IDX_888B2F1B41DEFADA` (`devis_id`),
  KEY `IDX_888B2F1B97100A01` (`tauxTva_id`),
  CONSTRAINT `FK_888B2F1B41DEFADA` FOREIGN KEY (`devis_id`) REFERENCES `devis` (`id`),
  CONSTRAINT `FK_888B2F1B97100A01` FOREIGN KEY (`tauxTva_id`) REFERENCES `taux_tva` (`id`),
  CONSTRAINT `FK_888B2F1BF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.ligne_devis : ~162 rows (environ)
DELETE FROM `ligne_devis`;
/*!40000 ALTER TABLE `ligne_devis` DISABLE KEYS */;
INSERT INTO `ligne_devis` (`id`, `produit_id`, `devis_id`, `qte`, `prix_ht`, `remise`, `tauxTva_id`) VALUES
	(1, NULL, NULL, 15, '100', 5, 1),
	(2, NULL, NULL, 4, '5.254', 0, 2),
	(3, NULL, NULL, 15, '110.251', 0, 1),
	(4, NULL, NULL, 4, '4.254', 0, 2),
	(5, NULL, NULL, 15, '91.254', 0, 1),
	(6, NULL, NULL, 4, '8.255', 0, 2),
	(7, NULL, NULL, 4, '100', 10, 1),
	(8, NULL, NULL, 1, '50', 0, 1),
	(9, NULL, NULL, 10, '50', 0, 2),
	(10, NULL, NULL, 4, '150.25', 0, 1),
	(11, NULL, NULL, 0, '0', 0, 2),
	(12, NULL, NULL, 0, '0', 0, 1),
	(13, NULL, NULL, 4, '92.25', 0, 2),
	(14, NULL, NULL, 1, '5.254', 0, 1),
	(15, NULL, NULL, 10, '500', 0, 1),
	(16, NULL, NULL, 4, '100', 10, 1),
	(17, NULL, NULL, 1, '50', 0, 1),
	(18, NULL, NULL, 10, '50', 0, 2),
	(19, NULL, NULL, 4, '150.25', 0, 1),
	(20, NULL, NULL, 0, '0', 0, 2),
	(21, NULL, NULL, 0, '0', 0, 1),
	(22, NULL, NULL, 4, '92.25', 0, 2),
	(23, NULL, NULL, 1, '5.254', 0, 1),
	(24, NULL, NULL, 10, '500', 0, 1),
	(25, NULL, NULL, 1, '100', 0, 1),
	(26, NULL, NULL, 3, '50', 0, 2),
	(27, NULL, NULL, 1, '101', 0, 1),
	(28, NULL, NULL, 3, '55.254', 0, 2),
	(29, NULL, NULL, 1, '90', 10, 1),
	(30, NULL, NULL, 3, '60', 0, 2),
	(31, NULL, NULL, 1, '100', 0, 1),
	(32, NULL, NULL, 3, '50', 0, 2),
	(33, NULL, NULL, 1, '110', 0, 1),
	(34, NULL, NULL, 3, '55', 0, 2),
	(35, NULL, NULL, 1, '120', 0, 1),
	(36, NULL, NULL, 3, '30', 0, 2),
	(37, NULL, NULL, 1, '100', 0, 1),
	(38, NULL, NULL, 3, '50', 0, 2),
	(39, NULL, NULL, 1, '120', 0, 1),
	(40, NULL, NULL, 3, '52', 0, 2),
	(41, NULL, NULL, 1, '120', 0, 1),
	(42, NULL, NULL, 3, '55', 0, 2),
	(43, NULL, NULL, 1, '100', 0, 1),
	(44, NULL, NULL, 3, '50', 0, 2),
	(45, NULL, NULL, 1, '120', 0, 1),
	(46, NULL, NULL, 3, '52', 0, 2),
	(47, NULL, NULL, 1, '120', 0, 1),
	(48, NULL, NULL, 3, '55', 0, 2),
	(49, NULL, NULL, 1, '100', 0, 1),
	(50, NULL, NULL, 3, '50', 0, 2),
	(51, NULL, NULL, 1, '120', 0, 1),
	(52, NULL, NULL, 3, '52', 0, 2),
	(53, NULL, NULL, 1, '120', 0, 1),
	(54, NULL, NULL, 3, '55', 0, 2),
	(55, NULL, NULL, 1, '100', 0, 1),
	(56, NULL, NULL, 3, '50', 0, 2),
	(57, NULL, NULL, 1, '120', 0, 1),
	(58, NULL, NULL, 3, '52', 0, 2),
	(59, NULL, NULL, 1, '120', 0, 1),
	(60, NULL, NULL, 3, '55', 0, 2),
	(61, NULL, NULL, 1, '100', 0, 1),
	(62, NULL, NULL, 3, '50', 0, 2),
	(63, NULL, NULL, 1, '120', 0, 1),
	(64, NULL, NULL, 3, '52', 0, 2),
	(65, NULL, NULL, 1, '120', 0, 1),
	(66, NULL, NULL, 3, '55', 0, 2),
	(67, NULL, NULL, 1, '100', 0, 1),
	(68, NULL, NULL, 3, '50', 0, 2),
	(69, NULL, NULL, 1, '120', 0, 1),
	(70, NULL, NULL, 3, '52', 0, 2),
	(71, NULL, NULL, 1, '120', 0, 1),
	(72, NULL, NULL, 3, '55', 0, 2),
	(73, NULL, NULL, 1, '100', 0, 1),
	(74, NULL, NULL, 3, '50', 0, 2),
	(75, NULL, NULL, 1, '120', 0, 1),
	(76, NULL, NULL, 3, '52', 0, 2),
	(77, NULL, NULL, 1, '120', 0, 1),
	(78, NULL, NULL, 3, '55', 0, 2),
	(79, NULL, NULL, 1, '100', 0, 1),
	(80, NULL, NULL, 3, '50', 0, 2),
	(81, NULL, NULL, 1, '120', 0, 1),
	(82, NULL, NULL, 3, '52', 0, 2),
	(83, NULL, NULL, 1, '120', 0, 1),
	(84, NULL, NULL, 3, '55', 0, 2),
	(85, NULL, NULL, 1, '100', 0, 1),
	(86, NULL, NULL, 3, '50', 0, 2),
	(87, NULL, NULL, 1, '120', 0, 1),
	(88, NULL, NULL, 3, '52', 0, 2),
	(89, NULL, NULL, 1, '120', 0, 1),
	(90, NULL, NULL, 3, '55', 0, 2),
	(91, NULL, NULL, 1, '100', 0, 1),
	(92, NULL, NULL, 3, '50', 0, 2),
	(93, NULL, NULL, 1, '120', 0, 1),
	(94, NULL, NULL, 3, '52', 0, 2),
	(95, NULL, NULL, 1, '120', 0, 1),
	(96, NULL, NULL, 3, '55', 0, 2),
	(97, NULL, NULL, 1, '100', 0, 1),
	(98, NULL, NULL, 3, '50', 0, 2),
	(99, NULL, NULL, 1, '120', 0, 1),
	(100, NULL, NULL, 3, '52', 0, 2),
	(101, NULL, NULL, 1, '120', 0, 1),
	(102, NULL, NULL, 3, '55', 0, 2),
	(103, NULL, NULL, 1, '100', 0, 1),
	(104, NULL, NULL, 3, '50', 0, 2),
	(105, NULL, NULL, 1, '120', 0, 1),
	(106, NULL, NULL, 3, '52', 0, 2),
	(107, NULL, NULL, 1, '120', 0, 1),
	(108, NULL, NULL, 3, '55', 0, 2),
	(109, NULL, NULL, 1, '100', 0, 1),
	(110, NULL, NULL, 3, '50', 0, 2),
	(111, NULL, NULL, 1, '120', 0, 1),
	(112, NULL, NULL, 3, '52', 0, 2),
	(113, NULL, NULL, 1, '120', 0, 1),
	(114, NULL, NULL, 3, '55', 0, 2),
	(115, NULL, NULL, 1, '100', 0, 1),
	(116, NULL, NULL, 3, '100', 0, 2),
	(117, NULL, NULL, 1, '90', 0, 1),
	(118, NULL, NULL, 3, '90', 0, 2),
	(119, NULL, NULL, 1, '80', 0, 1),
	(120, NULL, NULL, 3, '80', 0, 2),
	(121, NULL, NULL, 1, '100', 0, 1),
	(122, NULL, NULL, 3, '100', 0, 2),
	(123, NULL, NULL, 1, '90', 0, 1),
	(124, NULL, NULL, 3, '90', 0, 2),
	(125, NULL, NULL, 1, '80', 0, 1),
	(126, NULL, NULL, 3, '80', 0, 2),
	(127, NULL, NULL, 1, '100', 0, 1),
	(128, NULL, NULL, 3, '100', 0, 2),
	(129, NULL, NULL, 1, '90', 0, 1),
	(130, NULL, NULL, 3, '90', 0, 2),
	(131, NULL, NULL, 1, '80', 0, 1),
	(132, NULL, NULL, 3, '80', 0, 2),
	(133, NULL, NULL, 1, '100', 0, 1),
	(134, NULL, NULL, 3, '100', 0, 2),
	(135, NULL, NULL, 1, '90', 0, 1),
	(136, NULL, NULL, 3, '90', 0, 2),
	(137, NULL, NULL, 1, '80', 0, 1),
	(138, NULL, NULL, 3, '80', 0, 2),
	(139, NULL, NULL, 1, '100', 0, 1),
	(140, NULL, NULL, 3, '100', 0, 2),
	(141, NULL, NULL, 1, '90', 0, 1),
	(142, NULL, NULL, 3, '90', 0, 2),
	(143, NULL, NULL, 1, '80', 0, 1),
	(144, NULL, NULL, 3, '80', 0, 2),
	(145, NULL, NULL, 1, '100', 0, 1),
	(146, NULL, NULL, 3, '100', 0, 2),
	(147, NULL, NULL, 1, '90', 0, 1),
	(148, NULL, NULL, 3, '90', 0, 2),
	(149, NULL, NULL, 1, '80', 0, 1),
	(150, NULL, NULL, 3, '80', 0, 2),
	(151, NULL, NULL, 1, '100', 0, 1),
	(152, NULL, NULL, 3, '100', 0, 2),
	(153, NULL, NULL, 1, '90', 0, 1),
	(154, NULL, NULL, 3, '90', 0, 2),
	(155, NULL, NULL, 1, '80', 0, 1),
	(156, NULL, NULL, 3, '80', 0, 2),
	(157, NULL, NULL, 10, '100', 0, 1),
	(158, NULL, NULL, 15, '100', 0, 2),
	(159, NULL, NULL, 10, '90', 0, 1),
	(160, NULL, NULL, 15, '90', 0, 2),
	(161, NULL, NULL, 10, '80', 0, 1),
	(162, NULL, NULL, 15, '90', 0, 2);
/*!40000 ALTER TABLE `ligne_devis` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. ligne_facture
CREATE TABLE IF NOT EXISTS `ligne_facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produit_id` int(11) DEFAULT NULL,
  `facture_id` int(11) DEFAULT NULL,
  `qte` double NOT NULL,
  `prix_ht` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taux_tva` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remise` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_611F5A29F347EFB` (`produit_id`),
  KEY `IDX_611F5A297F2DEE08` (`facture_id`),
  CONSTRAINT `FK_611F5A297F2DEE08` FOREIGN KEY (`facture_id`) REFERENCES `facture` (`id`),
  CONSTRAINT `FK_611F5A29F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.ligne_facture : ~1 rows (environ)
DELETE FROM `ligne_facture`;
/*!40000 ALTER TABLE `ligne_facture` DISABLE KEYS */;
INSERT INTO `ligne_facture` (`id`, `produit_id`, `facture_id`, `qte`, `prix_ht`, `taux_tva`, `remise`) VALUES
	(1, 1, 1, 10, '80', '6', 0);
/*!40000 ALTER TABLE `ligne_facture` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.module : ~5 rows (environ)
DELETE FROM `module`;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` (`id`, `libelle`) VALUES
	(1, 'Gestion des utilisateurs'),
	(2, 'Gestion des profiles'),
	(3, 'Paramètrage'),
	(4, 'Demandes'),
	(6, 'Achats'),
	(7, 'Renouvellement');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. produit
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.produit : ~2 rows (environ)
DELETE FROM `produit`;
/*!40000 ALTER TABLE `produit` DISABLE KEYS */;
INSERT INTO `produit` (`id`, `libelle`, `description`) VALUES
	(1, 'produit1', 'desc'),
	(2, 'produit2', 'descc'),
	(3, 'produit 3', 'description d produit 3');
/*!40000 ALTER TABLE `produit` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. profil
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.profil : ~2 rows (environ)
DELETE FROM `profil`;
/*!40000 ALTER TABLE `profil` DISABLE KEYS */;
INSERT INTO `profil` (`id`, `libelle`) VALUES
	(1, 'Administrateur'),
	(2, 'CRB'),
	(3, 'Responsable CRB'),
	(4, 'Contrôle des dépenses'),
	(5, 'Trésorerie');
/*!40000 ALTER TABLE `profil` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. profil_fonctionnalite
CREATE TABLE IF NOT EXISTS `profil_fonctionnalite` (
  `profil_id` int(11) NOT NULL,
  `fonctionnalite_id` int(11) NOT NULL,
  PRIMARY KEY (`profil_id`,`fonctionnalite_id`),
  KEY `IDX_A578F261275ED078` (`profil_id`),
  KEY `IDX_A578F2614477C5D8` (`fonctionnalite_id`),
  CONSTRAINT `FK_A578F261275ED078` FOREIGN KEY (`profil_id`) REFERENCES `profil` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A578F2614477C5D8` FOREIGN KEY (`fonctionnalite_id`) REFERENCES `fonctionnalite` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.profil_fonctionnalite : ~38 rows (environ)
DELETE FROM `profil_fonctionnalite`;
/*!40000 ALTER TABLE `profil_fonctionnalite` DISABLE KEYS */;
INSERT INTO `profil_fonctionnalite` (`profil_id`, `fonctionnalite_id`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(1, 4),
	(1, 5),
	(1, 6),
	(1, 7),
	(1, 8),
	(1, 9),
	(1, 10),
	(1, 11),
	(1, 12),
	(1, 13),
	(1, 14),
	(1, 15),
	(1, 16),
	(2, 9),
	(2, 10),
	(2, 11),
	(2, 12),
	(2, 13),
	(2, 14),
	(2, 15),
	(2, 16),
	(3, 9),
	(3, 10),
	(3, 11),
	(3, 12),
	(3, 13),
	(3, 14),
	(3, 15),
	(3, 16),
	(3, 17),
	(3, 18),
	(3, 19),
	(3, 20),
	(3, 21),
	(3, 22),
	(3, 23),
	(3, 24),
	(4, 20),
	(4, 25),
	(4, 26),
	(5, 20),
	(5, 27),
	(5, 28);
/*!40000 ALTER TABLE `profil_fonctionnalite` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. renouvellement
CREATE TABLE IF NOT EXISTS `renouvellement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` decimal(10,0) DEFAULT NULL,
  `date_renouvellement` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.renouvellement : ~1 rows (environ)
DELETE FROM `renouvellement`;
/*!40000 ALTER TABLE `renouvellement` DISABLE KEYS */;
INSERT INTO `renouvellement` (`id`, `numero`, `date_renouvellement`) VALUES
	(1, NULL, '2017-05-15');
/*!40000 ALTER TABLE `renouvellement` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. renouvellement_has_etat_renouvellement
CREATE TABLE IF NOT EXISTS `renouvellement_has_etat_renouvellement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `etat_renouvellement_id` int(11) DEFAULT NULL,
  `renouvellement_id` int(11) DEFAULT NULL,
  `dateEtat` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3858BE53E9EAB6C8` (`etat_renouvellement_id`),
  KEY `IDX_3858BE532D421B0` (`renouvellement_id`),
  CONSTRAINT `FK_3858BE532D421B0` FOREIGN KEY (`renouvellement_id`) REFERENCES `renouvellement` (`id`),
  CONSTRAINT `FK_3858BE53E9EAB6C8` FOREIGN KEY (`etat_renouvellement_id`) REFERENCES `etat_renouvellement` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.renouvellement_has_etat_renouvellement : ~0 rows (environ)
DELETE FROM `renouvellement_has_etat_renouvellement`;
/*!40000 ALTER TABLE `renouvellement_has_etat_renouvellement` DISABLE KEYS */;
INSERT INTO `renouvellement_has_etat_renouvellement` (`id`, `etat_renouvellement_id`, `renouvellement_id`, `dateEtat`) VALUES
	(1, 1, 1, '2017-05-16 12:28:14');
/*!40000 ALTER TABLE `renouvellement_has_etat_renouvellement` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. taux_tva
CREATE TABLE IF NOT EXISTS `taux_tva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taux` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.taux_tva : ~2 rows (environ)
DELETE FROM `taux_tva`;
/*!40000 ALTER TABLE `taux_tva` DISABLE KEYS */;
INSERT INTO `taux_tva` (`id`, `taux`) VALUES
	(1, 6),
	(2, 12),
	(3, 18);
/*!40000 ALTER TABLE `taux_tva` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. unite
CREATE TABLE IF NOT EXISTS `unite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.unite : ~4 rows (environ)
DELETE FROM `unite`;
/*!40000 ALTER TABLE `unite` DISABLE KEYS */;
INSERT INTO `unite` (`id`, `libelle`, `parent`) VALUES
	(1, 'Service sécurité et réseaux informatiques', 3),
	(2, 'Service maintenance du materiel informatique', 3),
	(3, 'Direction informatique', NULL),
	(4, 'Direction du district de Ben Arous', NULL),
	(5, 'Direction du district de Zahrouni', NULL);
/*!40000 ALTER TABLE `unite` ENABLE KEYS */;

-- Export de la structure de la table gestion_des_achats. uniterattache
CREATE TABLE IF NOT EXISTS `uniterattache` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unite_id` int(11) DEFAULT NULL,
  `libelle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_ADA136B4EC4A74AB` (`unite_id`),
  CONSTRAINT `FK_ADA136B4EC4A74AB` FOREIGN KEY (`unite_id`) REFERENCES `unite` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Export de données de la table gestion_des_achats.uniterattache : ~0 rows (environ)
DELETE FROM `uniterattache`;
/*!40000 ALTER TABLE `uniterattache` DISABLE KEYS */;
/*!40000 ALTER TABLE `uniterattache` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
