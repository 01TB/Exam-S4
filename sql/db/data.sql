-- ============================
-- INSERTIONS DE DONNÉES
-- ============================

-- Départements
INSERT INTO departement (nom) VALUES
('Finance'),
('Reception');

-- Clients
INSERT INTO client (nom, prenom) VALUES
('Dupont', 'Jean'),
('Durand', 'Marie'),
('Martin', 'Luc');

-- Utilisateurs
INSERT INTO user (id_departement, nom, prenom, password) VALUES
(1, 'admin', 'admin', '123'), 
(2, 'reception', 'reception', '123');

-- Types de prêts
INSERT INTO type_pret (nom, montant_min, montant_max, duree_remboursement_min, duree_remboursement_max, taux) VALUES
('Prêt Personnel', 1000.00, 10000.00, 6, 36, 5.00),
('Prêt Auto', 5000.00, 30000.00, 12, 60, 6.50),
('Prêt Immobilier', 20000.00, 200000.00, 60, 300, 3.75);

-- Prêts accordés (avec assurance)
INSERT INTO pret (
    id_client, id_user_demandeur, id_user_validateur, id_type_pret,
    montant_pret, montant_remboursement_par_mois, montant_total_remboursement,
    duree_remboursement, status, taux, assurance, date_demande, date_validation
) VALUES
(1, 1, 1, 1, 5000.00, 150.00, 5400.00, 36, 'valide', 5.00, 0.02, '2025-01-10', '2025-01-15'),
(2, 2, 1, 2, 10000.00, 200.00, 12000.00, 60, 'valide', 6.50, 0.03, '2025-02-05', '2025-02-07'),
(3, 1, NULL, 3, 30000.00, 250.00, 45000.00, 120, 'cree', 3.75, 0.01, '2025-03-12', NULL);

-- Historique des prêts
INSERT INTO historique_pret (id_user, id_pret, etat, date_modif) VALUES
(1, 1, 'cree', '2025-01-10 09:00:00'),
(1, 1, 'valide', '2025-01-15 10:30:00'),
(2, 2, 'cree', '2025-02-05 11:00:00'),
(1, 2, 'valide', '2025-02-07 14:00:00'),
(1, 3, 'cree', '2025-03-12 08:00:00');

-- Dépôts
INSERT INTO depot (id_user, nom_investisseur, montant, date_depot, description) VALUES
(1, 'Banque Centrale', 500000.00, '2025-01-01 10:00:00', 'Fonds initiaux'),
(2, 'Investisseur privé', 150000.00, '2025-02-10 15:00:00', 'Dépôt personnel');

-- Intérêts mensuels
INSERT INTO interet_pret_periode (id_pret, montant, mois, annee) VALUES
(1, 20.00, 1, 2025),
(1, 18.00, 2, 2025),
(2, 35.00, 2, 2025),
(2, 34.00, 3, 2025);

-- Remboursements
INSERT INTO remboursement (id_pret, date_remboursement, mois_rembourse, annee_rembourse, montant_rembourse) VALUES
(1, '2025-02-01 08:00:00', 1, 2025, 150.00),
(1, '2025-03-01 08:00:00', 2, 2025, 150.00),
(2, '2025-03-01 09:30:00', 2, 2025, 200.00);
