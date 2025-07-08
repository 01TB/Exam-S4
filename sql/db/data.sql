-- Insertion des départements
INSERT INTO departement (nom) VALUES 
('Finances'),
('Reception');

-- Insertion des clients
INSERT INTO client (nom, prenom) VALUES 
('Dupont', 'Jean'),
('Martin', 'Sophie'),
('Bernard', 'Pierre'),
('Petit', 'Marie'),
('Durand', 'Luc'),
('Leroy', 'Isabelle'),
('Moreau', 'Thomas'),
('Simon', 'Nathalie'),
('Laurent', 'David'),
('Michel', 'Valérie');

-- Insertion des utilisateurs (employés)
INSERT INTO user (id_departement, nom, prenom, password) VALUES 
(1, 'admin', 'Philippe', '123'), -- password: password
(2, 'reception', 'Émilie', '123');

-- Insertion des types de prêts
INSERT INTO type_pret (nom, montant_max, montant_min, duree_remboursement_max, duree_remboursement_min, taux) VALUES 
('Prêt personnel', 50000.00, 1000.00, 84, 12, 4.50),
('Prêt immobilier', 500000.00, 50000.00, 300, 60, 2.85),
('Prêt automobile', 80000.00, 5000.00, 84, 12, 3.20),
('Crédit renouvelable', 20000.00, 500.00, 60, 1, 6.90),
('Prêt travaux', 75000.00, 5000.00, 120, 12, 3.75);

-- Insertion des prêts
-- INSERT INTO pret (id_client, id_user_demandeur, id_user_validateur, id_type_pret, montant_pret, montant_remboursement_par_mois, montant_total_remboursement, duree_remboursement, status, taux, assurance, date_demande, date_validation) VALUES 
-- (1, 3, 1, 1, 15000.00, 325.50, 19530.00, 60, 'valide', 4.50, 0.30, '2023-01-15', '2023-01-18'),
-- (2, 4, 1, 2, 250000.00, 1250.75, 300180.00, 240, 'valide', 2.85, 0.25, '2023-02-10', '2023-02-15'),
-- (3, 3, NULL, 3, 25000.00, 385.20, 23112.00, 60, 'cree', 3.20, 0.35, '2023-03-05', NULL),
-- (4, 4, 2, 4, 8000.00, 160.00, 9600.00, 60, 'valide', 6.90, 0.40, '2023-03-20', '2023-03-22'),
-- (5, 3, 2, 2, 180000.00, 900.45, 216108.00, 240, 'valide', 2.85, 0.25, '2023-04-01', '2023-04-05'),
-- (6, 3, NULL, 5, 35000.00, 350.75, 42090.00, 120, 'refuse', 3.75, 0.30, '2023-04-15', NULL),
-- (7, 4, 1, 1, 20000.00, 434.00, 26040.00, 60, 'valide', 4.50, 0.30, '2023-05-10', '2023-05-12'),
-- (8, 3, NULL, 3, 40000.00, 616.32, 36979.20, 60, 'cree', 3.20, 0.35, '2023-05-20', NULL),
-- (9, 4, 1, 4, 12000.00, 240.00, 14400.00, 60, 'valide', 6.90, 0.40, '2023-06-05', '2023-06-08'),
-- (10, 3, NULL, 5, 25000.00, 250.50, 30060.00, 120, 'cree', 3.75, 0.30, '2023-06-15', NULL);

-- Insertion de l'historique des prêts
-- INSERT INTO historique_pret (id_user, id_pret, etat, date_modif) VALUES 
-- (1, 1, 'cree', '2023-01-15 10:30:00'),
-- (5, 1, 'valide', '2023-01-18 14:15:00'),
-- (2, 2, 'cree', '2023-02-10 11:20:00'),
-- (5, 2, 'valide', '2023-02-15 09:45:00'),
-- (1, 3, 'cree', '2023-03-05 16:10:00'),
-- (2, 4, 'cree', '2023-03-20 13:25:00'),
-- (5, 4, 'valide', '2023-03-22 10:00:00'),
-- (3, 5, 'cree', '2023-04-01 09:30:00'),
-- (5, 5, 'valide', '2023-04-05 15:20:00'),
-- (4, 6, 'cree', '2023-04-15 14:45:00'),
-- (4, 6, 'refuse', '2023-04-18 11:10:00'),
-- (3, 7, 'cree', '2023-05-10 10:15:00'),
-- (5, 7, 'valide', '2023-05-12 16:30:00'),
-- (4, 8, 'cree', '2023-05-20 13:50:00'),
-- (1, 9, 'cree', '2023-06-05 09:25:00'),
-- (5, 9, 'valide', '2023-06-08 14:40:00'),
-- (2, 10, 'cree', '2023-06-15 11:05:00');

-- Insertion des dépôts
INSERT INTO depot (id_user, nom_investisseur, montant, date_depot, description) VALUES 
(1, 'Investisseur Privé A', 50000.00, '2023-01-10 10:00:00', 'Dépôt initial'),
(2, 'Fonds B', 100000.00, '2023-02-15 14:30:00', 'Financement prêts immo'),
(2, 'Société C', 75000.00, '2023-03-20 11:45:00', 'Capital risque'),
(1, 'Investisseur Privé D', 30000.00, '2023-04-05 09:15:00', 'Diversification'),
(1, 'Fonds E', 200000.00, '2023-05-12 16:20:00', 'Financement long terme'),
(2, 'Société F', 50000.00, '2023-06-18 13:10:00', 'Participation');

-- Insertion des intérêts prêt période
-- INSERT INTO interet_pret_periode (id_pret, montant, mois, annee) VALUES 
-- (1, 56.25, 1, 2023),
-- (1, 56.25, 2, 2023),
-- (1, 56.25, 3, 2023),
-- (2, 593.75, 2, 2023),
-- (2, 593.75, 3, 2023),
-- (2, 593.75, 4, 2023),
-- (4, 46.00, 3, 2023),
-- (4, 46.00, 4, 2023),
-- (4, 46.00, 5, 2023),
-- (5, 427.50, 4, 2023),
-- (5, 427.50, 5, 2023),
-- (5, 427.50, 6, 2023),
-- (7, 75.00, 5, 2023),
-- (7, 75.00, 6, 2023),
-- (9, 69.00, 6, 2023);

-- Insertion des remboursements
-- INSERT INTO remboursement (id_pret, date_remboursement, mois_rembourse, annee_rembourse, montant_rembourse) VALUES 
-- (1, '2023-02-01 00:00:00', 1, 2023, 325.50),
-- (1, '2023-03-01 00:00:00', 2, 2023, 325.50),
-- (1, '2023-04-01 00:00:00', 3, 2023, 325.50),
-- (2, '2023-03-01 00:00:00', 2, 2023, 1250.75),
-- (2, '2023-04-01 00:00:00', 3, 2023, 1250.75),
-- (2, '2023-05-01 00:00:00', 4, 2023, 1250.75),
-- (4, '2023-04-01 00:00:00', 3, 2023, 160.00),
-- (4, '2023-05-01 00:00:00', 4, 2023, 160.00),
-- (4, '2023-06-01 00:00:00', 5, 2023, 160.00),
-- (5, '2023-05-01 00:00:00', 4, 2023, 900.45),
-- (5, '2023-06-01 00:00:00', 5, 2023, 900.45),
-- (7, '2023-06-01 00:00:00', 5, 2023, 434.00),
-- (9, '2023-07-01 00:00:00', 6, 2023, 240.00);