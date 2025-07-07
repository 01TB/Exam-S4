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

-- TYPE DE PRET
INSERT INTO type_pret (nom, montant_min, montant_max, duree_remboursement_min, duree_remboursement_max, taux) VALUES
('Prêt Personnel', 1000.00, 10000.00, 6, 36, 5.00),
('Prêt Auto', 5000.00, 30000.00, 12, 60, 6.50),
('Prêt Immobilier', 20000.00, 200000.00, 60, 300, 3.75);

-- PRET
INSERT INTO pret (
    id_client, id_user_demandeur, id_user_validateur, id_type_pret,
    montant_pret, montant_remboursement_par_mois, montant_total_remboursement,
    duree_remboursement, status, taux, date_demande, date_validation
) VALUES
(1, 1, 2, 1, 5000.00, 219.79, 5275.00, 24, 'valide', 5.00, '2025-06-01', '2025-06-03'),
(2, 2, 1, 2, 15000.00, 438.71, 17548.50, 40, 'cree', 6.50, '2025-06-15', NULL),
(3, 2, 1, 3, 80000.00, 462.50, 138750.00, 300, 'valide', 3.75, '2025-05-20', '2025-06-01');

-- HISTORIQUE PRET
INSERT INTO historique_pret (id_user, id_pret, etat, date_modif) VALUES
(1, 1, 'cree', '2025-06-01 08:00:00'),
(2, 1, 'valide', '2025-06-03 09:00:00'),
(2, 2, 'cree', '2025-06-15 10:30:00'),
(2, 3, 'cree', '2025-05-20 09:15:00'),
(1, 3, 'valide', '2025-06-01 10:00:00');

-- DEPOT
INSERT INTO depot (id_user, nom_investisseur, montant, date_depot, description) VALUES
(1, 'Jean Dupont', 12000.00, '2025-06-01 09:00:00', 'Capital initial'),
(2, 'Marie Durand', 8000.00, '2025-06-05 14:30:00', 'Investissement régulier'),
(1, 'Luc Martin', 15000.00, '2025-06-10 11:45:00', 'Fonds projet immo');

-- INTERET_PRET_PERIODE
INSERT INTO interet_pret_periode (id_pret, montant, mois, annee) VALUES
(1, 50.00, 6, 2025),
(1, 45.00, 7, 2025),
(2, 120.00, 6, 2025),
(3, 300.00, 6, 2025),
(3, 310.00, 7, 2025);

-- REMBOURSEMENT
INSERT INTO remboursement (id_pret, date_remboursement, mois_rembourse, annee_rembourse, montant_rembourse) VALUES
(1, '2025-06-05 10:00:00', 6, 2025, 219.79),
(1, '2025-07-05 10:00:00', 7, 2025, 219.79),
(3, '2025-06-20 15:00:00', 6, 2025, 462.50),
(3, '2025-07-20 15:00:00', 7, 2025, 462.50);
