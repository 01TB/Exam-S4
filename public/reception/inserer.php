<?php
echo $_SESSION["user"]
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Insérer un prêt</title>
    <!-- Tailwind CSS and DaisyUI CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- Google Fonts: Playfair Display, Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Heroicons CDN -->
    <script src="https://unpkg.com/heroicons@2.1.1/dist/heroicons.min.js"></script>
    <!-- Chart.js, jsPDF, and html2canvas CDNs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F6F7;
            /* Off-White */
            color: #101820;
            /* Near Black */
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: #003A70;
            /* Dark Blue */
        }

        .card,
        .summary-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover,
        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 58, 112, 0.1);
            /* Shadow with Dark Blue tint */
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab {
            transition: background-color 0.3s ease;
        }

        .tab:hover {
            background-color: #007CBA;
            /* Light Blue */
            color: #F5F6F7;
            /* Off-White */
        }
    </style>
</head>

<body>
    <!-- Header with Navbar -->
    <header class="bg-[#003A70] shadow">
        <div class="navbar container mx-auto px-4">
            <div class="navbar-start">
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-ghost lg:hidden">
                        <svg class="h-6 w-6" fill="none" stroke="#007CBA" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                    <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-[#A0B2B8] rounded-box w-52">
                        <li><a href="/EXAM-S4/public/reception/reception.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Accueil</a></li>
                        <li><a href="/EXAM-S4/public/reception/inserer.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Insérer un prêt</a></li>
                        <li><a href="/EXAM-S4/public/reception/liste_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Liste des prêts</a></li>
                        <li><a href="/EXAM-S4/public/login.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Déconnexion</a></li>
                    </ul>
                </div>
                <div class="flex items-center">
                    <svg class="h-8 w-8 mr-2 fill-[#007CBA]" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                    <a class="text-2xl font-bold text-[#007CBA] font-['Playfair_Display']">CPbank</a>
                </div>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <li><a href="/EXAM-S4/public/reception/reception.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Accueil</a></li>
                    <li><a href="/EXAM-S4/public/reception/inserer.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Insérer un prêt</a></li>
                    <li><a href="/EXAM-S4/public/reception/liste_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Liste des prêts</a></li>
                    <li><a href="/EXAM-S4/public/login.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Déconnexion</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <span class="text-[#007CBA] font-['Inter']">Réception</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Simulation détaillée de prêt</h2>
        <form id="loanForm" class="card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="id_client">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Client</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </label>
                    <select name="id_client" id="id_client" class="select select-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                        <option value="">Sélectionner un client</option>
                        <option value="1">Dupont Jean</option>
                        <option value="2">Martin Sophie</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label" for="id_type_pret">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Type de prêt</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14"></path>
                        </svg>
                    </label>
                    <select name="id_type_pret" id="id_type_pret" class="select select-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                        <option value="">Sélectionner un type</option>
                        <option value="1" data-taux="5.0" data-dureemax="60">Prêt personnel (5.0%)</option>
                        <option value="2" data-taux="7.0" data-dureemax="84">Prêt automobile (7.0%)</option>
                        <option value="3" data-taux="3.5" data-dureemax="360">Prêt immobilier (3.5%)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="montant_pret">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Montant du prêt (€)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </label>
                    <input type="number" name="montant_pret" id="montant_pret" min="100" step="100" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
                <div class="form-control">
                    <label class="label" for="duree_remboursement">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Durée (mois)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <input type="number" name="duree_remboursement" id="duree_remboursement" min="6" max="360" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="taux">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Taux d'intérêt (%)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </label>
                    <input type="number" name="taux" id="taux" step="0.01" min="0" max="20" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
                <div class="form-control">
                    <label class="label" for="date_demande">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Date de demande</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <input type="date" name="date_demande" id="date_demande" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
            </div>
            <div class="flex gap-4">
                <button type="button" id="simulateBtn" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Simuler le prêt
                </button>
                <button type="submit" id="submitBtn" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Soumettre la demande
                </button>
            </div>
        </form>

        <div id="simulationContainer" class="mt-8 hidden">
            <button id="exportBtn" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] mb-4 flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Exporter en PDF
            </button>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="summary-card card bg-[#F5F6F7] p-4 shadow-lg rounded-lg fade-in">
                    <h3 class="text-lg font-['Playfair_Display'] text-[#003A70]">Mensualité</h3>
                    <div class="text-2xl font-bold text-[#101820]" id="monthlyPayment">-</div>
                </div>
                <div class="summary-card card bg-[#F5F6F7] p-4 shadow-lg rounded-lg fade-in">
                    <h3 class="text-lg font-['Playfair_Display'] text-[#003A70]">Total à rembourser</h3>
                    <div class="text-2xl font-bold text-[#101820]" id="totalPayment">-</div>
                </div>
                <div class="summary-card card bg-[#F5F6F7] p-4 shadow-lg rounded-lg fade-in">
                    <h3 class="text-lg font-['Playfair_Display'] text-[#003A70]">Coût des intérêts</h3>
                    <div class="text-2xl font-bold text-[#101820]" id="interestCost">-</div>
                </div>
                <div class="summary-card card bg-[#F5F6F7] p-4 shadow-lg rounded-lg fade-in">
                    <h3 class="text-lg font-['Playfair_Display'] text-[#003A70]">TAEG</h3>
                    <div class="text-2xl font-bold text-[#101820]" id="taeg">-</div>
                </div>
            </div>
            <div class="tabs flex mb-4">
                <button class="tab btn bg-[#A0B2B8] text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] mr-2 active" onclick="openTab('amortization')">Tableau d'amortissement</button>
                <button class="tab btn bg-[#A0B2B8] text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]" onclick="openTab('graph')">Visualisation</button>
            </div>
            <div id="amortization" class="tab-content active">
                <div class="overflow-x-auto">
                    <table class="table w-full border-collapse">
                        <thead>
                            <tr class="bg-[#A0B2B8] text-[#003A70]">
                                <th class="font-['Playfair_Display']">Mois</th>
                                <th class="font-['Playfair_Display']">Date</th>
                                <th class="font-['Playfair_Display']">Mensualité</th>
                                <th class="font-['Playfair_Display']">Capital remboursé</th>
                                <th class="font-['Playfair_Display']">Intérêts</th>
                                <th class="font-['Playfair_Display']">Capital restant</th>
                            </tr>
                        </thead>
                        <tbody id="amortizationBody"></tbody>
                    </table>
                </div>
            </div>
            <div id="graph" class="tab-content">
                <div class="chart-container h-[400px]">
                    <canvas id="loanChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>

    <script src="../js/ajax.js"></script>

    <script>
        function ajouterOuModifierPret() {
            const id = document.getElementById("id").value;
            const id_type_pret = document.getElementById("id_type_pret").value;
            const id_user_demandeur = 2;
            const client_id = document.getElementById("client_id").value;
            const montant = document.getElementById("montant").value;
            const date_demande = document.getElementById("date_demande").value;
            const duree_remboursement = document.getElementById("duree_remboursement").value;
            const taux = document.getElementById("taux").value;

            // Client-side validation
            if (!id_type_pret || !client_id || !montant || !date_demande || !duree_remboursement) {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'Veuillez remplir tous les champs obligatoires';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                return;
            }
            if (montant <= 0) {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'Le montant doit être positif';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                return;
            }
            if (duree_remboursement <= 0) {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'La durée de remboursement doit être positive';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                return;
            }

            const data = `id_type_pret=${encodeURIComponent(id_type_pret)}&id_client=${encodeURIComponent(client_id)}&montant_pret=${montant}&taux=${taux}&date_demande=${encodeURIComponent(date_demande)}&duree_remboursement=${duree_remboursement}&id_user_demandeur=${id_user_demandeur}`;


            ajax("POST", "/pret/demande", data, () => {
                resetFormPret();
                chargerPrets();
                document.querySelector('.success').style.display = 'block';
                document.querySelector('.success').textContent = 'Prêt ajouté avec succès !';
                setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
            }, (error) => {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = `Erreur: ${error}`;
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
            });
        }
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
                row.className = 'hover:bg-[#007CBA] hover:text-[#F5F6F7]';
                row.innerHTML = `
                    <td class="font-['Inter']">${mois}</td>
                    <td class="font-['Inter']">${datePaiement.toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' })}</td>
                    <td class="font-['Inter']">${mensualite.toFixed(2)} €</td>
                    <td class="font-['Inter']">${capitalRembourse.toFixed(2)} €</td>
                    <td class="font-['Inter']">${interetsMois.toFixed(2)} €</td>
                    <td class="font-['Inter']">${Math.max(0, capitalRestant).toFixed(2)} €</td>
                `;
                tbody.appendChild(row);
            }

            // Ajout de la ligne de total
            const totalRow = document.createElement('tr');
            totalRow.className = 'font-bold bg-[#A0B2B8] text-[#003A70]';
            totalRow.innerHTML = `
                <td colspan="2" class="font-['Inter']">Total</td>
                <td class="font-['Inter']">${(mensualite * duree).toFixed(2)} €</td>
                <td class="font-['Inter']">${montant.toFixed(2)} €</td>
                <td class="font-['Inter']">${totalInterets.toFixed(2)} €</td>
                <td class="font-['Inter']">-</td>
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
                        backgroundColor: ['#003A70', '#007CBA'],
                        /* Dark Blue, Light Blue */
                        borderColor: ['#F5F6F7', '#F5F6F7'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Inter',
                                    size: 14
                                },
                                color: '#101820'
                            }
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
            const tabContents = document.getElementsByClassName('tab-content');
            for (let i = 0; i < tabContents.length; i++) {
                tabContents[i].classList.remove('active');
            }
            const tabs = document.getElementsByClassName('tab');
            for (let i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove('active');
            }
            document.getElementById(tabName).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function exportToPDF() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();
            const simulationContainer = document.getElementById('simulationContainer');

            html2canvas(simulationContainer, {
                scale: 2
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgProps = doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                doc.save('simulation_pret.pdf');
            });
        }

        document.getElementById('loanForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

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

            data.montant_remboursement_par_mois = mensualite.toFixed(2);
            data.montant_total_remboursement = totalRemboursement.toFixed(2);
            data.status = 'cree';

            alert('Demande de prêt soumise avec succès!\nMensualité: ' + mensualite.toFixed(2) + '€');
        });
    </script>
</body>

</html>