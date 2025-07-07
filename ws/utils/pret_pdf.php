<?php

require("fpdf.php");

class Pret_PDF extends FPDF {
    private $pretData;
    private $amortization;
    private $clientInfo;
    private $typePret;
    
    // Setter methods
    public function setPretData($data) {
        $this->pretData = $data;
    }
    
    public function setAmortization($amortization) {
        $this->amortization = $amortization;
    }
    
    public function setClientInfo($clientInfo) {
        $this->clientInfo = $clientInfo;
    }
    
    public function setTypePret($typePret) {
        $this->typePret = $typePret;
    }

    function Header() {
        // Logo
        
        // Title
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'SIMULATION DE PRET', 0, 1, 'C');
        
        // Subtitle
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'DETAILS DU PRET', 0, 1, 'C');
        $this->Ln(5);
    }
    
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    function GenerateSummary() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'RESUME DU PRET', 0, 1);
        $this->Ln(5);
        
        // Client info
        $this->SetFont('Arial', '', 10);
        $this->Cell(40, 8, 'Client:', 0, 0);
        $this->Cell(0, 8, $this->clientInfo['nom'].' '.$this->clientInfo['prenom'], 0, 1);
        
        // Type de prêt
        $this->Cell(40, 8, 'Type de pret:', 0, 0);
        $this->Cell(0, 8, $this->typePret['nom'].' ('.$this->typePret['taux'].'%)', 0, 1);
        
        // Date
        $this->Cell(40, 8, 'Date simulation:', 0, 0);
        $this->Cell(0, 8, date('d/m/Y'), 0, 1);
        $this->Ln(5);
        
        // Summary table
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 220, 255);
        $this->Cell(60, 8, 'Parametre', 1, 0, 'C', true);
        $this->Cell(60, 8, 'Valeur', 1, 1, 'C', true);
        
        $this->SetFont('Arial', '', 10);
        $this->SetFillColor(240, 240, 240);
        
        $rows = [
            'Montant emprunte' => $this->pretData['montant_pret'],
            'Duree' => $this->pretData['duree_remboursement'].' mois',
            'Taux nominal' => $this->pretData['taux'].' %',
            'Mensualite' => $this->pretData['montant_remboursement_par_mois'],
            'Total a rembourser' => $this->pretData['montant_total_remboursement'],
            'Cout total des interets' => $this->pretData['montant_total_remboursement'] - $this->pretData['montant_pret']
        ];
        
        $fill = false;
        foreach ($rows as $label => $value) {
            $this->Cell(60, 8, $label, 1, 0, 'L', $fill);
            $this->Cell(60, 8, $value, 1, 1, 'R', $fill);
            $fill = !$fill;
        }
        
        $this->Ln(10);
    }
    
    function GenerateAmortizationTable() {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'TABLEAU D\'AMORTISSEMENT', 0, 1);
        $this->Ln(5);
        
        // Column widths
        $w = [15, 25, 30, 30, 30, 30];
        
        // Headers
        $this->SetFont('Arial', 'B', 10);
        $this->SetFillColor(200, 220, 255);
        
        $headers = ['Mois', 'Date', 'Mensualite', 'Capital', 'Interets', 'Reste'];
        for ($i = 0; $i < count($headers); $i++) {
            $this->Cell($w[$i], 8, $headers[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        
        // Table data
        $this->SetFont('Arial', '', 8);
        $fill = false;
        
        // Afficher seulement les 12 premiers mois et 12 derniers mois pour économiser de l'espace
        $totalMonths = count($this->amortization);
        $displayMonths = array_merge(
            array_slice($this->amortization, 0, 12),
            [['mois' => '...', 'date' => '...', 'mensualite' => '...', 'capital' => '...', 'interets' => '...', 'reste' => '...']],
            array_slice($this->amortization, -12)
        );
        
        foreach ($displayMonths as $row) {
            $this->Cell($w[0], 8, $row['mois'], 1, 0, 'C', $fill);
            $this->Cell($w[1], 8, $row['date'], 1, 0, 'C', $fill);
            $this->Cell($w[2], 8, $row['mensualite'], 1, 0, 'R', $fill);
            $this->Cell($w[3], 8, $row['capital'], 1, 0, 'R', $fill);
            $this->Cell($w[4], 8, $row['interets'], 1, 0, 'R', $fill);
            $this->Cell($w[5], 8, $row['reste'], 1, 1, 'R', $fill);
            $fill = !$fill;
        }
        
        // Total row
        $this->SetFont('Arial', 'B', 8);
        $this->Cell($w[0] + $w[1], 8, 'TOTAL', 1, 0, 'C', true);
        $this->Cell($w[2], 8, $this->pretData['montant_total_remboursement'], 1, 0, 'R', true);
        $this->Cell($w[3], 8, $this->pretData['montant_pret'], 1, 0, 'R', true);
        $this->Cell($w[4], 8, $this->pretData['montant_total_remboursement'] - $this->pretData['montant_pret'], 1, 0, 'R', true);
        $this->Cell($w[5], 8, '-', 1, 1, 'R', true);
        
        $this->Ln(10);
    }
    
    
    function GenerateLegalMentions() {
        $this->SetFont('Arial', 'I', 8);
        $this->MultiCell(0, 5, 'Cette simulation a valeur informative et ne constitue pas une offre de pret. Les conditions reelles du pret seront determinees lors de l\'etude complete de votre dossier par nos services.', 0, 'J');
    }
    
    function CreateReport() {
        $this->AliasNbPages();
        $this->AddPage('P'); // Portrait orientation
        
        $this->GenerateSummary();
        $this->GenerateAmortizationTable();
        $this->GenerateLegalMentions();
    }
}

// Exemple d'utilisation:
/*
$pdf = new Pret_PDF();
$pdf->setPretData([
    'montant_pret' => 10000,
    'duree_remboursement' => 36,
    'taux' => 5.0,
    'montant_remboursement_par_mois' => 299.71,
    'montant_total_remboursement' => 10789.56
]);

$pdf->setAmortization([
    // Tableau d'amortissement complet généré précédemment
]);

$pdf->setClientInfo([
    'nom' => 'Dupont',
    'prenom' => 'Jean'
]);

$pdf->setTypePret([
    'nom' => 'Prêt personnel',
    'taux' => 5.0
]);

$pdf->CreateReport();
$pdf->Output('D', 'simulation_pret.pdf');
*/
?>