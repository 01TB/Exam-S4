-- Base de données pour établissement financier
-- MySQL 11

-- Table des départements
CREATE TABLE departement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

-- Table des clients
CREATE TABLE client (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL
);

-- Table des utilisateurs (employés)
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_departement INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_departement) REFERENCES departement(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Table des types de prêts
CREATE TABLE type_pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    montant_max DECIMAL(15,2) NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    duree_remboursement_max INT NOT NULL,
    duree_remboursement_min INT NOT NULL,
    taux DECIMAL(5,2) NOT NULL
);

-- Table des prêts accordés
CREATE TABLE pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_client INT NOT NULL,
    id_user_demandeur INT NOT NULL,
    id_user_validateur INT DEFAULT NULL,
    id_type_pret INT NOT NULL,
    montant_pret DECIMAL(15,2) NOT NULL,
    montant_remboursement_par_mois DECIMAL(15,2) NOT NULL,
    montant_total_remboursement DECIMAL(15,2) NOT NULL,
    duree_remboursement INT NOT NULL,
    status ENUM('cree', 'valide', 'refuse') DEFAULT 'cree',
    taux DECIMAL(5,2) NOT NULL,
    date_demande DATE NOT NULL,
    date_validation DATE DEFAULT NULL,
    FOREIGN KEY (id_client) REFERENCES client(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_user_demandeur) REFERENCES user(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_user_validateur) REFERENCES user(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_type_pret) REFERENCES type_pret(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Table de l'historique des prêts
CREATE TABLE historique_pret (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_pret INT NOT NULL,
    etat ENUM('cree', 'valide', 'refuse') NOT NULL,
    date_modif DATETIME,
    FOREIGN KEY (id_user) REFERENCES user(id)
        ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY (id_pret) REFERENCES pret(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Table des dépôts
CREATE TABLE depot (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    nom_investisseur VARCHAR(200) NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    date_depot DATETIME,
    description TEXT,
    FOREIGN KEY (id_user) REFERENCES user(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
);
