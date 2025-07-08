<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Réception</title>
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
            background-color: #000000;
            /* Off-White */
            color: #ffffff;
            /* Near Black */
        }

        h1,
        h2 {
            font-family: 'Playfair Display', serif;
            color: #003A70;
            /* Dark Blue */
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
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
                        <li><a href="/EXAM-S4/public/reception/reception.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Accueil</a></li>
                        <li><a href="/EXAM-S4/public/reception/inserer.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Insérer un prêt</a></li>
                        <li><a href="/EXAM-S4/public/reception/liste_prets.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Liste des prêts</a></li>
                        <li><a href="/EXAM-S4/public/login.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Déconnexion</a></li>
                        <li><a href="/EXAM-S4/public/reception/liste_formulaire_prets.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">liste_formulaire_prets</a></li>
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
                    <li><a href="/EXAM-S4/public/reception/reception.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Accueil</a></li>
                    <li><a href="/EXAM-S4/public/reception/inserer.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Insérer un prêt</a></li>
                    <li><a href="/EXAM-S4/public/reception/liste_prets.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Liste des prêts</a></li>
                    <li><a href="/EXAM-S4/public/login.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">Déconnexion</a></li>
                    <li><a href="/EXAM-S4/public/reception/liste_formulaire_prets.php" class="text-[#ffffff] hover:bg-[#007CBA] hover:text-[#ffffff]">liste_formulaire_prets</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <span class="text-[#007CBA] font-['Inter']">Réception</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-['Playfair_Display'] mb-6 fade-in">Tableau de bord - Réception</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Card for Insérer un prêt -->
            <a href="/EXAM-S4/public/reception/inserer.php" class="card bg-[#000000] rounded-lg shadow-lg p-6 flex items-center space-x-4 fade-in">
                <svg class="h-12 w-12 text-[#007CBA]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-['Playfair_Display'] text-[#003A70]">Insérer un prêt</h3>
                    <p class="text-[#ffffff] font-['Inter']">Créer une nouvelle demande de prêt pour un client.</p>
                </div>
                <img src="https://via.placeholder.com/100x100?text=Prêt" alt="Prêt Icon" class="ml-auto rounded-full">
            </a>
            <!-- Card for Liste des prêts -->
            <a href="/EXAM-S4/public/reception/liste_prets.php" class="card bg-[#000000] rounded-lg shadow-lg p-6 flex items-center space-x-4 fade-in">
                <svg class="h-12 w-12 text-[#007CBA]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14"></path>
                </svg>
                <div>
                    <h3 class="text-xl font-['Playfair_Display'] text-[#003A70]">Liste des prêts</h3>
                    <p class="text-[#ffffff] font-['Inter']">Voir toutes les demandes de prêts enregistrées.</p>
                </div>
                <img src="https://via.placeholder.com/100x100?text=Liste" alt="Liste Icon" class="ml-auto rounded-full">
            </a>
        </div>

        <!-- Last 5 Loans Table -->
        <h2 class="text-2xl font-['Playfair_Display'] mb-4 fade-in">5 derniers prêts</h2>
        <div class="overflow-x-auto">
            <table class="table w-full border-collapse">
                <thead>
                    <tr class="bg-[#A0B2B8] text-[#003A70]">
                        <th class="font-['Playfair_Display']">ID Prêt</th>
                        <th class="font-['Playfair_Display']">Montant</th>
                        <th class="font-['Playfair_Display']">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-[#007CBA] hover:text-[#ffffff] transition-colors">
                        <td class="font-['Inter']">1</td>
                        <td class="font-['Inter']">5000</td>
                        <td class="font-['Inter'] text-[#007CBA]">Approuvé</td>
                    </tr>
                    <tr class="hover:bg-[#007CBA] hover:text-[#ffffff] transition-colors">
                        <td class="font-['Inter']">2</td>
                        <td class="font-['Inter']">3000</td>
                        <td class="font-['Inter'] text-[#A0B2B8]">En attente</td>
                    </tr>
                    <tr class="hover:bg-[#007CBA] hover:text-[#ffffff] transition-colors">
                        <td class="font-['Inter']">3</td>
                        <td class="font-['Inter']">7000</td>
                        <td class="font-['Inter'] text-[#A0B2B8]">Rejeté</td>
                    </tr>
                    <tr class="hover:bg-[#007CBA] hover:text-[#ffffff] transition-colors">
                        <td class="font-['Inter']">4</td>
                        <td class="font-['Inter']">2000</td>
                        <td class="font-['Inter'] text-[#007CBA]">Approuvé</td>
                    </tr>
                    <tr class="hover:bg-[#007CBA] hover:text-[#ffffff] transition-colors">
                        <td class="font-['Inter']">5</td>
                        <td class="font-['Inter']">4000</td>
                        <td class="font-['Inter'] text-[#A0B2B8]">En attente</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#000000] text-[#ffffff] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>
</body>

</html>