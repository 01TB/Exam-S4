<?php
    require_once __DIR__.'\..\utils\algo.php';
    require_once __DIR__.'\..\utils\pret_pdf.php';
    class pdf {

        public static function generate_pdf($data){

            // Vérifier les données requises
            if (!isset($data['id_client'], $data['montant_pret'], $data['duree_remboursement'], $data['taux'])) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Données manquantes']);
                exit;
            }

            // Simuler les données client et type de prêt (à remplacer par un appel à votre base de données)
            $clients = Client::getAll();
            // $clients = [
            //     1 => ['nom' => 'Dupont', 'prenom' => 'Jean'],
            //     2 => ['nom' => 'Martin', 'prenom' => 'Sophie']
            // ];

            $typesPret = TypePret::getAll();

            $clientId = (int)$data['id_client'];
            $typePretId = (int)$data['id_type_pret'];

            // if (!isset($clients[$clientId])) {
            if (Client::getById($clientId)==null) {
                header('Content-Type: application/json');
                return ['error' => 'Client non trouvé'];
            }

            // if (!isset($typesPret[$typePretId])) {
            if (TypePret::getById($typePretId)==null) {
                header('Content-Type: application/json');
                return['error' => 'Type de prêt non trouvé'];
            }

            // Préparer les données pour le PDF
            $montant = (float)$data['montant_pret'];
            $duree = (int)$data['duree_remboursement'];
            $taux = (float)$data['taux'];
            $dateDebut = $data['date_demande'] ?? date('Y-m-d');

            $pdfData = LoanCalculator::preparePdfData(
                // $clients[$clientId],
                Client::getById($clientId),
                // $typesPret[$typePretId],
                TypePret::getById($typePretId),
                $montant,
                $duree,
                $taux,
                $dateDebut
            );

            // Générer le PDF
            $pdf = new Pret_PDF();
            $pdf->setPretData($pdfData['pretData']);
            $pdf->setAmortization($pdfData['amortization']);
            $pdf->setClientInfo($pdfData['clientInfo']);
            $pdf->setTypePret($pdfData['typePret']);
            $pdf->CreateReport();

            // Sauvegarder le PDF temporairement
            $pdfFileName = 'simulation_pret_' . time() . '.pdf';
            $pdfPath = __DIR__.'/../temp/' . $pdfFileName;

            // Créer le dossier temp s'il n'existe pas
            if (!file_exists(__DIR__.'/../temp')) {
                mkdir(__DIR__.'/../temp', 0777, true);
            }

            $pdf->Output('F', $pdfPath);

            // Retourner l'URL du PDF généré
            header('Content-Type: application/json');
            return[
                'pdfUrl' => 'http://localhost/Exam-S4/temp/' . $pdfFileName
            ];

            }
        }
    
?>