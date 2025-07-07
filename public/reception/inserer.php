<?php
require_once '../partials_reception/header.php';
require_once '../partials_reception/sidebar.php';
?>
<style>
    main {
        margin-left: 0;
        padding: 2rem;
        font-family: 'Inter', sans-serif;
        max-width: 1200px;
        margin: 0 auto;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .form-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    label {
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    select,
    input {
        padding: 10px;
        border: 1px solid #FFDB4D;
        border-radius: 5px;
    }

    button {
        padding: 12px;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
    }

    #simulateBtn {
        background-color: #4CAF50;
    }

    #submitBtn {
        background-color: #2196F3;
    }

    #simulateBtn:hover {
        background-color: #45a049;
    }

    #submitBtn:hover {
        background-color: #0b7dda;
    }

    #simulationContainer {
        display: none;
        margin-top: 2rem;
    }

    .summary-cards {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        flex: 1;
        padding: 1rem;
        border-radius: 5px;
        background-color: #f8f9fa;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .summary-card h3 {
        margin-top: 0;
        color: #333;
    }

    .summary-value {
        font-size: 1.5rem;
        font-weight: bold;
        color: #2c3e50;
    }

    #amortizationTable {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 2rem;
    }

    #amortizationTable th, 
    #amortizationTable td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: right;
    }

    #amortizationTable th {
        background-color: #f2f2f2;
        text-align: center;
    }

    #amortizationTable tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .chart-container {
        width: 100%;
        height: 400px;
        margin-bottom: 2rem;
    }

    .tabs {
        display: flex;
        margin-bottom: 1rem;
    }

    .tab {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        margin-right: 5px;
    }

    .tab.active {
        background-color: #ddd;
        font-weight: bold;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    #exportBtn {
        background-color: #FF9800;
        margin-bottom: 1rem;
    }

    #exportBtn:hover {
        background-color: #e68a00;
    }
</style>
<main>
    <h2>Simulation détaillée de prêt</h2>
    <form id="loanForm">
        <div class="form-row">
            <div class="form-group">
                <label for="id_client">Client</label>
                <select name="id_client" id="id_client" required>
                    <option value="">Sélectionner un client</option>
                    <?php
                    $clients = [
                        ['id' => 1, 'nom' => 'Dupont', 'prenom' => 'Jean'],
                        ['id' => 2, 'nom' => 'Martin', 'prenom' => 'Sophie']
                    ];
                    foreach ($clients as $client) {
                        echo '<option value="'.$client['id'].'">'.$client['nom'].' '.$client['prenom'].'</option>';
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="id_type_pret">Type de prêt</label>
                <select name="id_type_pret" id="id_type_pret" required>
                    <option value="">Sélectionner un type</option>
                    <?php
                    $typesPret = [
                        ['id' => 1, 'nom' => 'Prêt personnel', 'taux' => 5.0, 'duree_max' => 60],
                        ['id' => 2, 'nom' => 'Prêt automobile', 'taux' => 7.0, 'duree_max' => 84],
                        ['id' => 3, 'nom' => 'Prêt immobilier', 'taux' => 3.5, 'duree_max' => 360]
                    ];
                    foreach ($typesPret as $type) {
                        echo '<option value="'.$type['id'].'" data-taux="'.$type['taux'].'" data-dureemax="'.$type['duree_max'].'">'.
                             $type['nom'].' ('.$type['taux'].'%)</option>';
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="montant_pret">Montant du prêt (€)</label>
                <input type="number" name="montant_pret" id="montant_pret" min="100" step="100" required>
            </div>
            
            <div class="form-group">
                <label for="duree_remboursement">Durée (mois)</label>
                <input type="number" name="duree_remboursement" id="duree_remboursement" min="6" max="360" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="taux">Taux d'intérêt (%)</label>
                <input type="number" name="taux" id="taux" step="0.01" min="0" max="20" required>
            </div>
            
            <div class="form-group">
                <label for="date_demande">Date de demande</label>
                <input type="date" name="date_demande" id="date_demande" required>
            </div>
        </div>

        <div class="form-row">
            <button type="button" id="simulateBtn">Simuler le prêt</button>
            <button type="submit" id="submitBtn">Soumettre la demande</button>
        </div>
    </form>

    <div id="simulationContainer">
        <button id="exportBtn" onclick="exportToPDF()">Exporter en PDF</button>
        
        <div class="summary-cards">
            <div class="summary-card">
                <h3>Mensualité</h3>
                <div class="summary-value" id="monthlyPayment">-</div>
            </div>
            <div class="summary-card">
                <h3>Total à rembourser</h3>
                <div class="summary-value" id="totalPayment">-</div>
            </div>
            <div class="summary-card">
                <h3>Coût des intérêts</h3>
                <div class="summary-value" id="interestCost">-</div>
            </div>
            <div class="summary-card">
                <h3>TAEG</h3>
                <div class="summary-value" id="taeg">-</div>
            </div>
        </div>

        <div class="tabs">
            <button class="tab active" onclick="openTab('amortization')">Tableau d'amortissement</button>
            <button class="tab" onclick="openTab('graph')">Visualisation</button>
        </div>

        <div id="amortization" class="tab-content active">
            <div style="overflow-x: auto;">
                <table id="amortizationTable">
                    <thead>
                        <tr>
                            <th>Mois</th>
                            <th>Date</th>
                            <th>Mensualité</th>
                            <th>Capital remboursé</th>
                            <th>Intérêts</th>
                            <th>Capital restant</th>
                        </tr>
                    </thead>
                    <tbody id="amortizationBody"></tbody>
                </table>
            </div>
        </div>

        <div id="graph" class="tab-content">
            <div class="chart-container">
                <canvas id="loanChart"></canvas>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('date_demande').valueAsDate = new Date();
    
    document.getElementById('id_type_pret').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            document.getElementById('taux').value = selectedOption.getAttribute('data-taux');
            document.getElementById('duree_remboursement').max = selectedOption.getAttribute('data-dureemax');
        }
    });

    document.getElementById('simulateBtn').addEventListener('click', simulateLoan);
});

let loanChart = null;

function simulateLoan() {
    const montant = parseFloat(document.getElementById('montant_pret').value);
    const duree = parseInt(document.getElementById('duree_remboursement').value);
    const taux = parseFloat(document.getElementById('taux').value);
    const dateDebut = new Date(document.getElementById('date_demande').value);

    if (!montant || !duree || !taux || !dateDebut) {
        alert('Veuillez remplir tous les champs pour la simulation');
        return;
    }

    // Calculs de base
    const tauxMensuel = taux / 12 / 100;
    let mensualite, totalRemboursement, interets;

    if (tauxMensuel === 0) {
        mensualite = montant / duree;
        totalRemboursement = montant;
        interets = 0;
    } else {
        mensualite = (montant * tauxMensuel * Math.pow(1 + tauxMensuel, duree)) / 
                    (Math.pow(1 + tauxMensuel, duree) - 1);
        totalRemboursement = mensualite * duree;
        interets = totalRemboursement - montant;
    }

    // Affichage des résultats synthétiques
    document.getElementById('monthlyPayment').textContent = mensualite.toFixed(2) + ' €';
    document.getElementById('totalPayment').textContent = totalRemboursement.toFixed(2) + ' €';
    document.getElementById('interestCost').textContent = interets.toFixed(2) + ' €';
    document.getElementById('taeg').textContent = taux.toFixed(2) + ' %';

    // Génération du tableau d'amortissement
    generateAmortizationTable(montant, duree, tauxMensuel, mensualite, dateDebut);

    // Génération du graphique
    generateChart(montant, interets);

    // Affichage de la section de résultats
    document.getElementById('simulationContainer').style.display = 'block';
}

function generateAmortizationTable(montant, duree, tauxMensuel, mensualite, dateDebut) {
    const tbody = document.getElementById('amortizationBody');
    tbody.innerHTML = '';

    let capitalRestant = montant;
    let totalInterets = 0;
    let totalCapital = 0;

    for (let mois = 1; mois <= duree; mois++) {
        const datePaiement = new Date(dateDebut);
        datePaiement.setMonth(datePaiement.getMonth() + mois);
        
        const interetsMois = capitalRestant * tauxMensuel;
        const capitalRembourse = mensualite - interetsMois;
        
        totalInterets += interetsMois;
        totalCapital += capitalRembourse;
        capitalRestant -= capitalRembourse;

        // Ajustement pour le dernier mois (arrondis)
        if (mois === duree) {
            capitalRestant = 0;
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${mois}</td>
            <td>${datePaiement.toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' })}</td>
            <td>${mensualite.toFixed(2)} €</td>
            <td>${capitalRembourse.toFixed(2)} €</td>
            <td>${interetsMois.toFixed(2)} €</td>
            <td>${Math.max(0, capitalRestant).toFixed(2)} €</td>
        `;
        tbody.appendChild(row);
    }

    // Ajout de la ligne de total
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = 'bold';
    totalRow.innerHTML = `
        <td colspan="2">Total</td>
        <td>${(mensualite * duree).toFixed(2)} €</td>
        <td>${montant.toFixed(2)} €</td>
        <td>${totalInterets.toFixed(2)} €</td>
        <td>-</td>
    `;
    tbody.appendChild(totalRow);
}

function generateChart(montant, interets) {
    const ctx = document.getElementById('loanChart').getContext('2d');
    
    // Détruire le graphique précédent s'il existe
    if (loanChart) {
        loanChart.destroy();
    }
    
    loanChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Capital emprunté', 'Intérêts'],
            datasets: [{
                data: [montant, interets],
                backgroundColor: [
                    '#36a2eb',
                    '#ff6384'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value.toFixed(2)} € (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

function openTab(tabName) {
    // Masquer tous les contenus d'onglets
    const tabContents = document.getElementsByClassName('tab-content');
    for (let i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove('active');
    }

    // Désactiver tous les onglets
    const tabs = document.getElementsByClassName('tab');
    for (let i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
    }

    // Activer l'onglet sélectionné
    document.getElementById(tabName).classList.add('active');
    event.currentTarget.classList.add('active');
}

document.getElementById('loanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Calcul des mensualités
    const tauxMensuel = parseFloat(data.taux) / 12 / 100;
    const nbMensualites = parseInt(data.duree_remboursement);
    const montant = parseFloat(data.montant_pret);
    
    let mensualite;
    if (tauxMensuel === 0) {
        mensualite = montant / nbMensualites;
    } else {
        mensualite = (montant * tauxMensuel * Math.pow(1 + tauxMensuel, nbMensualites)) / 
                    (Math.pow(1 + tauxMensuel, nbMensualites) - 1);
    }
    
    const totalRemboursement = mensualite * nbMensualites;
    
    // Ajout des champs calculés
    data.montant_remboursement_par_mois = mensualite.toFixed(2);
    data.montant_total_remboursement = totalRemboursement.toFixed(2);
    data.status = 'cree';
    
    console.log('Données à envoyer:', data);
    alert('Demande de prêt soumise avec succès!\nMensualité: ' + mensualite.toFixed(2) + '€');
});
</script>

<?php require_once '../partials_reception/footer.php'; ?>