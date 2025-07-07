<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau des Intérêts</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .filtres { background: #f5f5f5; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .filtres label { margin-right: 10px; }
        .filtres select, .filtres button { padding: 5px; margin-right: 15px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Tableau des Intérêts</h1>
    <h2><a href="home.html">Home</a></h2>
    
    <div class="filtres">
        <label for="mois_debut">Mois début:</label>
        <select name="mois_debut" id="mois_debut">
            <option value="">Tous</option>
            <?php
            $mois = [
                'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
                'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
            ];
            foreach ($mois as $index => $nomMois) {
                echo '<option value="'.($index+1).'">'.$nomMois.'</option>';
            }
            ?>
        </select>
        
        <label for="mois_fin">Mois fin:</label>
        <select name="mois_fin" id="mois_fin">
            <option value="">Tous</option>
            <?php
            foreach ($mois as $index => $nomMois) {
                echo '<option value="'.($index+1).'">'.$nomMois.'</option>';
            }
            ?>
        </select>
        
        <label for="annee_debut">Année début:</label>
        <input type="number" name="annee_debut" value="2025" id="annee_debut" step="1" min="1900">
        
        <label for="annee_fin">Année fin:</label>
        <input type="number" name="annee_fin" value="2025" id="annee_fin" step="1" min="1900">
        
        <button onclick="chargerInterets()">Filtrer</button>
        <button onclick="reinitialiserFiltres()">Réinitialiser</button>
    </div>
    
    <table id="table-interets">
        <thead>
            <tr>
                <th>Mois</th>
                <th>Année</th>
                <th>Montant des intérêts</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script src="js/ajax.js"></script>
    
    <script>
        // Génération des options pour les années
        document.addEventListener('DOMContentLoaded', function() {
            const anneeActuelle = new Date().getFullYear();
            document.getElementById('annee_debut').value = anneeActuelle;
            document.getElementById('annee_fin').value = anneeActuelle;
            
            // Charger les données initiales
            chargerInterets();
        });

        function chargerInterets() {
            const moisDebut = document.getElementById('mois_debut').value;
            const moisFin = document.getElementById('mois_fin').value;
            const anneeDebut = document.getElementById('annee_debut').value;
            const anneeFin = document.getElementById('annee_fin').value;
            
            const params = new URLSearchParams();
            if (moisDebut) params.append('mois_debut', moisDebut);
            if (moisFin) params.append('mois_fin', moisFin);
            if (anneeDebut) params.append('annee_debut', anneeDebut);
            if (anneeFin) params.append('annee_fin', anneeFin);
            
            ajax("GET", `/interets?${params.toString()}`, null, (data) => {
                const tbody = document.querySelector("#table-interets tbody");
                tbody.innerHTML = "";
                
                if (data.length === 0) {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `<td colspan="3">Aucun résultat trouvé</td>`;
                    tbody.appendChild(tr);
                } else {
                    data.forEach(interet => {
                        const tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td>${getNomMois(interet.mois)}</td>
                            <td>${interet.annee}</td>
                            <td>${formatMontant(interet.interet)} €</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
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