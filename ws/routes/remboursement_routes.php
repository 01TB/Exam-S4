<?php
require_once __DIR__ . '/../controllers/RemboursementController.php';

// Récupère tous les remboursements
Flight::route('GET /remboursements', ['RemboursementController', 'getAll']);

// Récupère un remboursement par son ID
Flight::route('GET /remboursements/@id', ['RemboursementController', 'getById']);

// Récupère tous les remboursements pour un prêt
Flight::route('GET /prets/@id/remboursements', ['RemboursementController', 'getByPret']);

// Récupère tous les remboursements pour une période donnée
Flight::route('GET /remboursements/@mois/@annee', ['RemboursementController', 'getByPeriode']);

// Crée un nouveau remboursement (avec intérêt associé)
Flight::route('POST /remboursements', ['RemboursementController', 'create']);

// Met à jour un remboursement existant
Flight::route('PUT /remboursements/@id', ['RemboursementController', 'update']);

// Supprime un remboursement
Flight::route('DELETE /remboursements/@id', ['RemboursementController', 'delete']);