-- =====================================================================
-- Base de données : gestion_attestations
-- Application de demande d'attestation en ligne
-- =====================================================================

CREATE DATABASE IF NOT EXISTS gestion_attestations
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE gestion_attestations;

-- ---------------------------------------------------------------------
-- Table : users (étudiants + agents administratifs)
-- ---------------------------------------------------------------------
CREATE TABLE users (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    role              ENUM('etudiant', 'admin') NOT NULL DEFAULT 'etudiant',
    nom               VARCHAR(100) NOT NULL,
    prenom            VARCHAR(100) NOT NULL,
    email             VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe      VARCHAR(255) NOT NULL,
    matricule         VARCHAR(50)  DEFAULT NULL UNIQUE,
    filiere           VARCHAR(150) DEFAULT NULL,
    niveau            VARCHAR(50)  DEFAULT NULL,
    telephone         VARCHAR(30)  DEFAULT NULL,
    statut_compte     ENUM('actif', 'suspendu') NOT NULL DEFAULT 'actif',
    created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : types_attestation
-- ---------------------------------------------------------------------
CREATE TABLE types_attestation (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    nom                 VARCHAR(150) NOT NULL,
    description         VARCHAR(255) DEFAULT NULL,
    delai_traitement_j  INT NOT NULL DEFAULT 3,
    actif               TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : demandes (fiche de demande d'attestation)
-- ---------------------------------------------------------------------
CREATE TABLE demandes (
    id                    INT AUTO_INCREMENT PRIMARY KEY,
    code_demande          VARCHAR(20) NOT NULL UNIQUE,
    user_id               INT NOT NULL,
    type_id               INT NOT NULL,
    objet                 VARCHAR(255) NOT NULL,
    statut                ENUM('en_attente','en_cours','traitee','refusee','retiree') NOT NULL DEFAULT 'en_attente',
    date_demande          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_prevue_retrait   DATE DEFAULT NULL,
    date_traitement       DATETIME DEFAULT NULL,
    observations          VARCHAR(500) DEFAULT NULL,
    motif_refus           VARCHAR(255) DEFAULT NULL,
    traite_par            INT DEFAULT NULL,
    CONSTRAINT fk_demande_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_demande_type FOREIGN KEY (type_id) REFERENCES types_attestation(id),
    CONSTRAINT fk_demande_agent FOREIGN KEY (traite_par) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : historique_demandes (traçabilité des changements de statut)
-- ---------------------------------------------------------------------
CREATE TABLE historique_demandes (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    demande_id      INT NOT NULL,
    ancien_statut   VARCHAR(30) DEFAULT NULL,
    nouveau_statut  VARCHAR(30) NOT NULL,
    commentaire     VARCHAR(255) DEFAULT NULL,
    agent_id        INT DEFAULT NULL,
    date_changement DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_hist_demande FOREIGN KEY (demande_id) REFERENCES demandes(id) ON DELETE CASCADE,
    CONSTRAINT fk_hist_agent FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- Table : retraits (fiche de retrait d'attestation)
-- ---------------------------------------------------------------------
CREATE TABLE retraits (
    id                    INT AUTO_INCREMENT PRIMARY KEY,
    demande_id            INT NOT NULL UNIQUE,
    date_retrait          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nom_receveur          VARCHAR(150) NOT NULL,
    agent_id              INT DEFAULT NULL,
    CONSTRAINT fk_retrait_demande FOREIGN KEY (demande_id) REFERENCES demandes(id) ON DELETE CASCADE,
    CONSTRAINT fk_retrait_agent FOREIGN KEY (agent_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =====================================================================
-- Données de démonstration
-- =====================================================================

-- Compte administrateur (mot de passe : Admin@2026)
INSERT INTO users (role, nom, prenom, email, mot_de_passe, statut_compte)
VALUES ('admin', 'Andria', 'Fara', 'admin@universite.mg',
        '$2b$12$iOpKKJlQYk/.GaI6Si.jE.4lqSBG/zIct0prGDvNLlKJmeFw.C0QS', 'actif');

-- Types d'attestations courants
INSERT INTO types_attestation (nom, description, delai_traitement_j) VALUES
('Certificat de scolarité', 'Atteste de l\'inscription en cours pour l\'année académique', 2),
('Attestation d\'inscription', 'Confirme l\'inscription administrative de l\'étudiant', 2),
('Relevé de notes', 'Récapitulatif des notes obtenues par semestre', 4),
('Attestation de réussite', 'Confirme la réussite à une année ou un diplôme', 5),
('Attestation de présence', 'Justifie la présence de l\'étudiant sur une période donnée', 2);
