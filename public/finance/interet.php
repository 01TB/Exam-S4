<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Tableau des Intérêts</title>
    <!-- Tailwind CSS and DaisyUI CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <!-- Google Fonts: Playfair Display, Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Heroicons CDN -->
    <script src="https://unpkg.com/heroicons@2.1.1/dist/heroicons.min.js"></script>
    <!-- D3.js CDN -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
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
        .table-container,
        .graph-container {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover,
        .table-container:hover,
        .graph-container:hover {
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

        .tooltip {
            position: absolute;
            background-color: #101820;
            color: #F5F6F7;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
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
                <span class="text-[#007CBA] font-['Inter']">Administration</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Tableau des Intérêts</h2>
        <div class="card bg-[#F5F6F7] p-6 shadow-lg rounded-lg mb-8 fade-in">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="form-control">
                    <label class="label" for="mois_debut">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Mois début</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <select id="mois_debut" name="mois_debut" class="select select-bordered border-[#A0B2B8] focus:border-[#007CBA]">
                        <option value="">Tous</option>
                        <option value="1">Janvier</option>
                        <option value="2">Février</option>
                        <option value="3">Mars</option>
                        <option value="4">Avril</option>
                        <option value="5">Mai</option>
                        <option value="6">Juin</option>
                        <option value="7">Juillet</option>
                        <option value="8">Août</option>
                        <option value="9">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label" for="mois_fin">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Mois fin</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <select id="mois_fin" name="mois_fin" class="select select-bordered border-[#A0B2B8] focus:border-[#007CBA]">
                        <option value="">Tous</option>
                        <option value="1">Janvier</option>
                        <option value="2">Février</option>
                        <option value="3">Mars</option>
                        <option value="4">Avril</option>
                        <option value="5">Mai</option>
                        <option value="6">Juin</option>
                        <option value="7">Juillet</option>
                        <option value="8">Août</option>
                        <option value="9">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select>
                </div>
                <div class="form-control">
                    <label class="label" for="annee_debut">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Année début</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <input type="number" id="annee_debut" name="annee_debut" step="1" min="1900" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
                <div class="form-control">
                    <label class="label" for="annee_fin">
                        <span class="label-text text-[#101820] font-['Playfair_Display']">Année fin</span>
                        <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </label>
                    <input type="number" id="annee_fin" name="annee_fin" step="1" min="1900" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
                </div>
            </div>
            <div class="flex gap-4">
                <button onclick="chargerInterets()" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filtrer
                </button>
                <button onclick="reinitialiserFiltres()" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Réinitialiser
                </button>
            </div>
            <p class="error mt-4">Erreur lors du chargement des données</p>
        </div>

        <!-- Interests Table -->
        <div class="table-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg mb-8 fade-in">
            <div class="overflow-x-auto">
                <table id="table-interets" class="table w-full border-collapse">
                    <thead>
                        <tr class="bg-[#A0B2B8] text-[#003A70]">
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Mois
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Année
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7l3-3 3 3m0 6l-3 3-3-3"></path>
                                    </svg>
                                </div>
                            </th>
                            <th class="font-['Playfair_Display']">
                                <div class="flex items-center">
                                    Montant des intérêts
                                    <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- D3.js Graph -->
        <div class="graph-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <h3 class="text-xl font-['Playfair_Display'] text-[#003A70] mb-4">Visualisation des Intérêts</h3>
            <svg id="interest-graph" width="100%" height="400"></svg>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>

    <script src="../js/ajax.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const anneeActuelle = new Date().getFullYear();
            document.getElementById('annee_debut').value = anneeActuelle;
            document.getElementById('annee_fin').value = anneeActuelle;
            chargerInterets();
        });

        function chargerInterets() {
            const moisDebut = document.getElementById('mois_debut').value;
            const moisFin = document.getElementById('mois_fin').value;
            const anneeDebut = document.getElementById('annee_debut').value;
            const anneeFin = document.getElementById('annee_fin').value;

            if (anneeDebut && anneeFin && parseInt(anneeDebut) > parseInt(anneeFin)) {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = 'L\'année de début doit être inférieure ou égale à l\'année de fin';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
                return;
            }

            const params = new URLSearchParams();
            if (moisDebut) params.append('mois_debut', moisDebut);
            if (moisFin) params.append('mois_fin', moisFin);
            if (anneeDebut) params.append('annee_debut', anneeDebut);
            if (anneeFin) params.append('annee_fin', anneeFin);

            ajax("GET", `/interets?${params.toString()}`, null, (data) => {
                updateTable(data);
                updateGraph(data);
            }, (error) => {
                document.querySelector('.error').style.display = 'block';
                document.querySelector('.error').textContent = `Erreur: ${error}`;
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
            });
        }

        function updateTable(data) {
            const tbody = document.querySelector("#table-interets tbody");
            tbody.innerHTML = "";
            if (data.length === 0) {
                const tr = document.createElement("tr");
                tr.innerHTML = `<td colspan="3" class="font-['Inter'] text-center">Aucun résultat trouvé</td>`;
                tbody.appendChild(tr);
            } else {
                data.forEach(interet => {
                    const tr = document.createElement("tr");
                    tr.className = "hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors";
                    tr.innerHTML = `
                        <td class="font-['Inter']">${getNomMois(interet.mois)}</td>
                        <td class="font-['Inter']">${interet.annee}</td>
                        <td class="font-['Inter']">${formatMontant(interet.interet)} €</td>
                    `;
                    tbody.appendChild(tr);
                });
            }
        }

        function updateGraph(data) {
            const svg = d3.select("#interest-graph");
            svg.selectAll("*").remove();

            const margin = {
                top: 20,
                right: 30,
                bottom: 70,
                left: 60
            };
            const width = svg.node().clientWidth - margin.left - margin.right;
            const height = 400 - margin.top - margin.bottom;

            const g = svg.append("g").attr("transform", `translate(${margin.left},${margin.top})`);

            const x = d3.scaleBand()
                .domain(data.map(d => `${getNomMois(d.mois)} ${d.annee}`))
                .range([0, width])
                .padding(0.1);

            const y = d3.scaleLinear()
                .domain([0, d3.max(data, d => d.interet)])
                .nice()
                .range([height, 0]);

            g.append("g")
                .attr("class", "x-axis")
                .attr("transform", `translate(0,${height})`)
                .call(d3.axisBottom(x))
                .selectAll("text")
                .attr("transform", "rotate(-45)")
                .style("text-anchor", "end")
                .style("fill", "#101820")
                .style("font-family", "Inter, sans-serif");

            g.append("g")
                .attr("class", "y-axis")
                .call(d3.axisLeft(y).tickFormat(d => `${d} €`))
                .style("fill", "#101820")
                .style("font-family", "Inter, sans-serif");

            g.append("text")
                .attr("x", width / 2)
                .attr("y", height + margin.bottom - 10)
                .style("text-anchor", "middle")
                .style("fill", "#101820")
                .style("font-family", "Inter, sans-serif")
                .text("Mois et Année");

            g.append("text")
                .attr("transform", "rotate(-90)")
                .attr("x", -height / 2)
                .attr("y", -margin.left + 20)
                .style("text-anchor", "middle")
                .style("fill", "#101820")
                .style("font-family", "Inter, sans-serif")
                .text("Montant des Intérêts (€)");

            const tooltip = d3.select("body").append("div")
                .attr("class", "tooltip");

            g.selectAll(".bar")
                .data(data)
                .enter()
                .append("rect")
                .attr("class", "bar")
                .attr("x", d => x(`${getNomMois(d.mois)} ${d.annee}`))
                .attr("y", d => y(d.interet))
                .attr("width", x.bandwidth())
                .attr("height", d => height - y(d.interet))
                .attr("fill", "#007CBA")
                .on("mouseover", function(event, d) {
                    d3.select(this).attr("fill", "#003A70");
                    tooltip.style("opacity", 1)
                        .html(`${getNomMois(d.mois)} ${d.annee}: ${formatMontant(d.interet)} €`)
                        .style("left", (event.pageX + 10) + "px")
                        .style("top", (event.pageY - 28) + "px");
                })
                .on("mouseout", function() {
                    d3.select(this).attr("fill", "#007CBA");
                    tooltip.style("opacity", 0);
                });
        }

        function reinitialiserFiltres() {
            document.getElementById('mois_debut').value = '';
            document.getElementById('mois_fin').value = '';
            document.getElementById('annee_debut').value = new Date().getFullYear();
            document.getElementById('annee_fin').value = new Date().getFullYear();
            chargerInterets();
        }

        function getNomMois(numMois) {
            const mois = [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ];
            return mois[numMois - 1] || numMois;
        }

        function formatMontant(montant) {
            return parseFloat(montant).toFixed(2).replace('.', ',');
        }
    </script>
</body>

</html>