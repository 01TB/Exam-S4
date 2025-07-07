<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Gestion des types de prêts</title>
    <!-- Tailwind CSS and DaisyUI CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- Google Fonts: Playfair Display, Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Heroicons CDN -->
    <script src="https://unpkg.com/heroicons@2.1.1/dist/heroicons.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F6F7;
            /* Off-White */
            color: #101820;
            /* Near Black */
        }

        h1,
        h2 {
            font-family: 'Playfair Display', serif;
            color: #003A70;
            /* Dark Blue */
        }

        .card,
        .table-container {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover,
        .table-container:hover {
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

        .success,
        .error {
            display: none;
            padding: 1rem;
            border-radius: 0.5rem;
            animation: fadeIn 0.5s ease-in;
        }

        .success {
            background-color: #007CBA;
            /* Light Blue */
            color: #F5F6F7;
            /* Off-White */
        }

        .error {
            background-color: #A0B2B8;
            /* Light Gray */
            color: #101820;
            /* Near Black */
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
                        <li><a href="/EXAM-S4/public/finance/finance.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Accueil</a></li>
                        <li><a href="/EXAM-S4/public/finance/depot.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Depot</a></li>
                        <li><a href="/EXAM-S4/public/finance/interet.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Interet</a></li>
                        <li><a href="/EXAM-S4/public/finance/type_pret.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Type pret</a></li>
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
                <span class="text-[#007CBA] font-['Inter']">Administration</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Gestion des types de prêts</h2>
        <form id="loanTypeForm" class="card bg-[#F5F6F7] p-6 shadow-lg rounded-lg mb-8 fade-in">
            <input type="hidden" id="id" name="id">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="nom">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Nom du type de prêt</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </label>
                    <input type="text" id="nom" name="nom" placeholder="Nom du type de prêt" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
                <div class="form-control">
                    <label class="label" for="montant_min">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Montant minimum (€)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </label>
                    <input type="number" id="montant_min" name="montant_min" placeholder="Montant minimum" step="0.01" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="montant_max">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Montant maximum (€)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </label>
                    <input type="number" id="montant_max" name="montant_max" placeholder="Montant maximum" step="0.01" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
                <div class="form-control">
                    <label class="label" for="duree_remboursement_min">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Durée min (mois)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <input type="number" id="duree_remboursement_min" name="duree_remboursement_min" placeholder="Durée min (mois)" step="1" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="duree_remboursement_max">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Durée max (mois)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <input type="number" id="duree_remboursement_max" name="duree_remboursement_max" placeholder="Durée max (mois)" step="1" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
                <div class="form-control">
                    <label class="label" for="taux">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Taux d'intérêt (%)</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </label>
                    <input type="number" id="taux" name="taux" placeholder="Taux d'intérêt (%)" step="0.01" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
            </div>
            <button type="button" onclick="ajouterOuModifierTypePret()" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter / Modifier
            </button>
            <p class="success mt-4">Type de prêt enregistré avec succès !</p>
            <p class="error mt-4">Erreur lors de l'enregistrement</p>
        </form>

        <!-- Loan Types Table -->
        <div class="table-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <div class="overflow-x-auto">
                <table id="table-types-pret" class="table w-full border-collapse">
                    <thead>
                        <tr class="bg-[#A0B2B8] text-[#003A70]">
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    ID
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Nom
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Montant Min
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Montant Max
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Durée Min
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Durée Max
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Taux
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Actions
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>
    <script src="../js/ajax.js"></script>

    <script>
        function chargerTypesPret() {
            ajax("GET", "/types_pret", null, (data) => {
                const tbody = document.querySelector("#table-types-pret tbody");
                tbody.innerHTML = "";
                data.forEach((t) => {
                    const tr = document.createElement("tr");
                    tr.className = "hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors";
                    tr.innerHTML = `
                        <td class="font-['Inter']">${t.id}</td>
                        <td class="font-['Inter']">${t.nom}</td>
                        <td class="font-['Inter']">${t.montant_min}</td>
                        <td class="font-['Inter']">${t.montant_max}</td>
                        <td class="font-['Inter']">${t.duree_remboursement_min}</td>
                        <td class="font-['Inter']">${t.duree_remboursement_max}</td>
                        <td class="font-['Inter']">${t.taux}</td>
                        <td>
                            <button class="btn btn-ghost btn-sm text-[#007CBA] hover:bg-[#A0B2B8]" onclick='remplirFormulaireTypePret(${JSON.stringify(t)})'>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </button>
                            <button class="btn btn-ghost btn-sm text-[#007CBA] hover:bg-[#A0B2B8]" onclick='supprimerTypePret(${t.id})'>
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }, (error) => {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = `Erreur: ${error}`;
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
            });
        }

        function ajouterOuModifierTypePret() {
            const id = document.getElementById("id").value;
            const nom = document.getElementById("nom").value;
            const montant_min = document.getElementById("montant_min").value;
            const montant_max = document.getElementById("montant_max").value;
            const duree_remboursement_min = document.getElementById("duree_remboursement_min").value;
            const duree_remboursement_max = document.getElementById("duree_remboursement_max").value;
            const taux = document.getElementById("taux").value;

            if (!nom || !montant_min || !montant_max || !duree_remboursement_min || !duree_remboursement_max || !taux) {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'Veuillez remplir tous les champs obligatoires';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                return;
            }

            const data = `nom=${encodeURIComponent(nom)}&montant_min=${montant_min}&montant_max=${montant_max}&duree_remboursement_min=${duree_remboursement_min}&duree_remboursement_max=${duree_remboursement_max}&taux=${taux}`;

            if (id) {
                ajax("POST", `/types_pret/${id}`, data, () => {
                    resetFormTypePret();
                    chargerTypesPret();
                    document.querySelector('.success').style.display = 'block';
                    setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
                }, (error) => {
                    document.querySelector('.error').style.display = 'block';
                    document.querySelector('.error').textContent = `Erreur: ${error}`;
                    setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                });
            } else {
                ajax("POST", "/types_pret", data, () => {
                    resetFormTypePret();
                    chargerTypesPret();
                    document.querySelector('.success').style.display = 'block';
                    setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
                }, (error) => {
                    document.querySelector('.error').style.display = 'block';
                    document.querySelector('.error').textContent = `Erreur: ${error}`;
                    setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                });
            }
        }

        function remplirFormulaireTypePret(t) {
            document.getElementById("id").value = t.id;
            document.getElementById("nom").value = t.nom;
            document.getElementById("montant_min").value = t.montant_min;
            document.getElementById("montant_max").value = t.montant_max;
            document.getElementById("duree_remboursement_min").value = t.duree_remboursement_min;
            document.getElementById("duree_remboursement_max").value = t.duree_remboursement_max;
            document.getElementById("taux").value = t.taux;
        }

        function supprimerTypePret(id) {
            if (confirm("Supprimer ce type de prêt ?")) {
                ajax("DELETE", `/types_pret/${id}`, null, () => {
                    chargerTypesPret();
                }, (error) => {
                    document.querySelector('.error').style.display = 'block';
                    document.querySelector('.error').textContent = `Erreur: ${error}`;
                    setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                });
            }
        }

        function resetFormTypePret() {
            document.getElementById("id").value = "";
            document.getElementById("nom").value = "";
            document.getElementById("montant_min").value = "";
            document.getElementById("montant_max").value = "";
            document.getElementById("duree_remboursement_min").value = "";
            document.getElementById("duree_remboursement_max").value = "";
            document.getElementById("taux").value = "";
        }

        chargerTypesPret();
    </script>
</body>

</html>