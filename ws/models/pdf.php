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

            $clientId = (int)$data['id_client'];
            $typePretId = (int)$data['id_type_pret'];
            $client = Client::getById($clientId);
            $type=TypePret::getById($typePretId);

            // if (!isset($clients[$clientId])) {
            if ($client==null) {
                header('Content-Type: application/json');
                return ['error' => 'Client non trouvé'];
            }

            // if (!isset($typesPret[$typePretId])) {
            if ($type==null) {
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
                ['nom' => $client->getNom(), 'prenom' => $client->getPrenom()],
                // $typesPret[$typePretId],
                ['nom' => $type->getNom(), 'taux' => $type->getTaux()],
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
                'pdfUrl' => 'http://localhost/Exam-S4/ws/temp/' . $pdfFileName
            ];

            }
        }
    
?>