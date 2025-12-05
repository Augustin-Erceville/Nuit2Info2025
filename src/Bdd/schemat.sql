-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 04 déc. 2025 à 22:06
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nird_village`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
                                              `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du commentaire',
                                              `ressource_id` int UNSIGNED NOT NULL COMMENT 'Référence vers la ressource commentée',
                                              `auteur_id` int UNSIGNED DEFAULT NULL COMMENT 'Référence vers l’utilisateur auteur du commentaire',
                                              `contenu` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Texte du commentaire saisi par l’utilisateur',
                                              `parent_id` int UNSIGNED DEFAULT NULL,
                                              `date_commentaire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de publication du commentaire',
                                              PRIMARY KEY (`id`),
    KEY `idx_comment_ressource` (`ressource_id`),
    KEY `idx_comment_auteur` (`auteur_id`),
    KEY `fk_comment_parent` (`parent_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Commentaires associés aux ressources internes';

-- --------------------------------------------------------

--
-- Structure de la table `defis`
--

DROP TABLE IF EXISTS `defis`;
CREATE TABLE IF NOT EXISTS `defis` (
                                       `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du défi',
                                       `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Titre court du défi',
    `description` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Description détaillée du défi ou de la mission',
    `difficulte` enum('facile','moyen','difficile') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'facile' COMMENT 'Niveau de difficulté du défi',
    `points` int NOT NULL DEFAULT '10' COMMENT 'Nombre de points attribués en cas de réussite',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Défis et missions gamifiées autour du numérique responsable';

-- --------------------------------------------------------

--
-- Structure de la table `defis_utilisateurs`
--

DROP TABLE IF EXISTS `defis_utilisateurs`;
CREATE TABLE IF NOT EXISTS `defis_utilisateurs` (
                                                    `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du suivi de défi',
                                                    `defi_id` int UNSIGNED NOT NULL COMMENT 'Référence vers le défi concerné',
                                                    `user_id` int UNSIGNED NOT NULL COMMENT 'Référence vers l’utilisateur participant',
                                                    `statut` enum('en_cours','reussi','echoue') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'en_cours' COMMENT 'Statut actuel du défi pour cet utilisateur',
    `date_statut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de la dernière mise à jour du statut',
    PRIMARY KEY (`id`),
    KEY `idx_defi_user_defi` (`defi_id`),
    KEY `idx_defi_user_user` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Participation des utilisateurs aux différents défis';

-- --------------------------------------------------------

--
-- Structure de la table `etablissements`
--

DROP TABLE IF EXISTS `etablissements`;
CREATE TABLE IF NOT EXISTS `etablissements` (
                                                `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l’établissement',
                                                `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Nom officiel de l’établissement',
    `adresse` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Adresse postale de l’établissement',
    `ville` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Ville où se situe l’établissement',
    `code_postal` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Code postal de l’établissement',
    `region` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Région administrative de l’établissement',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Établissements partenaires de la démarche NIRD';

-- --------------------------------------------------------

--
-- Structure de la table `idees`
--

DROP TABLE IF EXISTS `idees`;
CREATE TABLE IF NOT EXISTS `idees` (
                                       `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l’idée',
                                       `user_id` int UNSIGNED DEFAULT NULL COMMENT 'Référence vers l’utilisateur ayant proposé l’idée',
                                       `etablissement_id` int UNSIGNED DEFAULT NULL COMMENT 'Établissement principalement concerné par l’idée',
                                       `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Titre court décrivant l’idée',
    `description` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Description détaillée de l’idée ou de l’action proposée',
    `categorie_action` enum('sobriete_numerique','logiciels_libres','reemploi_reconditionnement','linux','communs_numeriques','organisation','sensibilisation','autre') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'autre' COMMENT 'Catégorie principale de l’idée en lien avec la démarche NIRD',
    `statut` enum('proposee','validee','refusee','archivee') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'proposee' COMMENT 'Statut de validation ou de suivi de l’idée',
    `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de création de l’idée',
    `date_mise_a_jour` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Dernière date de modification de l’idée',
    PRIMARY KEY (`id`),
    KEY `idx_idees_user` (`user_id`),
    KEY `idx_idees_etab` (`etablissement_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Idées et actions proposées pour un numérique inclusif, responsable et durable';

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
                                          `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du matériel',
                                          `etablissement_id` int UNSIGNED NOT NULL COMMENT 'Référence vers l’établissement propriétaire du matériel',
                                          `type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Type de matériel : ordinateur, tablette, serveur, etc.',
    `marque` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Marque commerciale du matériel',
    `modele` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Modèle ou référence du matériel',
    `etat` enum('fonctionnel','a_reparer','hors_service') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'fonctionnel' COMMENT 'État actuel du matériel',
    `date_ajout` date NOT NULL COMMENT 'Date d’ajout du matériel dans l’inventaire',
    PRIMARY KEY (`id`),
    KEY `idx_materiel_etab` (`etablissement_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Matériel informatique suivi dans la démarche NIRD';

-- --------------------------------------------------------

--
-- Structure de la table `parcours_choix`
--

DROP TABLE IF EXISTS `parcours_choix`;
CREATE TABLE IF NOT EXISTS `parcours_choix` (
                                                `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du choix de parcours',
                                                `etape_id` int UNSIGNED NOT NULL COMMENT 'Référence vers l’étape à laquelle appartient ce choix',
                                                `libelle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Texte du choix affiché à l’utilisateur',
    `impact_dependance` tinyint NOT NULL DEFAULT '0' COMMENT 'Impact sur la dépendance aux Big Tech (valeur négative = réduction)',
    `impact_ecologie` tinyint NOT NULL DEFAULT '0' COMMENT 'Impact sur l’empreinte écologique / sobriété',
    `impact_inclusion` tinyint NOT NULL DEFAULT '0' COMMENT 'Impact sur l’inclusion et l’accessibilité',
    `message_resultat` text COLLATE utf8mb4_general_ci COMMENT 'Texte de feedback affiché après ce choix',
    `etape_suivante_id` int UNSIGNED DEFAULT NULL COMMENT 'Éventuelle étape vers laquelle rediriger après ce choix',
    PRIMARY KEY (`id`),
    KEY `idx_parcours_choix_etape` (`etape_id`),
    KEY `idx_parcours_choix_etape_suiv` (`etape_suivante_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Choix interactifs du parcours avec impacts sur les indicateurs NIRD';

-- --------------------------------------------------------

--
-- Structure de la table `parcours_etapes`
--

DROP TABLE IF EXISTS `parcours_etapes`;
CREATE TABLE IF NOT EXISTS `parcours_etapes` (
                                                 `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l’étape du parcours',
                                                 `slug` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Code court unique utilisé pour identifier l’étape',
    `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Titre affiché de l’étape',
    `contenu` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Texte ou narration de l’étape',
    `type_public` enum('eleve','enseignant','famille','direction','technicien','tous') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tous' COMMENT 'Public principalement visé par cette étape',
    `type_etape` enum('information','choix','resultat') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'information' COMMENT 'Type d’étape : information, choix à faire ou résultat final',
    `ordre_affichage` int NOT NULL DEFAULT '0' COMMENT 'Ordre par défaut de l’étape dans le parcours',
    `illustration` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Chemin ou URL vers une illustration libre de droit',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uniq_parcours_slug` (`slug`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Étapes du parcours interactif du village numérique résistant';

-- --------------------------------------------------------

--
-- Structure de la table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
                                      `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du quiz',
                                      `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Titre du quiz',
    `description` text COLLATE utf8mb4_general_ci COMMENT 'Description courte du quiz',
    `public_cible` enum('eleve','enseignant','famille','direction','technicien','tous') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tous' COMMENT 'Public principalement visé par le quiz',
    `niveau` enum('debutant','intermediaire','avance') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'debutant' COMMENT 'Niveau global de difficulté du quiz',
    `auteur_id` int UNSIGNED DEFAULT NULL COMMENT 'Référence vers l’utilisateur créateur du quiz',
    `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de création du quiz',
    `date_mise_a_jour` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Dernière date de modification du quiz',
    PRIMARY KEY (`id`),
    KEY `idx_quiz_auteur` (`auteur_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Quiz pédagogiques sur le numérique inclusif, responsable et durable';

-- --------------------------------------------------------

--
-- Structure de la table `quiz_questions`
--

DROP TABLE IF EXISTS `quiz_questions`;
CREATE TABLE IF NOT EXISTS `quiz_questions` (
                                                `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la question',
                                                `quiz_id` int UNSIGNED NOT NULL COMMENT 'Référence vers le quiz auquel appartient la question',
                                                `intitule` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Texte complet de la question posée',
                                                `niveau` enum('debutant','intermediaire','avance') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'debutant' COMMENT 'Niveau de difficulté pédagogique de la question',
    `theme` enum('sobriete_numerique','logiciels_libres','reemploi_reconditionnement','linux','communs_numeriques','culture_generale','autre') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'autre' COMMENT 'Thème principal abordé par la question',
    `type_public` enum('eleve','enseignant','famille','direction','technicien','tous') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tous' COMMENT 'Public principalement visé par la question',
    `explication` text COLLATE utf8mb4_general_ci COMMENT 'Explication affichée après la réponse pour approfondir la notion',
    PRIMARY KEY (`id`),
    KEY `idx_quiz_question_quiz` (`quiz_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Questions de quiz sur le numérique inclusif, responsable et durable';

-- --------------------------------------------------------

--
-- Structure de la table `quiz_reponses`
--

DROP TABLE IF EXISTS `quiz_reponses`;
CREATE TABLE IF NOT EXISTS `quiz_reponses` (
                                               `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la réponse',
                                               `question_id` int UNSIGNED NOT NULL COMMENT 'Référence vers la question associée',
                                               `intitule` text COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Texte de la réponse proposée',
                                               `est_correcte` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indique si la réponse est correcte (1) ou non (0)',
    `retroaction` text COLLATE utf8mb4_general_ci COMMENT 'Message de retour spécifique pour cette réponse',
    PRIMARY KEY (`id`),
    KEY `idx_quiz_rep_question` (`question_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Réponses associées aux questions des quiz NIRD';

-- --------------------------------------------------------

--
-- Structure de la table `reconditionnement`
--

DROP TABLE IF EXISTS `reconditionnement`;
CREATE TABLE IF NOT EXISTS `reconditionnement` (
                                                   `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l’action de reconditionnement',
                                                   `materiel_id` int UNSIGNED NOT NULL COMMENT 'Référence vers le matériel concerné',
                                                   `utilisateur_id` int UNSIGNED DEFAULT NULL COMMENT 'Référence vers l’utilisateur ayant réalisé l’action',
                                                   `action` enum('diagnostic','reparation','installation_linux','mise_a_jour') COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Type d’action réalisée sur le matériel',
    `description` text COLLATE utf8mb4_general_ci COMMENT 'Détails complémentaires sur l’action effectuée',
    `date_action` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de l’action de reconditionnement',
    PRIMARY KEY (`id`),
    KEY `idx_recond_materiel` (`materiel_id`),
    KEY `idx_recond_user` (`utilisateur_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Historique des actions de reconditionnement et de migration';

-- --------------------------------------------------------

--
-- Structure de la table `ressources_contenu`
--

DROP TABLE IF EXISTS `ressources_contenu`;
CREATE TABLE IF NOT EXISTS `ressources_contenu` (
                                                    `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la ressource interne',
                                                    `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Titre de l’article ou de la ressource',
    `contenu` longtext COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Contenu texte ou HTML de la ressource',
    `auteur_id` int UNSIGNED DEFAULT NULL COMMENT 'Référence vers l’utilisateur auteur de la ressource',
    `date_publication` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de publication de la ressource',
    `categorie` enum('sobriete','libre','reemploi','tutoriel','autre') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'autre' COMMENT 'Catégorie principale de la ressource',
    PRIMARY KEY (`id`),
    KEY `idx_ressource_auteur` (`auteur_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ressources pédagogiques internes (articles, tutoriels, fiches)';

-- --------------------------------------------------------

--
-- Structure de la table `ressources_externes`
--

DROP TABLE IF EXISTS `ressources_externes`;
CREATE TABLE IF NOT EXISTS `ressources_externes` (
                                                     `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la ressource externe',
                                                     `titre` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Titre de la ressource ou du lien externe',
    `url` varchar(500) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'URL complète de la ressource externe',
    `type_ressource` enum('site_officiel','article','video','podcast','fiche','outil','autre') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'autre' COMMENT 'Type principal de la ressource externe',
    `source` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'Nom du média, de l’organisation ou de l’auteur',
    `public_cible` enum('eleve','enseignant','famille','direction','technicien','tous') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'tous' COMMENT 'Public principalement visé par cette ressource',
    `description` text COLLATE utf8mb4_general_ci COMMENT 'Résumé ou explication de l’intérêt de la ressource',
    `ordre_affichage` int NOT NULL DEFAULT '0' COMMENT 'Ordre de tri pour l’affichage de la ressource',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ressources externes et liens autour du numérique inclusif, responsable et durable';

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
                                       `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l’utilisateur',
                                       `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Nom de famille de l’utilisateur',
    `prenom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Prénom de l’utilisateur',
    `email` varchar(150) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Adresse e-mail utilisée comme identifiant de connexion',
    `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Mot de passe chiffré de l’utilisateur',
    `date_naissance` date NOT NULL,
    `téléphone` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
    `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
    `role` enum('eleve','enseignant','technicien','collectivite','admin') COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Rôle principal de l’utilisateur dans la plateforme',
    `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure de création du compte',
    PRIMARY KEY (`id`),
    UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Comptes utilisateurs de la plateforme NIRD';

-- --------------------------------------------------------

--
-- Structure de la table `user_etablissement`
--

DROP TABLE IF EXISTS `user_etablissement`;
CREATE TABLE IF NOT EXISTS `user_etablissement` (
                                                    `id` int UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du lien utilisateur-établissement',
                                                    `user_id` int UNSIGNED NOT NULL COMMENT 'Référence vers l’utilisateur concerné',
                                                    `etablissement_id` int UNSIGNED NOT NULL COMMENT 'Référence vers l’établissement concerné',
                                                    PRIMARY KEY (`id`),
    KEY `idx_user_etab_user` (`user_id`),
    KEY `idx_user_etab_etab` (`etablissement_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Affectations des utilisateurs à un ou plusieurs établissements';

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
    ADD CONSTRAINT `fk_comment_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comment_parent` FOREIGN KEY (`parent_id`) REFERENCES `commentaires` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_comment_ressource` FOREIGN KEY (`ressource_id`) REFERENCES `ressources_contenu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `defis_utilisateurs`
--
ALTER TABLE `defis_utilisateurs`
    ADD CONSTRAINT `fk_defi_user_defi` FOREIGN KEY (`defi_id`) REFERENCES `defis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_defi_user_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `idees`
--
ALTER TABLE `idees`
    ADD CONSTRAINT `fk_idees_etab` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idees_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `materiel`
--
ALTER TABLE `materiel`
    ADD CONSTRAINT `fk_materiel_etab` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `parcours_choix`
--
ALTER TABLE `parcours_choix`
    ADD CONSTRAINT `fk_parcours_choix_etape` FOREIGN KEY (`etape_id`) REFERENCES `parcours_etapes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_parcours_choix_etape_suiv` FOREIGN KEY (`etape_suivante_id`) REFERENCES `parcours_etapes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `quiz`
--
ALTER TABLE `quiz`
    ADD CONSTRAINT `fk_quiz_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `quiz_questions`
--
ALTER TABLE `quiz_questions`
    ADD CONSTRAINT `fk_quiz_question_quiz` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `quiz_reponses`
--
ALTER TABLE `quiz_reponses`
    ADD CONSTRAINT `fk_quiz_rep_question` FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reconditionnement`
--
ALTER TABLE `reconditionnement`
    ADD CONSTRAINT `fk_recond_materiel` FOREIGN KEY (`materiel_id`) REFERENCES `materiel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recond_user` FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `ressources_contenu`
--
ALTER TABLE `ressources_contenu`
    ADD CONSTRAINT `fk_ressource_auteur` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `user_etablissement`
--
ALTER TABLE `user_etablissement`
    ADD CONSTRAINT `fk_user_etab_etab` FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_etab_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
