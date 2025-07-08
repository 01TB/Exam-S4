<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Administration</title>
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
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
            color: #003A70;
            /* Dark Blue */
        }

        .table-container {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

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
                        <li><a href="/EXAM-S4/public/finance/validation_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">validation_pret</a></li>
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
                    <li><a href="/EXAM-S4/public/finance/finance.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Accueil</a></li>
                    <li><a href="/EXAM-S4/public/finance/inserer.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Insérer un prêt</a></li>
                    <li><a href="/EXAM-S4/public/finance/liste_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7] rounded">Liste des prêts</a></li>
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
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Tableau de bord - Administration</h2>

        <!-- Derniers dépôts -->
        <h3 class="text-2xl font-['Playfair_Display'] text-[#003A70] mb-4 fade-in">Derniers dépôts</h3>
        <div class="table-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <div class="overflow-x-auto">
                <table class="table w-full border-collapse">
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
                                    Investisseur
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Montant
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Date
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Description
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors">
                            <td class="font-['Inter']">1</td>
                            <td class="font-['Inter']">Jean Dupont</td>
                            <td class="font-['Inter']">10000.00</td>
                            <td class="font-['Inter']">2025-07-01</td>
                            <td class="font-['Inter']">Investissement initial</td>
                        </tr>
                        <tr class="hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors">
                            <td class="font-['Inter']">2</td>
                            <td class="font-['Inter']">Marie Durand</td>
                            <td class="font-['Inter']">5000.00</td>
                            <td class="font-['Inter']">2025-07-02</td>
                            <td class="font-['Inter']">Fonds de réserve</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Types de prêts -->
        <h3 class="text-2xl font-['Playfair_Display'] text-[#003A70] mb-4 mt-8 fade-in">Types de prêts</h3>
        <div class="table-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <div class="overflow-x-auto">
                <table class="table w-full border-collapse">
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
                                    Durée Min (mois)
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Durée Max (mois)
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Taux (%)
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors">
                            <td class="font-['Inter']">1</td>
                            <td class="font-['Inter']">Prêt personnel</td>
                            <td class="font-['Inter']">1000.00</td>
                            <td class="font-['Inter']">5000.00</td>
                            <td class="font-['Inter']">6</td>
                            <td class="font-['Inter']">24</td>
                            <td class="font-['Inter']">5.00</td>
                        </tr>
                        <tr class="hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors">
                            <td class="font-['Inter']">2</td>
                            <td class="font-['Inter']">Prêt auto</td>
                            <td class="font-['Inter']">5000.00</td>
                            <td class="font-['Inter']">20000.00</td>
                            <td class="font-['Inter']">12</td>
                            <td class="font-['Inter']">60</td>
                            <td class="font-['Inter']">7.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>
</body>

</html>