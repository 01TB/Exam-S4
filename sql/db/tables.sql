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
    assurance DECIMAL(2,2) NOT NULL,
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

-- Intérêt prêt période
CREATE TABLE interet_pret_periode(
    id_pret INT NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    mois INT NOT NULL,
    annee INT NOT NULL,
    UNIQUE (id_pret,mois,annee),
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);

CREATE TABLE assurance_pret_periode(
    id_pret INT NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    mois INT NOT NULL,
    annee INT NOT NULL,
    UNIQUE (id_pret,mois,annee),
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);

-- Remboursement prêt
CREATE TABLE remboursement(
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pret INT NOT NULL,
    date_remboursement DATETIME NOT NULL,
    mois_rembourse INT NOT NULL,
    annee_rembourse INT NOT NULL,
    montant_rembourse DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (id_pret) REFERENCES pret(id)
);

CREATE VIEW vw_prets_en_cours AS
SELECT 
    p.id
FROM 
    pret p
JOIN 
    user ud ON p.id_user_demandeur = ud.id
LEFT JOIN 
    user uv ON p.id_user_validateur = uv.id
WHERE 
    p.status = 'valide'
    AND (
        SELECT IFNULL(SUM(r.montant_rembourse), 0) 
        FROM remboursement r 
        WHERE r.id_pret = p.id
    ) < p.montant_total_remboursement;

    SELECT 
        p.id AS id
    FROM 
        pret p
    JOIN 
        user ud ON p.id_user_demandeur = ud.id
    LEFT JOIN 
        user uv ON p.id_user_validateur = uv.id
    WHERE 
        p.status = 'valide'
        AND (
            SELECT IFNULL(SUM(r.montant_rembourse), 0) 
            FROM remboursement r 
            WHERE r.id_pret = p.id
        ) < p.montant_total_remboursement;

CREATE VIEW vw_prets_demande AS
SELECT 
    p.id
FROM 
    pret p
JOIN 
    user ud ON p.id_user_demandeur = ud.id
LEFT JOIN 
    user uv ON p.id_user_validateur = uv.id
WHERE 
    p.status = 'valide'
    AND (
        SELECT IFNULL(SUM(r.montant_rembourse), 0) 
        FROM remboursement r 
        WHERE r.id_pret = p.id
    ) < p.montant_total_remboursement;

CREATE OR REPLACE VIEW vw_tresorerie_mensuelle AS
SELECT 
    mois, 
    annee,
    COALESCE(SUM(total_depots), 0) AS total_depots,
    COALESCE(SUM(total_prets), 0) AS total_prets,
    COALESCE(SUM(total_remboursements), 0) AS total_remboursements,
    (COALESCE(SUM(total_depots), 0) - COALESCE(SUM(total_prets), 0) + COALESCE(SUM(total_remboursements), 0)) AS tresorerie_disponible
FROM (
    SELECT 
        MONTH(date_depot) AS mois,
        YEAR(date_depot) AS annee,
        SUM(montant) AS total_depots,
        0 AS total_prets,
        0 AS total_remboursements
    FROM depot
    GROUP BY YEAR(date_depot), MONTH(date_depot)
    
    UNION ALL
    
    SELECT 
        MONTH(date_validation) AS mois,
        YEAR(date_validation) AS annee,
        0 AS total_depots,
        SUM(montant_pret) AS total_prets,
        0 AS total_remboursements
    FROM pret
    WHERE status = 'valide'
    GROUP BY YEAR(date_validation), MONTH(date_validation)
    
    UNION ALL
    
    SELECT 
        MONTH(date_remboursement) AS mois,
        YEAR(date_remboursement) AS annee,
        0 AS total_depots,
        0 AS total_prets,
        SUM(montant_rembourse) AS total_remboursements
    FROM remboursement
    GROUP BY YEAR(date_remboursement), MONTH(date_remboursement)
) combined_data
GROUP BY mois, annee
ORDER BY annee, mois;
