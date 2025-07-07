<?php

class LoanCalculator {
    /**
     * Calcule les détails principaux d'un prêt
     * 
     * @param float $montant Montant du prêt
     * @param int $duree Durée en mois
     * @param float $taux Taux d'intérêt annuel
     * @return array Tableau avec les données du prêt
     */
    public static function calculateLoanDetails($montant, $duree, $taux) {
        $tauxMensuel = $taux / 12 / 100;
        
        if ($tauxMensuel === 0) {
            $mensualite = $montant / $duree;
            $totalRemboursement = $montant;
            $interets = 0;
        } else {
            $mensualite = ($montant * $tauxMensuel * pow(1 + $tauxMensuel, $duree)) / 
                         (pow(1 + $tauxMensuel, $duree) - 1);
            $totalRemboursement = $mensualite * $duree;
            $interets = $totalRemboursement - $montant;
        }
        
        return [
            'montant_pret' => $montant,
            'duree_remboursement' => $duree,
            'taux' => $taux,
            'montant_remboursement_par_mois' => $mensualite,
            'montant_total_remboursement' => $totalRemboursement
        ];
    }
    
    /**
     * Génère le tableau d'amortissement complet
     * 
     * @param float $montant Montant du prêt
     * @param int $duree Durée en mois
     * @param float $taux Taux d'intérêt annuel
     * @param string $dateDebut Date de début au format Y-m-d
     * @return array Tableau d'amortissement
     */
    public static function generateAmortizationTable($montant, $duree, $taux, $dateDebut) {
        $tauxMensuel = $taux / 12 / 100;
        $details = self::calculateLoanDetails($montant, $duree, $taux);
        $mensualite = $details['montant_remboursement_par_mois'];
        
        $amortization = [];
        $capitalRestant = $montant;
        $date = new DateTime($dateDebut);
        
        for ($mois = 1; $mois <= $duree; $mois++) {
            $date->add(new DateInterval('P1M'));
            $datePaiement = $date->format('Y-m-d');
            
            $interetsMois = $capitalRestant * $tauxMensuel;
            $capitalRembourse = $mensualite - $interetsMois;
            
            // Ajustement pour le dernier mois
            if ($mois === $duree) {
                $capitalRembourse = $capitalRestant;
                $mensualite = $capitalRembourse + $interetsMois;
                $capitalRestant = 0;
            } else {
                $capitalRestant -= $capitalRembourse;
            }
            
            $amortization[] = [
                'mois' => $mois,
                'date' => $datePaiement,
                'mensualite' => $mensualite,
                'capital' => $capitalRembourse,
                'interets' => $interetsMois,
                'reste' => max(0, $capitalRestant)
            ];
        }
        
        return $amortization;
    }
    
    /**
     * Prépare toutes les données nécessaires pour Pret_PDF
     * 
     * @param array $clientInfo Informations du client
     * @param array $loanType Type de prêt
     * @param float $montant Montant du prêt
     * @param int $duree Durée en mois
     * @param float $taux Taux d'intérêt annuel
     * @param string $dateDebut Date de début au format Y-m-d
     * @return array Toutes les données formatées pour Pret_PDF
     */
    public static function preparePdfData($clientInfo, $loanType, $montant, $duree, $taux, $dateDebut) {
        // Calcul des détails du prêt
        $pretData = self::calculateLoanDetails($montant, $duree, $taux);
        
        // Génération du tableau d'amortissement
        $amortization = self::generateAmortizationTable($montant, $duree, $taux, $dateDebut);
        
        return [
            'pretData' => $pretData,
            'amortization' => $amortization,
            'clientInfo' => $clientInfo,
            'typePret' => $loanType
        ];
    }
}

// Exemple d'utilisation:
/*
// Données d'entrée
$clientInfo = ['nom' => 'Dupont', 'prenom' => 'Jean'];
$loanType = ['nom' => 'Prêt personnel', 'taux' => 5.0];
$montant = 10000;
$duree = 36;
$taux = 5.0;
$dateDebut = '2023-01-01';

// Préparation des données pour le PDF
$pdfData = LoanCalculator::preparePdfData($clientInfo, $loanType, $montant, $duree, $taux, $dateDebut);

// Création du PDF
$pdf = new Pret_PDF();
$pdf->setPretData($pdfData['pretData']);
$pdf->setAmortization($pdfData['amortization']);
$pdf->setClientInfo($pdfData['clientInfo']);
$pdf->setTypePret($pdfData['typePret']);
$pdf->CreateReport();
$pdf->Output('D', 'simulation_pret.pdf');
*/
?>