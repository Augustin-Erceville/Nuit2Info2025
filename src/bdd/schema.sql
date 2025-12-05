-- Schema de la base `nird_village`
-- Généré à partir des modèles PHP dans src/modele

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =====================================================================
-- Suppression des tables existantes (ordre = enfants -> parents)
-- =====================================================================

DROP TABLE IF EXISTS `repondre`;
DROP TABLE IF EXISTS `parcours_choix`;
DROP TABLE IF EXISTS `parcours_etapes`;
DROP TABLE IF EXISTS `commentaires`;
DROP TABLE IF EXISTS `reonditionnement`;
DROP TABLE IF EXISTS `materiel`;
DROP TABLE IF EXISTS `defis`;
DROP TABLE IF EXISTS `idee`;
DROP TABLE IF EXISTS `ressources_contenu`;
DROP TABLE IF EXISTS `quiz`;
DROP TABLE IF EXISTS `etablissements`;
DROP TABLE IF EXISTS `utilisateur`;

-- =====================================================================
-- Table `utilisateur`
-- Modèle : Utilisateur.php
-- =====================================================================

CREATE TABLE `utilisateur` (
                               `id_utilisateur` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                               `prenom`         VARCHAR(100)  NOT NULL,
                               `nom`            VARCHAR(100)  NOT NULL,
                               `email`          VARCHAR(191)  NOT NULL,
                               `mdp`            VARCHAR(255)  NOT NULL,
                               `role`           VARCHAR(50)   NOT NULL DEFAULT 'user',
                               `rue`            VARCHAR(255)  NULL,
                               `cd`             INT           NULL,
                               `ville`          VARCHAR(100)  NULL,
                               `status`         VARCHAR(50)   NOT NULL DEFAULT 'Attente',
                               PRIMARY KEY (`id_utilisateur`),
                               UNIQUE KEY `uq_utilisateur_email` (`email`),
                               KEY `idx_utilisateur_ville` (`ville`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `etablissements`
-- Modèle : Etablissement.php
-- =====================================================================

CREATE TABLE `etablissements` (
                                  `id_etablissement`   INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                  `nom`                VARCHAR(255) NOT NULL,
                                  `adresse`            VARCHAR(255) NOT NULL,
                                  `code_postal`        VARCHAR(20)  NOT NULL,
                                  `ville`              VARCHAR(100) NOT NULL,
                                  `pays`               VARCHAR(100) NOT NULL DEFAULT 'France',
                                  `telephone`          VARCHAR(30)  NULL,
                                  `email`              VARCHAR(191) NULL,
                                  `type_etablissement` VARCHAR(50)  NOT NULL DEFAULT 'scolaire',
                                  `date_creation`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                  `statut`             VARCHAR(20)  NOT NULL DEFAULT 'actif',
                                  PRIMARY KEY (`id_etablissement`),
                                  KEY `idx_etab_ville` (`ville`),
                                  KEY `idx_etab_type` (`type_etablissement`),
                                  KEY `idx_etab_statut` (`statut`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `materiel`
-- Modèle : materiel.php
-- =====================================================================

CREATE TABLE `materiel` (
                            `id_materiel`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
                            `nom`                VARCHAR(255) NOT NULL,
                            `description`        TEXT         NOT NULL,
                            `quantite_disponible` INT UNSIGNED NOT NULL DEFAULT 0,
                            `quantite_totale`     INT UNSIGNED NOT NULL DEFAULT 0,
                            `etat`               VARCHAR(50)  NOT NULL DEFAULT 'bon',
                            `date_ajout`         DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `id_etablissement`   INT UNSIGNED NULL,
                            PRIMARY KEY (`id_materiel`),
                            KEY `idx_materiel_etab` (`id_etablissement`),
                            KEY `idx_materiel_nom` (`nom`),
                            CONSTRAINT `fk_materiel_etab`
                                FOREIGN KEY (`id_etablissement`)
                                    REFERENCES `etablissements` (`id_etablissement`)
                                    ON UPDATE CASCADE
                                    ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `reonditionnement`
-- Modèle : Reonditionnement.php
-- =====================================================================

CREATE TABLE `reonditionnement` (
                                    `id_reonditionnement` INT UNSIGNED NOT NULL AUTO_INCREMENT,
                                    `id_materiel`         INT UNSIGNED NOT NULL,
                                    `id_utilisateur`      INT UNSIGNED NOT NULL,
                                    `date_reonditionnement` DATETIME   NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    `etat_initial`        VARCHAR(100) NOT NULL,
                                    `etat_final`          VARCHAR(100) NOT NULL,
                                    `description`         TEXT         NOT NULL,
                                    `cout`                DECIMAL(10,2) NULL,
                                    `duree_travaux`       INT UNSIGNED NULL,
                                    `statut`              VARCHAR(50)  NOT NULL DEFAULT 'planifie',
                                    PRIMARY KEY (`id_reonditionnement`),
                                    KEY `idx_reond_materiel` (`id_materiel`),
                                    KEY `idx_reond_utilisateur` (`id_utilisateur`),
                                    CONSTRAINT `fk_reond_materiel`
                                        FOREIGN KEY (`id_materiel`)
                                            REFERENCES `materiel` (`id_materiel`)
                                            ON UPDATE CASCADE
                                            ON DELETE CASCADE,
                                    CONSTRAINT `fk_reond_utilisateur`
                                        FOREIGN KEY (`id_utilisateur`)
                                            REFERENCES `utilisateur` (`id_utilisateur`)
                                            ON UPDATE CASCADE
                                            ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `idee`
-- Modèle : Idee.php
-- =====================================================================

CREATE TABLE `idee` (
                        `id_idee`       INT UNSIGNED   NOT NULL AUTO_INCREMENT,
                        `titre`         VARCHAR(255)   NOT NULL,
                        `description`   TEXT           NOT NULL,
                        `date_creation` DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `id_createur`   INT UNSIGNED   NOT NULL,
                        `statut`        VARCHAR(50)    NOT NULL DEFAULT 'en_attente',
                        `categorie`     VARCHAR(50)    NOT NULL DEFAULT 'general',
                        `note_moyenne`  DECIMAL(3,2)   NOT NULL DEFAULT 0.00,
                        `nombre_votes`  INT UNSIGNED   NOT NULL DEFAULT 0,
                        PRIMARY KEY (`id_idee`),
                        KEY `idx_idee_createur` (`id_createur`),
                        KEY `idx_idee_categorie` (`categorie`),
                        KEY `idx_idee_statut` (`statut`),
                        CONSTRAINT `fk_idee_utilisateur`
                            FOREIGN KEY (`id_createur`)
                                REFERENCES `utilisateur` (`id_utilisateur`)
                                ON UPDATE CASCADE
                                ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `defis`
-- Modèle : Defi.php
-- =====================================================================

CREATE TABLE `defis` (
                         `id_defi`         INT UNSIGNED  NOT NULL AUTO_INCREMENT,
                         `titre`           VARCHAR(255)  NOT NULL,
                         `description`     TEXT          NOT NULL,
                         `date_creation`   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                         `date_limite`     DATETIME      NULL,
                         `id_createur`     INT UNSIGNED  NOT NULL,
                         `statut`          VARCHAR(50)   NOT NULL DEFAULT 'actif',
                         `recompense`      VARCHAR(255)  NULL,
                         `niveau_difficulte` VARCHAR(50) NOT NULL DEFAULT 'moyen',
                         PRIMARY KEY (`id_defi`),
                         KEY `idx_defi_createur` (`id_createur`),
                         KEY `idx_defi_statut` (`statut`),
                         CONSTRAINT `fk_defi_utilisateur`
                             FOREIGN KEY (`id_createur`)
                                 REFERENCES `utilisateur` (`id_utilisateur`)
                                 ON UPDATE CASCADE
                                 ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `ressources_contenu`
-- Modèle : RessourceContenu.php
-- =====================================================================

CREATE TABLE `ressources_contenu` (
                                      `id_ressource`     INT UNSIGNED   NOT NULL AUTO_INCREMENT,
                                      `titre`            VARCHAR(255)   NOT NULL,
                                      `description`      TEXT           NOT NULL,
                                      `contenu`          LONGTEXT       NOT NULL,
                                      `type_contenu`     VARCHAR(50)    NOT NULL DEFAULT 'article',
                                      `date_creation`    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                      `date_modification` DATETIME      NULL,
                                      `id_createur`      INT UNSIGNED   NULL,
                                      `est_public`       TINYINT(1)     NOT NULL DEFAULT 1,
                                      `categorie`        VARCHAR(50)    NOT NULL DEFAULT 'general',
                                      `mots_cles`        TEXT           NOT NULL,
                                      `nombre_vues`      INT UNSIGNED   NOT NULL DEFAULT 0,
                                      `note_moyenne`     DECIMAL(3,2)   NOT NULL DEFAULT 0.00,
                                      PRIMARY KEY (`id_ressource`),
                                      KEY `idx_ressource_createur` (`id_createur`),
                                      KEY `idx_ressource_categorie` (`categorie`),
                                      KEY `idx_ressource_public` (`est_public`),
                                      CONSTRAINT `fk_ressource_utilisateur`
                                          FOREIGN KEY (`id_createur`)
                                              REFERENCES `utilisateur` (`id_utilisateur`)
                                              ON UPDATE CASCADE
                                              ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `commentaires`
-- Modèle : Commentaire.php
-- =====================================================================

CREATE TABLE `commentaires` (
                                `id_commentaire` INT UNSIGNED  NOT NULL AUTO_INCREMENT,
                                `id_utilisateur` INT UNSIGNED  NOT NULL,
                                `contenu`        TEXT          NOT NULL,
                                `date_creation`  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                `id_ressource`   INT UNSIGNED  NULL,
                                `id_idee`        INT UNSIGNED  NULL,
                                `id_defi`        INT UNSIGNED  NULL,
                                PRIMARY KEY (`id_commentaire`),
                                KEY `idx_commentaire_utilisateur` (`id_utilisateur`),
                                KEY `idx_commentaire_ressource` (`id_ressource`),
                                KEY `idx_commentaire_idee` (`id_idee`),
                                KEY `idx_commentaire_defi` (`id_defi`),
                                CONSTRAINT `fk_commentaire_utilisateur`
                                    FOREIGN KEY (`id_utilisateur`)
                                        REFERENCES `utilisateur` (`id_utilisateur`)
                                        ON UPDATE CASCADE
                                        ON DELETE CASCADE,
                                CONSTRAINT `fk_commentaire_ressource`
                                    FOREIGN KEY (`id_ressource`)
                                        REFERENCES `ressources_contenu` (`id_ressource`)
                                        ON UPDATE CASCADE
                                        ON DELETE CASCADE,
                                CONSTRAINT `fk_commentaire_idee`
                                    FOREIGN KEY (`id_idee`)
                                        REFERENCES `idee` (`id_idee`)
                                        ON UPDATE CASCADE
                                        ON DELETE CASCADE,
                                CONSTRAINT `fk_commentaire_defi`
                                    FOREIGN KEY (`id_defi`)
                                        REFERENCES `defis` (`id_defi`)
                                        ON UPDATE CASCADE
                                        ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `parcours_etapes`
-- Modèle : ParcoursEtape.php
-- =====================================================================

CREATE TABLE `parcours_etapes` (
                                   `id_etape`         INT UNSIGNED   NOT NULL AUTO_INCREMENT,
                                   `id_parcours`      INT UNSIGNED   NOT NULL,
                                   `titre`            VARCHAR(255)   NOT NULL,
                                   `description`      TEXT           NOT NULL,
                                   `contenu`          LONGTEXT       NOT NULL,
                                   `type_contenu`     VARCHAR(50)    NOT NULL DEFAULT 'texte',
                                   `ordre`            INT            NOT NULL DEFAULT 0,
                                   `est_terminee`     TINYINT(1)     NOT NULL DEFAULT 0,
                                   `date_creation`    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                   `date_modification` DATETIME      NULL,
                                   PRIMARY KEY (`id_etape`),
                                   KEY `idx_parcours_etapes_parcours` (`id_parcours`),
                                   KEY `idx_parcours_etapes_ordre` (`id_parcours`,`ordre`)
    -- Remarque : la table `parcours` n'existe pas encore dans src/modele,
    -- donc pas de contrainte de clé étrangère ici sur id_parcours.
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `parcours_choix`
-- Modèle : ParcoursChoix.php
-- =====================================================================

CREATE TABLE `parcours_choix` (
                                  `id_choix`        INT UNSIGNED   NOT NULL AUTO_INCREMENT,
                                  `id_parcours`     INT UNSIGNED   NOT NULL,
                                  `id_etape_suivante` INT UNSIGNED NULL,
                                  `libelle_choix`   VARCHAR(255)   NOT NULL,
                                  `est_correct`     TINYINT(1)     NOT NULL DEFAULT 0,
                                  `ordre`           INT            NOT NULL DEFAULT 0,
                                  `points`          INT            NOT NULL DEFAULT 0,
                                  PRIMARY KEY (`id_choix`),
                                  KEY `idx_parcours_choix_parcours` (`id_parcours`),
                                  KEY `idx_parcours_choix_etape_suivante` (`id_etape_suivante`),
                                  CONSTRAINT `fk_parcours_choix_etape_suivante`
                                      FOREIGN KEY (`id_etape_suivante`)
                                          REFERENCES `parcours_etapes` (`id_etape`)
                                          ON UPDATE CASCADE
                                          ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `quiz`
-- Modèle : Quiz.php
-- =====================================================================

CREATE TABLE `quiz` (
                        `id_quiz`          INT UNSIGNED  NOT NULL AUTO_INCREMENT,
                        `titre`            VARCHAR(255)  NOT NULL,
                        `description`      TEXT          NOT NULL,
                        `id_createur`      INT UNSIGNED  NULL,
                        `date_creation`    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `date_modification` DATETIME     NULL,
                        `est_public`       TINYINT(1)    NOT NULL DEFAULT 0,
                        `niveau_difficulte` VARCHAR(50)  NOT NULL DEFAULT 'moyen',
                        `duree_minutes`    INT UNSIGNED  NULL,
                        `est_actif`        TINYINT(1)    NOT NULL DEFAULT 1,
                        PRIMARY KEY (`id_quiz`),
                        KEY `idx_quiz_createur` (`id_createur`),
                        KEY `idx_quiz_public` (`est_public`),
                        CONSTRAINT `fk_quiz_utilisateur`
                            FOREIGN KEY (`id_createur`)
                                REFERENCES `utilisateur` (`id_utilisateur`)
                                ON UPDATE CASCADE
                                ON DELETE SET NULL
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================
-- Table `repondre`
-- Modèle : Repondre.php
-- =====================================================================

CREATE TABLE `repondre` (
                            `id_reponse`     INT UNSIGNED   NOT NULL AUTO_INCREMENT,
                            `id_utilisateur` INT UNSIGNED   NOT NULL,
                            `id_question`    INT UNSIGNED   NOT NULL,
                            `id_choix`       INT UNSIGNED   NOT NULL,
                            `date_reponse`   DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
                            `est_correct`    TINYINT(1)     NULL,
                            `temps_reponse`  INT UNSIGNED   NULL,
                            PRIMARY KEY (`id_reponse`),
                            KEY `idx_repondre_utilisateur` (`id_utilisateur`),
                            KEY `idx_repondre_question` (`id_question`),
                            KEY `idx_repondre_choix` (`id_choix`),
                            CONSTRAINT `fk_repondre_utilisateur`
                                FOREIGN KEY (`id_utilisateur`)
                                    REFERENCES `utilisateur` (`id_utilisateur`)
                                    ON UPDATE CASCADE
                                    ON DELETE CASCADE
    -- Remarque : `id_question` et `id_choix` pointent vers des tables
    -- qui n'ont pas encore de modèle dans src/modele (ex: question),
    -- donc aucune contrainte de clé étrangère n'est définie ici.
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

-- =====================================================================

SET FOREIGN_KEY_CHECKS = 1;
