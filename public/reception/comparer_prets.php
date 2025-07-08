<?php
session_start();
if (!isset($_SESSION["user"]) || !isset($_SESSION["user"]["id"])) {
    header("Location: /EXAM-S4/public/login.php");
    exit();
}
$loans = isset($_POST['loans']) ? json_decode($_POST['loans'], true) : [];
if (count($loans) !== 2) {
    header("Location: /EXAM-S4/public/reception/liste_formulaire_prets.php");
    exit();
}
// Calculate total interest, total repaid, and cumulative interest for each loan
foreach ($loans as &$loan) {
    $totalInterest = 0;
    $cumulativeInterest = [];
    $runningSum = 0;
    foreach ($loan['amortization'] as $row) {
        $runningSum += floatval($row['interet']);
        $cumulativeInterest[] = $runningSum;
    }
    $loan['total_interest'] = $totalInterest;
    $loan['total_repaid'] = $loan['montant_pret'] + $totalInterest;
    $loan['cumulative_interest'] = $cumulativeInterest;
}
unset($loan);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPbank - Comparaison des prêts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/heroicons@2.1.1/dist/heroicons.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cytoscape/3.30.2/cytoscape.min.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
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

        .card,
        .table-container,
        .chart-container,
        .gantt-container {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover,
        .table-container:hover,
        .chart-container:hover,
        .gantt-container:hover {
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

        .chart-container {
            max-width: 400px;
            margin: 0 auto 2rem;
        }

        #cytoscapeGraph {
            width: 100%;
            height: 400px;
            border: 1px solid #A0B2B8;
            border-radius: 0.5rem;
        }

        #ganttChart {
            width: 100%;
            height: 300px;
            border: 1px solid #A0B2B8;
            border-radius: 0.5rem;
        }

        .gantt-container {
            margin-bottom: 2rem;
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
                        <li><a href="/EXAM-S4/public/login.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Déconnexion</a></li>
                        <li><a href="/EXAM-S4/public/reception/liste_formulaire_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">liste_formulaire_prets</a></li>
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
                    <li><a href="/EXAM-S4/public/reception/reception.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Accueil</a></li>
                    <li><a href="/EXAM-S4/public/reception/inserer.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Insérer un prêt</a></li>
                    <li><a href="/EXAM-S4/public/reception/liste_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Liste des prêts</a></li>
                    <li><a href="/EXAM-S4/public/login.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">Déconnexion</a></li>
                    <li><a href="/EXAM-S4/public/reception/liste_formulaire_prets.php" class="text-[#101820] hover:bg-[#007CBA] hover:text-[#F5F6F7]">liste_formulaire_prets</a></li>
                </ul>
            </div>
            <div class="navbar-end">
                <span class="text-[#007CBA] font-['Inter']">Comparaison des prêts</span>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-4 py-8 max-w-6xl">
        <h2 class="text-3xl font-['Playfair_Display'] text-[#003A70] mb-6 fade-in">Comparaison des prêts</h2>
        <div class="card bg-[#F5F6F7] p-6 shadow-lg rounded-lg fade-in">
            <div class="mb-8">
                <h3 class="text-xl font-['Playfair_Display'] text-[#003A70] mb-4">Visualisation des prêts</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="chart-container">
                        <canvas id="monthlyPaymentChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="totalInterestChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <canvas id="totalRepaidChart"></canvas>
                    </div>
                    <div class="chart-container">
                        <div id="cytoscapeGraph"></div>
                        <button id="nextStep" class="btn mt-2 bg-[#007CBA] text-[#F5F6F7] hover:bg-[#003A70] font-['Inter']">Étape suivante</button>
                    </div>
                </div>
                <div class="gantt-container">
                    <h4 class="text-lg font-['Playfair_Display'] text-[#003A70] mb-2">Calendrier de remboursement</h4>
                    <div id="ganttChart"></div>
                </div>
            </div>

            <div class="table-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg mb-8">
                <h3 class="text-xl font-['Playfair_Display'] text-[#003A70] mb-4">Résumé des prêts</h3>
                <div class="overflow-x-auto">
                    <table class="table w-full border-collapse">
                        <thead>
                            <tr class="bg-[#A0B2B8] text-[#003A70]">
                                <th class="font-['Playfair_Display']">Prêt</th>
                                <th class="font-['Playfair_Display']">Type de prêt</th>
                                <th class="font-['Playfair_Display']">Montant (€)</th>
                                <th class="font-['Playfair_Display']">Durée (mois)</th>
                                <th class="font-['Playfair_Display']">Taux (%)</th>
                                <th class="font-['Playfair_Display']">Mensualité (€)</th>
                                <th class="font-['Playfair_Display']">Total Intérêt (€)</th>
                                <th class="font-['Playfair_Display']">Total remboursé (€)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($loans as $index => $loan): ?>
                                <tr class="hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors">
                                    <td class="font-['Inter']">Prêt <?php echo $index + 1; ?></td>
                                    <td class="font-['Inter']"><?php echo htmlspecialchars($loan['type_pret_nom']); ?></td>
                                    <td class="font-['Inter']"><?php echo number_format($loan['montant_pret'], 2, ',', ' '); ?> €</td>
                                    <td class="font-['Inter']"><?php echo $loan['duree_remboursement']; ?></td>
                                    <td class="font-['Inter']"><?php echo number_format($loan['taux'], 2, ',', ' '); ?> %</td>
                                    <td class="font-['Inter']"><?php echo number_format($loan['mensualite'], 2, ',', ' '); ?> €</td>
                                    <td class="font-['Inter']"><?php echo number_format($loan['total_interest'], 2, ',', ' '); ?> €</td>
                                    <td class="font-['Inter']"><?php echo number_format($loan['total_repaid'], 2, ',', ' '); ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php foreach ($loans as $index => $loan): ?>
                <div class="table-container card bg-[#F5F6F7] p-6 shadow-lg rounded-lg mb-8">
                    <h3 class="text-xl font-['Playfair_Display'] text-[#003A70] mb-4">Tableau d'amortissement - Prêt <?php echo $index + 1; ?> (<?php echo htmlspecialchars($loan['type_pret_nom']); ?>)</h3>
                    <div class="overflow-x-auto">
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
                            <tbody>
                                <?php foreach ($loan['amortization'] as $row): ?>
                                    <tr class="hover:bg-[#007CBA] hover:text-[#F5F6F7] transition-colors">
                                        <td class="font-['Inter']"><?php echo $row['mois']; ?></td>
                                        <td class="font-['Inter']"><?php echo $row['date']; ?></td>
                                        <td class="font-['Inter']"><?php echo number_format($row['mensualite'], 2, ',', ' '); ?> €</td>
                                        <td class="font-['Inter']"><?php echo number_format($row['capital'], 2, ',', ' '); ?> €</td>
                                        <td class="font-['Inter']"><?php echo number_format($row['interet'], 2, ',', ' '); ?> €</td>
                                        <td class="font-['Inter']"><?php echo number_format($row['capital_restant'], 2, ',', ' '); ?> €</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
        <p>© 2025 CPbank. Tous droits réservés.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loans = <?php echo json_encode($loans); ?>;

            // Chart.js: Bar Chart for Monthly Payments
            new Chart(document.getElementById('monthlyPaymentChart'), {
                type: 'bar',
                data: {
                    labels: ['Prêt 1', 'Prêt 2'],
                    datasets: [{
                        label: 'Mensualité (€)',
                        data: [<?php echo $loans[0]['mensualite']; ?>, <?php echo $loans[1]['mensualite']; ?>],
                        backgroundColor: ['#003A70', '#007CBA'],
                        borderColor: ['#003A70', '#007CBA'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Comparaison des mensualités',
                            font: {
                                family: 'Playfair Display',
                                size: 16
                            },
                            color: '#003A70'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Montant (€)',
                                font: {
                                    family: 'Inter'
                                }
                            },
                            ticks: {
                                color: '#101820'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#101820'
                            }
                        }
                    }
                }
            });

            // Chart.js: Pie Chart for Total Interest Paid
            new Chart(document.getElementById('totalInterestChart'), {
                type: 'pie',
                data: {
                    labels: ['Prêt 1: <?php echo htmlspecialchars($loans[0]['type_pret_nom']); ?>', 'Prêt 2: <?php echo htmlspecialchars($loans[1]['type_pret_nom']); ?>'],
                    datasets: [{
                        label: 'Total Intérêt (€)',
                        data: [<?php echo $loans[0]['total_interest']; ?>, <?php echo $loans[1]['total_interest']; ?>],
                        backgroundColor: ['#003A70', '#007CBA'],
                        borderColor: ['#F5F6F7', '#F5F6F7'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Inter'
                                },
                                color: '#101820'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Comparaison des intérêts totaux',
                            font: {
                                family: 'Playfair Display',
                                size: 16
                            },
                            color: '#003A70'
                        }
                    }
                }
            });

            // Chart.js: Doughnut Chart for Total Repaid
            new Chart(document.getElementById('totalRepaidChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Prêt 1: <?php echo htmlspecialchars($loans[0]['type_pret_nom']); ?>', 'Prêt 2: <?php echo htmlspecialchars($loans[1]['type_pret_nom']); ?>'],
                    datasets: [{
                        label: 'Total Remboursé (€)',
                        data: [<?php echo $loans[0]['total_repaid']; ?>, <?php echo $loans[1]['total_repaid']; ?>],
                        backgroundColor: ['#003A70', '#007CBA'],
                        borderColor: ['#F5F6F7', '#F5F6F7'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    family: 'Inter'
                                },
                                color: '#101820'
                            }
                        },
                        title: {
                            display: true,
                            text: 'Comparaison des montants totaux remboursés',
                            font: {
                                family: 'Playfair Display',
                                size: 16
                            },
                            color: '#003A70'
                        }
                    }
                }
            });

            // Cytoscape.js: Animated Line Graph for Cumulative Interest
            const cy = cytoscape({
                container: document.getElementById('cytoscapeGraph'),
                elements: [
                    <?php
                    $nodes = [];
                    $edges = [];
                    foreach ($loans as $loanIndex => $loan) {
                        $color = $loanIndex === 0 ? '#003A70' : '#007CBA';
                        foreach ($loan['amortization'] as $index => $row) {
                            $nodeId = "loan{$loanIndex}_month{$row['mois']}";
                            $nodes[] = "{ data: { id: '{$nodeId}', label: 'Mois {$row['mois']}', interest: {$loan['cumulative_interest'][$index]}, loan: 'Prêt " . ($loanIndex + 1) . "' }, position: { x: " . ($index * 100) . ", y: " . ($loanIndex * 100 + 50) . " } }";
                            if ($index > 0) {
                                $prevNodeId = "loan{$loanIndex}_month" . ($row['mois'] - 1);
                                $edges[] = "{ data: { source: '{$prevNodeId}', target: '{$nodeId}', color: '{$color}' } }";
                            }
                        }
                    }
                    echo implode(',', array_merge($nodes, $edges));
                    ?>
                ],
                style: [{
                        selector: 'node',
                        style: {
                            'background-color': datum => datum.data('loan') === 'Prêt 1' ? '#003A70' : '#007CBA',
                            'label': 'data(label)',
                            'text-valign': 'center',
                            'text-halign': 'center',
                            'font-family': 'Inter',
                            'font-size': '12px',
                            'color': '#101820',
                            'width': 20,
                            'height': 20
                        }
                    },
                    {
                        selector: 'edge',
                        style: {
                            'line-color': 'data(color)',
                            'width': 2,
                            'curve-style': 'bezier'
                        }
                    }
                ],
                layout: {
                    name: 'preset'
                }
            });

            // Animation for Cytoscape.js
            function panIn(target) {
                cy.animate({
                    fit: {
                        eles: target,
                        padding: 50
                    },
                    duration: 500
                });
            }

            const allNodes = cy.nodes().sort((a, b) => {
                const aLoan = a.data('loan') === 'Prêt 1' ? 0 : 1;
                const bLoan = b.data('loan') === 'Prêt 1' ? 0 : 1;
                const aMonth = parseInt(a.data('label').replace('Mois ', ''));
                const bMonth = parseInt(b.data('label').replace('Mois ', ''));
                return aLoan - bLoan || aMonth - bMonth;
            });

            let currentIndex = 0;
            const startNode = cy.$('#loan0_month1');
            startNode.select();
            panIn(startNode);

            document.getElementById('nextStep').addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % allNodes.length;
                const nextNode = allNodes[currentIndex];
                cy.nodes().unselect();
                nextNode.select();
                panIn(nextNode);
                nextNode.style('background-color', nextNode.data('loan') === 'Prêt 1' ? '#007CBA' : '#003A70'); // Highlight
                setTimeout(() => nextNode.style('background-color', nextNode.data('loan') === 'Prêt 1' ? '#003A70' : '#007CBA'), 1000); // Revert
            });

            // DHTMLX Gantt Chart
            gantt.config.date_format = "%Y-%m-%d";
            gantt.config.columns = [{
                    name: "text",
                    label: "Prêt",
                    width: "*",
                    tree: true
                },
                {
                    name: "start_date",
                    label: "Début",
                    align: "center"
                },
                {
                    name: "duration",
                    label: "Durée (mois)",
                    align: "center"
                }
            ];
            gantt.config.scale_unit = "month";
            gantt.config.date_scale = "%F %Y";
            gantt.init("ganttChart");
            gantt.parse({
                data: [
                    <?php
                    $ganttTasks = [];
                    foreach ($loans as $index => $loan) {
                        $ganttTasks[] = "{ id: " . ($index + 1) . ", text: 'Prêt " . ($index + 1) . ": " . htmlspecialchars($loan['type_pret_nom']) . "', start_date: '2025-07-08', duration: " . $loan['duree_remboursement'] . ", progress: 0, color: '" . ($index === 0 ? '#003A70' : '#007CBA') . "' }";
                    }
                    echo implode(',', $ganttTasks);
                    ?>
                ]
            });
        });
    </script>
</body>

</html>