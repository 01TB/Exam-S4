<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Validation des prêts</title>
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
                        <li><a href="/EXAM-S4/public/finance/finance.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Accueil</a></li>
                        <li><a href="/EXAM-S4/public/finance/depot.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Depot</a></li>
                        <li><a href="/EXAM-S4/public/finance/interet.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Interet</a></li>
                        <li><a href="/EXAM-S4/public/finance/type_pret.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Type pret</a></li>
                        <li><a href="/EXAM-S4/public/finance/validation_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Validation Prêts</a></li>
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
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-[#A0B2B8] rounded-box w-52">
                    <li><a href="/EXAM-S4/public/finance/finance.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Accueil</a></li>
                    <li><a href="/EXAM-S4/public/finance/depot.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Depot</a></li>
                    <li><a href="/EXAM-S4/public/finance/interet.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Interet</a></li>
                    <li><a href="/EXAM-S4/public/finance/type_pret.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Type pret</a></li>
                    <li><a href="/EXAM-S4/public/finance/validation_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Validation Prêts</a></li>
                    <li><a href="/EXAM-S4/public/login.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Déconnexion</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <span class="text-[#007CBA] font-['Inter']">Validation</span>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Validation des prêts en cours</h2>
        <div class="card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <p class="success">Action effectuée avec succès !</p>
            <p class="error">Erreur lors de l'action</p>
            <div class="overflow-x-auto">
                <table class="table w-full border-collapse">
                    <thead>
                        <tr class="bg-[#A0B2B8] text-[#003A70]">
                            <th class="font-['Playfair_Display']">ID</th>
                            <th class="font-['Playfair_Display']">Client</th>
                            <th class="font-['Playfair_Display']">Type de prêt</th>
                            <th class="font-['Playfair_Display']">Montant (€)</th>
                            <th class="font-['Playfair_Display']">Durée (mois)</th>
                            <th class="font-['Playfair_Display']">Taux (%)</th>
                            <th class="font-['Playfair_Display']">Date de demande</th>
                            <th class="font-['Playfair_Display']">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="loanTableBody"></tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>

    <script src="../js/ajax.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userId = 1;
            const today = new Date().toISOString().split('T')[0];
            const tableBody = document.getElementById('loanTableBody');

            // Fetch pending loans
            ajax('GET', '/pret/enCours', null, (response) => {
                tableBody.innerHTML = '';
                console.log(response);
                response.forEach(loan => {
                    const row = document.createElement('tr');
                    row.className = 'hover:bg-[#007CBA] hover:text-[#F5F6F7]';
                    row.innerHTML = `
                        <td class="font-['Inter']">${loan.id}</td>
                        <td class="font-['Inter']">${loan.id_client}</td>
                        <td class="font-['Inter']">${loan.id_type_pret}</td>
                        <td class="font-['Inter']">${loan.montant_pret} €</td>
                        <td class="font-['Inter']">${loan.duree_remboursement}</td>
                        <td class="font-['Inter']">${loan.taux} %</td>
                        <td class="font-['Inter']">${loan.date_demande}</td>
                        <td class="font-['Inter']">
                            <button class="btn btn-sm bg-[#007CBA] text-[#F5F6F7] hover:bg-[#003A70] validate-btn" data-id="${loan.id}">Valider</button>
                            <button class="btn btn-sm bg-[#A0B2B8] text-[#101820] hover:bg-[#003A70] hover:text-[#F5F6F7] reject-btn" data-id="${loan.id}">Refuser</button>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                // Add event listeners for buttons
                document.querySelectorAll('.validate-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const loanId = this.getAttribute('data-id');
                        const data = {
                            id_pret: loanId,
                            id_validateur: userId,
                            date_actuelle: today
                        };
                        ajax('POST', '/pret/valide', JSON.stringify(data), (response) => {
                            document.querySelector('.success').style.display = 'block';
                            document.querySelector('.success').textContent = `Prêt ${loanId} validé avec succès !`;
                            setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
                            this.closest('tr').remove();
                        }, (error) => {
                            let errorMessage = 'Erreur lors de la validation';
                            try {
                                const errorObj = JSON.parse(error);
                                errorMessage = errorObj.error || errorMessage;
                            } catch (e) {
                                // Use raw error if not JSON
                            }
                            document.querySelector('.error').style.display = 'block';
                            document.querySelector('.error').textContent = errorMessage;
                            setTimeout(() => document.querySelector('.error').style.display = 'none', 4000);
                        });
                    });
                });

                document.querySelectorAll('.reject-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const loanId = this.getAttribute('data-id');
                        const data = {
                            id_pret: loanId,
                            id_validateur: userId
                        };
                        ajax('POST', '/pret/refuse', JSON.stringify(data), (response) => {
                            document.querySelector('.success').style.display = 'block';
                            document.querySelector('.success').textContent = `Prêt ${loanId} refusé avec succès !`;
                            setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
                            this.closest('tr').remove();
                        }, (error) => {
                            let errorMessage = 'Erreur lors du refus';
                            try {
                                const errorObj = JSON.parse(error);
                                errorMessage = errorObj.error || errorMessage;
                            } catch (e) {
                                // Use raw error if not JSON
                            }
                            document.querySelector('.error').style.display = 'block';
                            document.querySelector('.error').textContent = errorMessage;
                            setTimeout(() => document.querySelector('.error').style.display = 'none', 4000);
                        });
                    });
                });
            }, (error) => {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'Erreur lors du chargement des prêts';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 4000);
            });
        });
    </script>
</body>

</html>