-- Insertion dans la table type_pret
INSERT INTO type_pret (nom, montant_max, montant_min, duree_remboursement_max, duree_remboursement_min, taux) VALUES
('Prêt personnel', 50000.00, 1000.00, 60, 12, 5.50),
('Prêt immobilier', 300000.00, 50000.00, 300, 60, 2.75),
('Prêt automobile', 80000.00, 5000.00, 84, 12, 3.25),
('Crédit renouvelable', 20000.00, 500.00, 48, 1, 8.90),
('Prêt étudiant', 30000.00, 1000.00, 120, 12, 1.50);

-- Insertion dans la table client
INSERT INTO client (nom, prenom) VALUES
('Dupont', 'Jean'),
('Martin', 'Sophie'),
('Bernard', 'Pierre'),
('Petit', 'Marie'),
('Durand', 'Luc');

-- Insertion dans la table departement (supposée existante pour la clé étrangère)
-- Note: Cette table n'était pas dans votre modèle initial, je la crée pour l'exemple
CREATE TABLE departement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

INSERT INTO departement (nom) VALUES
('Direction'),
('Commercial'),
('Comptabilité'),
('Ressources Humaines'),
('Service Client');

-- Insertion dans la table user
INSERT INTO user (id_departement, nom, prenom, password) VALUES
(1, 'Admin', 'System', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: password
(2, 'Lefebvre', 'Thomas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'Moreau', 'Isabelle', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(4, 'Roux', 'Nicolas', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(5, 'Fournier', 'Emilie', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insertion dans la table pret
INSERT INTO pret (
    id_client, id_user_demandeur, id_user_validateur, id_type_pret, 
    montant_pret, montant_remboursement_par_mois, montant_total_remboursement, 
    duree_remboursement, taux, date_demande, date_validation, statut
) VALUES
-- Prêt personnel validé
(1, 2, 1, 1, 15000.00, 286.79, 17207.40, 60, 5.50, '2023-01-15', '2023-01-20', 'valide'),
-- Prêt immobilier en attente
(2, 3, NULL, 2, 200000.00, 833.33, 300000.00, 300, 2.75, '2023-02-10', NULL, 'cree'),
-- Prêt automobile refusé
(3, 4, 1, 3, 25000.00, 382.50, 22950.00, 60, 3.25, '2023-03-05', '2023-03-10', 'refuse'),
-- Crédit renouvelable validé
(4, 5, 3, 4, 5000.00, 126.67, 6080.00, 48, 8.90, '2023-04-12', '2023-04-15', 'valide'),
-- Prêt étudiant en attente
(5, 2, NULL, 5, 10000.00, 87.50, 10500.00, 120, 1.50, '2023-05-20', NULL, 'cree');