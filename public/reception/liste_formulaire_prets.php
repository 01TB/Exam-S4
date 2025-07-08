<?php
session_start();
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {
    header("Location: /EXAM-S4/public/login.php");
    exit();
}
// Static clients for dropdown (replace with DB query later if needed)
$clients = [
    ['id' => 1, 'nom' => 'Jean Dupont'],
    ['id' => 2, 'nom' => 'Marie Curie'],
];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Liste des formulaires de prêt</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/heroicons@2.1.1/dist/heroicons.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F6F7;
            color: #101820;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: #003A70;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 58, 112, 0.1);
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

        .success,
        .error {
            display: none;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            font-family: 'Inter', sans-serif;
        }

        .success {
            background-color: #007CBA;
            color: #F5F6F7;
        }

        .error {
            background-color: #A0B2B8;
            color: #101820;
        }

        .loader {
            display: none;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
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
                        <li><a href="/EXAM-S4/public/reception/liste_formulaire_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Formulaires de prêts</a></li>
                        <li><a href="/EXAM-S4/public/validation/validation_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Validation des prêts</a></li>
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
                    <li><a href="/EXAM-S4/public/reception/liste_formulaire_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Formulaires de prêts</a></li>
                    <li><a href="/EXAM-S4/public/validation/validation_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Validation des prêts</a></li>
                    <li><a href="/EXAM-S4/public/login.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Déconnexion</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <span class="text-[#007CBA] font-['Inter']">Formulaires de prêts</span>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Formulaires de prêts</h2>
        <div class="card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <p class="success">Prêts sélectionnés pour comparaison !</p>
            <p class="error">Erreur lors de la sélection des prêts</p>
            <div class="loader">
                <span class="loading loading-spinner text-[#007CBA]"></span>
                <span class="ml-2 text-[#003A70] font-['Inter']">Chargement...</span>
            </div>
            <div id="forms-container"></div>
            <div class="flex gap-4 mt-4">
                <button onclick="addLoanForm()" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Ajouter un formulaire
                </button>
                <button onclick="compareSelectedLoans()" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m-12 4h12m0 0l-4 4m4-4l-4-4"></path>
                    </svg>
                    Comparer
                </button>
            </div>
        </div>
    </main>

    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>

    <script>
        const userId = <?php echo json_encode((int)$_SESSION['user']['id']); ?>;
        const clients = <?php echo json_encode($clients); ?>;
        const loanTypes = [{
                id: 1,
                nom: 'Prêt personnel',
                montant_min: 1000,
                montant_max: 50000,
                duree_remboursement_min: 6,
                duree_remboursement_max: 60,
                taux: 5.00
            },
            {
                id: 2,
                nom: 'Prêt automobile',
                montant_min: 5000,
                montant_max: 75000,
                duree_remboursement_min: 12,
                duree_remboursement_max: 84,
                taux: 7.00
            },
            {
                id: 3,
                nom: 'Prêt immobilier',
                montant_min: 50000,
                montant_max: 500000,
                duree_remboursement_min: 60,
                duree_remboursement_max: 360,
                taux: 3.50
            }
        ];
        let formCount = 0;

        document.addEventListener('DOMContentLoaded', function() {
            addLoanForm(); // Add the first form on load
        });

        function addLoanForm() {
            formCount++;
            const container = document.getElementById('forms-container');
            const formDiv = document.createElement('div');
            formDiv.className = 'form-card card bg-[#F5F6F7] p-6 shadow-lg rounded-lg mt-4';
            formDiv.id = `form-${formCount}`;
            formDiv.innerHTML = `
                <div class="flex items-center mb-4">
                    <input type="checkbox" id="select-${formCount}" class="checkbox checkbox-primary mr-2" onchange="handleCheckboxChange(${formCount})">
                    <h3 class="text-xl font-['Playfair_Display'] text-[#003A70]">Formulaire de prêt ${formCount}</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label" for="id_client-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Client</span>
                        </label>
                        <select name="id_client" id="id_client-${formCount}" class="select select-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                            <option value="">Sélectionner un client</option>
                            ${clients.map(client => `<option value="${client.id}">${client.nom}</option>`).join('')}
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label" for="id_type_pret-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Type de prêt</span>
                        </label>
                        <select name="id_type_pret" id="id_type_pret-${formCount}" class="select select-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                            <option value="">Sélectionner un type</option>
                            ${loanTypes.map(type => `
                                <option value="${type.id}" 
                                        data-taux="${type.taux}" 
                                        data-montantmin="${type.montant_min}" 
                                        data-montantmax="${type.montant_max}" 
                                        data-dureemin="${type.duree_remboursement_min}" 
                                        data-dureemax="${type.duree_remboursement_max}">
                                    ${type.nom} (${type.taux}%)
                                </option>
                            `).join('')}
                        </select>
                    </div>
                    <div class="form-control">
                        <label class="label" for="montant_pret-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Montant (€)</span>
                        </label>
                        <input type="number" name="montant_pret" id="montant_pret-${formCount}" step="0.01" min="0" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                    </div>
                    <div class="form-control">
                        <label class="label" for="duree_remboursement-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Durée (mois)</span>
                        </label>
                        <input type="number" name="duree_remboursement" id="duree_remboursement-${formCount}" step="1" min="0" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                    </div>
                    <div class="form-control">
                        <label class="label" for="taux-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Taux (%)</span>
                        </label>
                        <input type="number" name="taux" id="taux-${formCount}" step="0.01" min="0" max="20" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required readonly>
                    </div>
                    <div class="form-control">
                        <label class="label" for="assurance-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Assurance (€)</span>
                        </label>
                        <input type="number" name="assurance" id="assurance-${formCount}" step="0.01" min="0" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" value="0.00" required>
                    </div>
                    <div class="form-control">
                        <label class="label" for="date_demande-${formCount}">
                            <span class="label-text text-[#101820] font-['Playfair_Display']">Date de demande</span>
                        </label>
                        <input type="date" name="date_demande" id="date_demande-${formCount}" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" value="2025-07-08" required>
                    </div>
                </div>
                <div class="mt-4">
                    <h4 class="text-lg font-['Playfair_Display'] text-[#003A70]">Simulation</h4>
                    <table class="table w-full border-collapse">
                        <thead>
                            <tr class="bg-[#A0B2B8] text-[#003A70]">
                                <th class="font-['Playfair_Display']">Mois</th>
                                <th class="font-['Playfair_Display']">Date</th>
                                <th class="font-['Playfair_Display']">Mensualité (€)</th>
                                <th class="font-['Playfair_Display']">Capital (€)</th>
                                <th class="font-['Playfair_Display']">Intérêt (€)</th>
                                <th class="font-['Playfair_Display']">Capital restant (€)</th>
                            </tr>
                        </thead>
                        <tbody id="amortization-table-${formCount}"></tbody>
                    </table>
                </div>
            `;
            container.appendChild(formDiv);

            // Add event listener for loan type selection
            document.getElementById(`id_type_pret-${formCount}`).addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const formId = formCount;
                if (selectedOption.value) {
                    document.getElementById(`taux-${formId}`).value = selectedOption.getAttribute('data-taux');
                    document.getElementById(`montant_pret-${formId}`).min = selectedOption.getAttribute('data-montantmin');
                    document.getElementById(`montant_pret-${formId}`).max = selectedOption.getAttribute('data-montantmax');
                    document.getElementById(`duree_remboursement-${formId}`).min = selectedOption.getAttribute('data-dureemin');
                    document.getElementById(`duree_remboursement-${formId}`).max = selectedOption.getAttribute('data-dureemax');
                    updateAmortizationTable(formId);
                } else {
                    document.getElementById(`taux-${formId}`).value = '';
                    document.getElementById(`montant_pret-${formId}`).removeAttribute('min');
                    document.getElementById(`montant_pret-${formId}`).removeAttribute('max');
                    document.getElementById(`duree_remboursement-${formId}`).removeAttribute('min');
                    document.getElementById(`duree_remboursement-${formId}`).removeAttribute('max');
                    document.getElementById(`amortization-table-${formId}`).innerHTML = '';
                }
            });

            // Add event listeners for real-time simulation updates
            ['montant_pret', 'duree_remboursement', 'assurance'].forEach(field => {
                document.getElementById(`${field}-${formCount}`).addEventListener('input', () => updateAmortizationTable(formCount));
            });
        }

        function handleCheckboxChange(formId) {
            const checkboxes = document.querySelectorAll('.checkbox');
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            if (checkedCount > 2) {
                document.getElementById(`select-${formId}`).checked = false;
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'Vous ne pouvez sélectionner que deux prêts pour la comparaison.';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
            }
        }

        function calculateMonthlyPayment(montantPret, tauxAnnuel, duree) {
            const tauxMensuel = tauxAnnuel / 12 / 100;
            if (tauxMensuel === 0) {
                return montantPret / duree;
            }
            return (montantPret * tauxMensuel * Math.pow(1 + tauxMensuel, duree)) / (Math.pow(1 + tauxMensuel, duree) - 1);
        }

        function updateAmortizationTable(formId) {
            const montantPret = parseFloat(document.getElementById(`montant_pret-${formId}`).value) || 0;
            const duree = parseInt(document.getElementById(`duree_remboursement-${formId}`).value) || 0;
            const taux = parseFloat(document.getElementById(`taux-${formId}`).value) || 0;
            const dateDemande = document.getElementById(`date_demande-${formId}`).value;
            const tableBody = document.getElementById(`amortization-table-${formId}`);
            tableBody.innerHTML = '';

            if (!montantPret || !duree || !taux || !dateDemande) {
                return;
            }

            const selectedOption = document.getElementById(`id_type_pret-${formId}`).options[document.getElementById(`id_type_pret-${formId}`).selectedIndex];
            const montantMin = parseFloat(selectedOption.getAttribute('data-montantmin'));
            const montantMax = parseFloat(selectedOption.getAttribute('data-montantmax'));
            const dureeMin = parseInt(selectedOption.getAttribute('data-dureemin'));
            const dureeMax = parseInt(selectedOption.getAttribute('data-dureemax'));

            if (montantPret < montantMin || montantPret > montantMax || duree < dureeMin || duree > dureeMax) {
                return;
            }

            const tauxMensuel = taux / 12 / 100;
            const mensualite = calculateMonthlyPayment(montantPret, taux, duree);
            let capitalRestant = montantPret;
            const date = new Date(dateDemande);

            for (let mois = 1; mois <= duree; mois++) {
                date.setMonth(date.getMonth() + 1);
                const interetMensuel = capitalRestant * tauxMensuel;
                let capitalRembourse = mensualite - interetMensuel;

                if (mois === duree) {
                    capitalRembourse = capitalRestant;
                    mensualite = capitalRembourse + interetMensuel;
                }

                const row = document.createElement('tr');
                row.className = 'hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors';
                row.innerHTML = `
                    <td class="font-['Inter']">${mois}</td>
                    <td class="font-['Inter']">${date.toISOString().split('T')[0]}</td>
                    <td class="font-['Inter']">${mensualite.toFixed(2).replace('.', ',')} €</td>
                    <td class="font-['Inter']">${capitalRembourse.toFixed(2).replace('.', ',')} €</td>
                    <td class="font-['Inter']">${interetMensuel.toFixed(2).replace('.', ',')} €</td>
                    <td class="font-['Inter']">${(capitalRestant - capitalRembourse).toFixed(2).replace('.', ',')} €</td>
                `;
                tableBody.appendChild(row);
                capitalRestant -= capitalRembourse;
            }
        }

        function compareSelectedLoans() {
            const checkboxes = document.querySelectorAll('.checkbox:checked');
            if (checkboxes.length !== 2) {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'Veuillez sélectionner exactement deux prêts pour la comparaison.';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                return;
            }

            const loans = [];
            checkboxes.forEach(cb => {
                const formId = cb.id.split('-')[1];
                const selectedOption = document.getElementById(`id_type_pret-${formId}`).options[document.getElementById(`id_type_pret-${formId}`).selectedIndex];
                const montantPret = parseFloat(document.getElementById(`montant_pret-${formId}`).value);
                const duree = parseInt(document.getElementById(`duree_remboursement-${formId}`).value);
                const taux = parseFloat(document.getElementById(`taux-${formId}`).value);
                const dateDemande = document.getElementById(`date_demande-${formId}`).value;

                if (!selectedOption.value || !montantPret || !duree || !taux || !dateDemande) {
                    document.querySelector('.error').style.display = 'block';
                    document.querySelector('.error').textContent = `Veuillez remplir tous les champs du formulaire ${formId}.`;
                    setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                    return;
                }

                const montantMin = parseFloat(selectedOption.getAttribute('data-montantmin'));
                const montantMax = parseFloat(selectedOption.getAttribute('data-montantmax'));
                const dureeMin = parseInt(selectedOption.getAttribute('data-dureemin'));
                const dureeMax = parseInt(selectedOption.getAttribute('data-dureemax'));

                if (montantPret < montantMin || montantPret > montantMax) {
                    document.querySelector('.error').style.display = 'block';
                    document.querySelector('.error').textContent = `Le montant du formulaire ${formId} doit être entre ${montantMin.toLocaleString('fr-FR', { minimumFractionDigits: 2 })} € et ${montantMax.toLocaleString('fr-FR', { minimumFractionDigits: 2 })} €.`;
                    setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                    return;
                }

                if (duree < dureeMin || duree > dureeMax) {
                    document.querySelector('.error').style.display = 'block';
                    document.querySelector('.error').textContent = `La durée du formulaire ${formId} doit être entre ${dureeMin} et ${dureeMax} mois.`;
                    setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                    return;
                }

                const loanData = {
                    id_type_pret: parseInt(selectedOption.value),
                    type_pret_nom: selectedOption.text.split(' (')[0],
                    montant_pret: montantPret,
                    duree_remboursement: duree,
                    taux: taux,
                    date_demande: dateDemande,
                    mensualite: calculateMonthlyPayment(montantPret, taux, duree)
                };

                // Calculate amortization schedule
                const tauxMensuel = taux / 12 / 100;
                let capitalRestant = montantPret;
                const date = new Date(dateDemande);
                const amortization = [];
                for (let mois = 1; mois <= duree; mois++) {
                    date.setMonth(date.getMonth() + 1);
                    const interetMensuel = capitalRestant * tauxMensuel;
                    let capitalRembourse = loanData.mensualite - interetMensuel;
                    if (mois === duree) {
                        capitalRembourse = capitalRestant;
                        loanData.mensualite = capitalRembourse + interetMensuel;
                    }
                    amortization.push({
                        mois: mois,
                        date: date.toISOString().split('T')[0],
                        mensualite: loanData.mensualite.toFixed(2),
                        capital: capitalRembourse.toFixed(2),
                        interet: interetMensuel.toFixed(2),
                        capital_restant: (capitalRestant - capitalRembourse).toFixed(2)
                    });
                    capitalRestant -= capitalRembourse;
                }
                loanData.amortization = amortization;
                loans.push(loanData);
            });

            if (loans.length === 2) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/EXAM-S4/public/reception/comparer_prets.php';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'loans';
                input.value = JSON.stringify(loans);
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>

</html>