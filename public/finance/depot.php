<?php
require_once '../partials_finance/header.php';
?>
<main>
    <h2>Gestion des dépôts</h2>
    <form id="depositForm">
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="id_user" name="id_user" value="1">
        <input type="text" id="nom_investisseur" name="nom_investisseur" placeholder="Nom de l'investisseur" required>
        <input type="number" id="montant" name="montant" placeholder="Montant" step="0.01" required>
        <input type="datetime-local" id="date_depot" name="date_depot" placeholder="Date du dépôt" required>
        <textarea Much id="description" name="description" placeholder="Description"></textarea>
        <button type="button" onclick="ajouterOuModifierDepot()">Ajouter / Modifier</button>
        <p class="success">Dépôt enregistré avec succès !</p>
        <p class="error">Erreur lors de l'enregistrement</p>
    </form>
    <table id="table-depots">
        <thead>
            <tr>
                <th>ID</th>
                <th>Investisseur</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</main>
<script>
    const apiBase = "http://localhost/EXAM-S4/ws";

    function ajax(method, url, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, apiBase + url, true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4 && xhr.status === 200) {
                callback(JSON.parse(xhr.responseText));
            } else if (xhr.readyState === 4) {
                document.querySelector('.error').style.display = 'block';
                setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
            }
        };
        xhr.send(data);
    }

    function chargerDepots() {
        ajax("GET", "/depots", null, (data) => {
            const tbody = document.querySelector("#table-depots tbody");
            tbody.innerHTML = "";
            data.forEach((d) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${d.id}</td>
                    <td>${d.nom_investisseur}</td>
                    <td>${d.montant}</td>
                    <td>${d.date_depot}</td>
                    <td>${d.description || ''}</td>
                    <td>
                        <button onclick='remplirFormulaireDepot(${JSON.stringify(d)})'>✏️</button>
                        <button onclick='supprimerDepot(${d.id})'>🗑️</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });
    }

    function ajouterOuModifierDepot() {
        const id = document.getElementById("id").value;
        const id_user = document.getElementById("id_user").value;
        const nom_investisseur = document.getElementById("nom_investisseur").value;
        const montant = document.getElementById("montant").value;
        const date_depot = document.getElementById("date_depot").value;
        const description = document.getElementById("description").value;

        const data = `id_user=${encodeURIComponent(id_user)}&nom_investisseur=${encodeURIComponent(nom_investisseur)}&montant=${montant}&date_depot=${encodeURIComponent(date_depot)}&description=${encodeURIComponent(description)}`;

        if (id) {
            ajax("PUT", `/depots/${id}`, data, () => {
                resetFormDepot();
                chargerDepots();
                document.querySelector('.success').style.display = 'block';
                setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
            });
        } else {
            ajax("POST", "/depots", data, () => {
                resetFormDepot();
                chargerDepots();
                document.querySelector('.success').style.display = 'block';
                setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
            });
        }
    }

    function remplirFormulaireDepot(d) {
        document.getElementById("id").value = d.id;
        document.getElementById("id_user").value = d.id_user;
        document.getElementById("nom_investisseur").value = d.nom_investisseur;
        document.getElementById("montant").value = d.montant;
        document.getElementById("date_depot").value = d.date_depot.replace(' ', 'T');
        document.getElementById("description").value = d.description || '';
    }

    function supprimerDepot(id) {
        if (confirm("Supprimer ce dépôt ?")) {
            ajax("DELETE", `/depots/${id}`, null, () => {
                chargerDepots();
            });
        }
    }

    function resetFormDepot() {
        document.getElementById("id").value = "";
        document.getElementById("id_user").value = "1";
        document.getElementById("nom_investisseur").value = "";
        document.getElementById("montant").value = "";
        document.getElementById("date_depot").value = "";
        document.getElementById("description").value = "";
    }

    chargerDepots();
</script>
<?php require_once '../partials_finance/footer.php'; ?>