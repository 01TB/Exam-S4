<?php
require_once __DIR__ . '/../controllers/InteretPretPeriodeController.php';

// Récupère tous les intérêts pour un prêt
Flight::route('GET /prets/@id/interets', ['InteretPretPeriodeController', 'getByPret']);

// Récupère tous les intérêts pour une période donnée
Flight::route('GET /interets/@mois/@annee', ['InteretPretPeriodeController', 'getByPeriode']);

// Calcule les intérêts pour un prêt à une période donnée
Flight::route('GET /prets/@id/interets/calculer/@mois/@annee', ['InteretPretPeriodeController', 'calculerInterets']);

// Crée un nouvel enregistrement d'intérêt
Flight::route('POST /interets', ['InteretPretPeriodeController', 'create']);

// Met à jour un intérêt existant
Flight::route('PUT /prets/@id/interets/@mois/@annee', ['InteretPretPeriodeController', 'update']);

// Supprime un intérêt
Flight::route('DELETE /prets/@id/interets/@mois/@annee', ['InteretPretPeriodeController', 'delete']);