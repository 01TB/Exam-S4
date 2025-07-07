-- Insert into departement
INSERT INTO departement (nom) VALUES
('Finance'),
('Reception');

-- Insert into client
INSERT INTO client (nom, prenom) VALUES
('Dupont', 'Jean'),
('Durand', 'Marie'),
('Martin', 'Luc');

-- Insert into user
INSERT INTO user (id_departement, nom, prenom, password) VALUES
(1, 'admin', 'admin', '123'), -- Static hashed password (e.g., bcrypt)
(2, 'reception', 'reception', '123');

-- Insert into type_pret
INSERT INTO type_pret (nom, montant_min, montant_max, duree_remboursement_min, duree_remboursement_max, taux) VALUES
('Prêt Personnel', 1000.00, 5000.00, 6, 24, 5.00),
('Prêt Auto', 5000.00, 20000.00, 12, 60, 7.00),
('Prêt Immobilier', 10000.00, 100000.00, 60, 240, 3.50);

-- Insert into pret
INSERT INTO pret (id_client, id_user_demandeur, id_user_validateur, id_type_pret, montant_pret, montant_remboursement_par_mois, montant_total_remboursement, duree_remboursement, status, taux, date_demande, date_validation) VALUES
(1, 1, 2, 1, 3000.00, 135.42, 3250.00, 24, 'valide', 5.00, '2025-07-01', '2025-07-02'),
(2, 1, NULL, 2, 10000.00, 491.67, 11800.00, 24, 'cree', 7.00, '2025-07-03', NULL),
(3, 2, 2, 3, 50000.00, 2083.33, 62500.00, 30, 'valide', 3.50, '2025-07-04', '2025-07-05');

-- Insert into historique_pret
INSERT INTO historique_pret (id_user, id_pret, etat, date_modif) VALUES
(1, 1, 'cree', '2025-07-01 10:00:00'),
(2, 1, 'valide', '2025-07-02 14:30:00'),
(1, 2, 'cree', '2025-07-03 09:15:00'),
(2, 3, 'cree', '2025-07-04 11:20:00'),
(2, 3, 'valide', '2025-07-05 16:45:00');

-- Insert into depot
INSERT INTO depot (id_user, nom_investisseur, montant, date_depot, description) VALUES
(1, 'Jean Dupont', 10000.00, '2025-07-01 08:00:00', 'Investissement initial'),
(1, 'Marie Durand', 5000.00, '2025-07-02 12:30:00', 'Fonds de réserve'),
(2, 'Luc Martin', 15000.00, '2025-07-03 15:00:00', 'Dépôt pour expansion');