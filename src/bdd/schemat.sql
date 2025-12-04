-- ======================================================================
-- BASE DE DONNÉES NIRD VILLAGE
-- Moteur : InnoDB
-- Interclassement : utf8mb4_general_ci
-- ======================================================================

CREATE DATABASE IF NOT EXISTS `nird_village`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `nird_village`;


-- ======================================================================
-- TABLE : users
-- Comptes utilisateurs de la plateforme
-- ======================================================================
CREATE TABLE `users` (
                         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de l’utilisateur',
                         `nom` VARCHAR(100) NOT NULL
                             COMMENT 'Nom de famille de l’utilisateur',
                         `prenom` VARCHAR(100) NOT NULL
                             COMMENT 'Prénom de l’utilisateur',
                         `email` VARCHAR(150) NOT NULL UNIQUE
                             COMMENT 'Adresse e-mail utilisée comme identifiant de connexion',
                         `mot_de_passe` VARCHAR(255) NOT NULL
                             COMMENT 'Mot de passe chiffré de l’utilisateur',
                         `role` ENUM('eleve','enseignant','technicien','collectivite','admin') NOT NULL
    COMMENT 'Rôle principal de l’utilisateur dans la plateforme',
                         `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                             COMMENT 'Date et heure de création du compte',
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Comptes utilisateurs de la plateforme NIRD';


-- ======================================================================
-- TABLE : etablissements
-- Établissements scolaires et structures associées
-- ======================================================================
CREATE TABLE `etablissements` (
                                  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de l’établissement',
                                  `nom` VARCHAR(255) NOT NULL
                                      COMMENT 'Nom officiel de l’établissement',
                                  `adresse` VARCHAR(255) NULL
    COMMENT 'Adresse postale de l’établissement',
                                  `ville` VARCHAR(100) NULL
    COMMENT 'Ville où se situe l’établissement',
                                  `code_postal` VARCHAR(10) NULL
    COMMENT 'Code postal de l’établissement',
                                  `region` VARCHAR(100) NULL
    COMMENT 'Région administrative de l’établissement',
                                  PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Établissements partenaires de la démarche NIRD';


-- ======================================================================
-- TABLE : user_etablissement
-- Lien n-n entre utilisateurs et établissements
-- ======================================================================
CREATE TABLE `user_etablissement` (
                                      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du lien utilisateur-établissement',
                                      `user_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers l’utilisateur concerné',
                                      `etablissement_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers l’établissement concerné',
                                      PRIMARY KEY (`id`),
                                      KEY `idx_user_etab_user` (`user_id`),
                                      KEY `idx_user_etab_etab` (`etablissement_id`),
                                      CONSTRAINT `fk_user_etab_user`
                                          FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                                              ON DELETE CASCADE ON UPDATE CASCADE,
                                      CONSTRAINT `fk_user_etab_etab`
                                          FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`)
                                              ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Affectations des utilisateurs à un ou plusieurs établissements';


-- ======================================================================
-- TABLE : materiel
-- Parc informatique des établissements
-- ======================================================================
CREATE TABLE `materiel` (
                            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du matériel',
                            `etablissement_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers l’établissement propriétaire du matériel',
                            `type` VARCHAR(100) NOT NULL
                                COMMENT 'Type de matériel : ordinateur, tablette, serveur, etc.',
                            `marque` VARCHAR(100) NULL
    COMMENT 'Marque commerciale du matériel',
                            `modele` VARCHAR(100) NULL
    COMMENT 'Modèle ou référence du matériel',
                            `etat` ENUM('fonctionnel','a_reparer','hors_service') NOT NULL DEFAULT 'fonctionnel'
    COMMENT 'État actuel du matériel',
                            `date_ajout` DATE NOT NULL
                                COMMENT 'Date d’ajout du matériel dans l’inventaire',
                            PRIMARY KEY (`id`),
                            KEY `idx_materiel_etab` (`etablissement_id`),
                            CONSTRAINT `fk_materiel_etab`
                                FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`)
                                    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Matériel informatique suivi dans la démarche NIRD';


-- ======================================================================
-- TABLE : reconditionnement
-- Actions de diagnostic, réparation et migration vers Linux
-- ======================================================================
CREATE TABLE `reconditionnement` (
                                     `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de l’action de reconditionnement',
                                     `materiel_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers le matériel concerné',
                                     `utilisateur_id` INT UNSIGNED NULL
    COMMENT 'Référence vers l’utilisateur ayant réalisé l’action',
                                     `action` ENUM('diagnostic','reparation','installation_linux','mise_a_jour') NOT NULL
    COMMENT 'Type d’action réalisée sur le matériel',
                                     `description` TEXT NULL
    COMMENT 'Détails complémentaires sur l’action effectuée',
                                     `date_action` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                         COMMENT 'Date et heure de l’action de reconditionnement',
                                     PRIMARY KEY (`id`),
                                     KEY `idx_recond_materiel` (`materiel_id`),
                                     KEY `idx_recond_user` (`utilisateur_id`),
                                     CONSTRAINT `fk_recond_materiel`
                                         FOREIGN KEY (`materiel_id`) REFERENCES `materiel` (`id`)
                                             ON DELETE CASCADE ON UPDATE CASCADE,
                                     CONSTRAINT `fk_recond_user`
                                         FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`)
                                             ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Historique des actions de reconditionnement et de migration';


-- ======================================================================
-- TABLE : ressources_contenu
-- Articles, fiches et tutoriels internes à la plateforme
-- ======================================================================
CREATE TABLE `ressources_contenu` (
                                      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de la ressource interne',
                                      `titre` VARCHAR(255) NOT NULL
                                          COMMENT 'Titre de l’article ou de la ressource',
                                      `contenu` LONGTEXT NOT NULL
                                          COMMENT 'Contenu texte ou HTML de la ressource',
                                      `auteur_id` INT UNSIGNED NULL
    COMMENT 'Référence vers l’utilisateur auteur de la ressource',
                                      `date_publication` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                          COMMENT 'Date et heure de publication de la ressource',
                                      `categorie` ENUM('sobriete','libre','reemploi','tutoriel','autre') NOT NULL DEFAULT 'autre'
    COMMENT 'Catégorie principale de la ressource',
                                      PRIMARY KEY (`id`),
                                      KEY `idx_ressource_auteur` (`auteur_id`),
                                      CONSTRAINT `fk_ressource_auteur`
                                          FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`)
                                              ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Ressources pédagogiques internes (articles, tutoriels, fiches)';


-- ======================================================================
-- TABLE : commentaires
-- Commentaires des utilisateurs sur les ressources internes
-- ======================================================================
CREATE TABLE `commentaires` (
                                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du commentaire',
                                `ressource_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers la ressource commentée',
                                `auteur_id` INT UNSIGNED NULL
    COMMENT 'Référence vers l’utilisateur auteur du commentaire',
                                `contenu` TEXT NOT NULL
                                    COMMENT 'Texte du commentaire saisi par l’utilisateur',
                                `date_commentaire` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                    COMMENT 'Date et heure de publication du commentaire',
                                PRIMARY KEY (`id`),
                                KEY `idx_comment_ressource` (`ressource_id`),
                                KEY `idx_comment_auteur` (`auteur_id`),
                                CONSTRAINT `fk_comment_ressource`
                                    FOREIGN KEY (`ressource_id`) REFERENCES `ressources_contenu` (`id`)
                                        ON DELETE CASCADE ON UPDATE CASCADE,
                                CONSTRAINT `fk_comment_auteur`
                                    FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`)
                                        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Commentaires associés aux ressources internes';


-- ======================================================================
-- TABLE : defis
-- Défis / missions gamifiées
-- ======================================================================
CREATE TABLE `defis` (
                         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du défi',
                         `titre` VARCHAR(255) NOT NULL
                             COMMENT 'Titre court du défi',
                         `description` TEXT NOT NULL
                             COMMENT 'Description détaillée du défi ou de la mission',
                         `difficulte` ENUM('facile','moyen','difficile') NOT NULL DEFAULT 'facile'
    COMMENT 'Niveau de difficulté du défi',
                         `points` INT NOT NULL DEFAULT 10
                             COMMENT 'Nombre de points attribués en cas de réussite',
                         PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Défis et missions gamifiées autour du numérique responsable';


-- ======================================================================
-- TABLE : defis_utilisateurs
-- Statut des défis pour chaque utilisateur
-- ======================================================================
CREATE TABLE `defis_utilisateurs` (
                                      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du suivi de défi',
                                      `defi_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers le défi concerné',
                                      `user_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers l’utilisateur participant',
                                      `statut` ENUM('en_cours','reussi','echoue') NOT NULL DEFAULT 'en_cours'
    COMMENT 'Statut actuel du défi pour cet utilisateur',
                                      `date_statut` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                                          COMMENT 'Date et heure de la dernière mise à jour du statut',
                                      PRIMARY KEY (`id`),
                                      KEY `idx_defi_user_defi` (`defi_id`),
                                      KEY `idx_defi_user_user` (`user_id`),
                                      CONSTRAINT `fk_defi_user_defi`
                                          FOREIGN KEY (`defi_id`) REFERENCES `defis` (`id`)
                                              ON DELETE CASCADE ON UPDATE CASCADE,
                                      CONSTRAINT `fk_defi_user_user`
                                          FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                                              ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Participation des utilisateurs aux différents défis';


-- ======================================================================
-- TABLE : idees
-- Idées d’actions NIRD proposées par les utilisateurs
-- ======================================================================
CREATE TABLE `idees` (
                         `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de l’idée',
                         `user_id` INT UNSIGNED NULL
    COMMENT 'Référence vers l’utilisateur ayant proposé l’idée',
                         `etablissement_id` INT UNSIGNED NULL
    COMMENT 'Établissement principalement concerné par l’idée',
                         `titre` VARCHAR(255) NOT NULL
                             COMMENT 'Titre court décrivant l’idée',
                         `description` TEXT NOT NULL
                             COMMENT 'Description détaillée de l’idée ou de l’action proposée',
                         `categorie_action` ENUM(
      'sobriete_numerique',
      'logiciels_libres',
      'reemploi_reconditionnement',
      'linux',
      'communs_numeriques',
      'organisation',
      'sensibilisation',
      'autre'
  ) NOT NULL DEFAULT 'autre'
    COMMENT 'Catégorie principale de l’idée en lien avec la démarche NIRD',
                         `statut` ENUM('proposee','validee','refusee','archivee') NOT NULL DEFAULT 'proposee'
    COMMENT 'Statut de validation ou de suivi de l’idée',
                         `date_creation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                             COMMENT 'Date et heure de création de l’idée',
                         `date_mise_a_jour` DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    COMMENT 'Dernière date de modification de l’idée',
                         PRIMARY KEY (`id`),
                         KEY `idx_idees_user` (`user_id`),
                         KEY `idx_idees_etab` (`etablissement_id`),
                         CONSTRAINT `fk_idees_user`
                             FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
                                 ON DELETE SET NULL ON UPDATE CASCADE,
                         CONSTRAINT `fk_idees_etab`
                             FOREIGN KEY (`etablissement_id`) REFERENCES `etablissements` (`id`)
                                 ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Idées et actions proposées pour un numérique inclusif, responsable et durable';


-- ======================================================================
-- TABLE : quiz
-- Quiz pédagogiques composés de plusieurs questions
-- ======================================================================
CREATE TABLE `quiz` (
                        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du quiz',
                        `titre` VARCHAR(255) NOT NULL
                            COMMENT 'Titre du quiz',
                        `description` TEXT NULL
    COMMENT 'Description courte du quiz',
                        `public_cible` ENUM('eleve','enseignant','famille','direction','technicien','tous')
      NOT NULL DEFAULT 'tous'
    COMMENT 'Public principalement visé par le quiz',
                        `niveau` ENUM('debutant','intermediaire','avance')
      NOT NULL DEFAULT 'debutant'
    COMMENT 'Niveau global de difficulté du quiz',
                        `auteur_id` INT UNSIGNED NULL
    COMMENT 'Référence vers l’utilisateur créateur du quiz',
                        `date_creation` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
                            COMMENT 'Date et heure de création du quiz',
                        `date_mise_a_jour` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
    COMMENT 'Dernière date de modification du quiz',
                        PRIMARY KEY (`id`),
                        KEY `idx_quiz_auteur` (`auteur_id`),
                        CONSTRAINT `fk_quiz_auteur`
                            FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`)
                                ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Quiz pédagogiques sur le numérique inclusif, responsable et durable';


-- ======================================================================
-- TABLE : quiz_questions
-- Questions des quiz pédagogiques
-- ======================================================================
CREATE TABLE `quiz_questions` (
                                  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de la question',
                                  `quiz_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers le quiz auquel appartient la question',
                                  `intitule` TEXT NOT NULL
                                      COMMENT 'Texte complet de la question posée',
                                  `niveau` ENUM('debutant','intermediaire','avance')
      NOT NULL DEFAULT 'debutant'
    COMMENT 'Niveau de difficulté pédagogique de la question',
                                  `theme` ENUM(
      'sobriete_numerique',
      'logiciels_libres',
      'reemploi_reconditionnement',
      'linux',
      'communs_numeriques',
      'culture_generale',
      'autre'
  ) NOT NULL DEFAULT 'autre'
    COMMENT 'Thème principal abordé par la question',
                                  `type_public` ENUM('eleve','enseignant','famille','direction','technicien','tous')
      NOT NULL DEFAULT 'tous'
    COMMENT 'Public principalement visé par la question',
                                  `explication` TEXT NULL
    COMMENT 'Explication affichée après la réponse pour approfondir la notion',
                                  PRIMARY KEY (`id`),
                                  KEY `idx_quiz_question_quiz` (`quiz_id`),
                                  CONSTRAINT `fk_quiz_question_quiz`
                                      FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`)
                                          ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Questions de quiz sur le numérique inclusif, responsable et durable';


-- ======================================================================
-- TABLE : quiz_reponses
-- Réponses possibles pour chaque question des quiz
-- ======================================================================
CREATE TABLE `quiz_reponses` (
                                 `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de la réponse',
                                 `question_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers la question associée',
                                 `intitule` TEXT NOT NULL
                                     COMMENT 'Texte de la réponse proposée',
                                 `est_correcte` TINYINT(1) NOT NULL DEFAULT 0
    COMMENT 'Indique si la réponse est correcte (1) ou non (0)',
                                 `retroaction` TEXT NULL
    COMMENT 'Message de retour spécifique pour cette réponse',
                                 PRIMARY KEY (`id`),
                                 KEY `idx_quiz_rep_question` (`question_id`),
                                 CONSTRAINT `fk_quiz_rep_question`
                                     FOREIGN KEY (`question_id`) REFERENCES `quiz_questions` (`id`)
                                         ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Réponses associées aux questions des quiz NIRD';


-- ======================================================================
-- TABLE : parcours_etapes
-- Étapes du parcours ludique / narratif
-- ======================================================================
CREATE TABLE `parcours_etapes` (
                                   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de l’étape du parcours',
                                   `slug` VARCHAR(100) NOT NULL
                                       COMMENT 'Code court unique utilisé pour identifier l’étape',
                                   `titre` VARCHAR(255) NOT NULL
                                       COMMENT 'Titre affiché de l’étape',
                                   `contenu` TEXT NOT NULL
                                       COMMENT 'Texte ou narration de l’étape',
                                   `type_public` ENUM('eleve','enseignant','famille','direction','technicien','tous')
      NOT NULL DEFAULT 'tous'
    COMMENT 'Public principalement visé par cette étape',
                                   `type_etape` ENUM('information','choix','resultat')
      NOT NULL DEFAULT 'information'
    COMMENT 'Type d’étape : information, choix à faire ou résultat final',
                                   `ordre_affichage` INT NOT NULL DEFAULT 0
                                       COMMENT 'Ordre par défaut de l’étape dans le parcours',
                                   `illustration` VARCHAR(255) NULL
    COMMENT 'Chemin ou URL vers une illustration libre de droit',
                                   PRIMARY KEY (`id`),
                                   UNIQUE KEY `uniq_parcours_slug` (`slug`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Étapes du parcours interactif du village numérique résistant';


-- ======================================================================
-- TABLE : parcours_choix
-- Choix interactifs proposés dans certaines étapes
-- ======================================================================
CREATE TABLE `parcours_choix` (
                                  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique du choix de parcours',
                                  `etape_id` INT UNSIGNED NOT NULL
    COMMENT 'Référence vers l’étape à laquelle appartient ce choix',
                                  `libelle` VARCHAR(255) NOT NULL
                                      COMMENT 'Texte du choix affiché à l’utilisateur',
                                  `impact_dependance` TINYINT NOT NULL DEFAULT 0
                                      COMMENT 'Impact sur la dépendance aux Big Tech (valeur négative = réduction)',
                                  `impact_ecologie` TINYINT NOT NULL DEFAULT 0
                                      COMMENT 'Impact sur l’empreinte écologique / sobriété',
                                  `impact_inclusion` TINYINT NOT NULL DEFAULT 0
                                      COMMENT 'Impact sur l’inclusion et l’accessibilité',
                                  `message_resultat` TEXT NULL
    COMMENT 'Texte de feedback affiché après ce choix',
                                  `etape_suivante_id` INT UNSIGNED NULL
    COMMENT 'Éventuelle étape vers laquelle rediriger après ce choix',
                                  PRIMARY KEY (`id`),
                                  KEY `idx_parcours_choix_etape` (`etape_id`),
                                  KEY `idx_parcours_choix_etape_suiv` (`etape_suivante_id`),
                                  CONSTRAINT `fk_parcours_choix_etape`
                                      FOREIGN KEY (`etape_id`) REFERENCES `parcours_etapes` (`id`)
                                          ON DELETE CASCADE ON UPDATE CASCADE,
                                  CONSTRAINT `fk_parcours_choix_etape_suiv`
                                      FOREIGN KEY (`etape_suivante_id`) REFERENCES `parcours_etapes` (`id`)
                                          ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Choix interactifs du parcours avec impacts sur les indicateurs NIRD';


-- ======================================================================
-- TABLE : ressources_externes
-- Liens vers des ressources externes (site NIRD, vidéos, articles…)
-- ======================================================================
CREATE TABLE `ressources_externes` (
                                       `id` INT UNSIGNED NOT NULL AUTO_INCREMENT
    COMMENT 'Identifiant unique de la ressource externe',
                                       `titre` VARCHAR(255) NOT NULL
                                           COMMENT 'Titre de la ressource ou du lien externe',
                                       `url` VARCHAR(500) NOT NULL
                                           COMMENT 'URL complète de la ressource externe',
                                       `type_ressource` ENUM('site_officiel','article','video','podcast','fiche','outil','autre')
      NOT NULL DEFAULT 'autre'
    COMMENT 'Type principal de la ressource externe',
                                       `source` VARCHAR(255) NULL
    COMMENT 'Nom du média, de l’organisation ou de l’auteur',
                                       `public_cible` ENUM('eleve','enseignant','famille','direction','technicien','tous')
      NOT NULL DEFAULT 'tous'
    COMMENT 'Public principalement visé par cette ressource',
                                       `description` TEXT NULL
    COMMENT 'Résumé ou explication de l’intérêt de la ressource',
                                       `ordre_affichage` INT NOT NULL DEFAULT 0
                                           COMMENT 'Ordre de tri pour l’affichage de la ressource',
                                       PRIMARY KEY (`id`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci
  COMMENT='Ressources externes et liens autour du numérique inclusif, responsable et durable';
