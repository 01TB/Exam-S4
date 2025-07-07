<?php
require_once '../partials_finance/header.php';
?>
<main>
    <h2>Gestion des types de prêts</h2>
    <form id="loanTypeForm">
        <input type="hidden" id="id" name="id">
        <input type="text" id="nom" name="nom" placeholder="Nom du type de prêt" required>
        <input type="number" id="montant_min" name="montant_min" placeholder="Montant minimum" step="0.01" required>
        <input type="number" id="montant_max" name="montant_max" placeholder="Montant maximum" step="0.01" required>
        <input type="number" id="duree_remboursement_min" name="duree_remboursement_min" placeholder="Durée min (mois)" step="1" required>
        <input type="number" id="duree_remboursement_max" name="duree_remboursement_max" placeholder="Durée max (mois)" step="1" required>
        <input type="number" id="taux" name="taux" placeholder="Taux d'intérêt (%)" step="0.01" required>
        <button type="button" onclick="ajouterOuModifierTypePret()">Ajouter / Modifier</button>
        <p class="success">Type de prêt enregistré avec succès !</p>
        <p class="error">Erreur lors de l'enregistrement</p>
    </form>
    <table id="table-types-pret">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Montant Min</th>
                <th>Montant Max</th>
                <th>Durée Min (mois)</th>
                <th>Durée Max (mois)</th>
                <th>Taux (%)</th>
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

    function chargerTypesPret() {
        ajax("GET", "/types_pret", null, (data) => {
            const tbody = document.querySelector("#table-types-pret tbody");
            tbody.innerHTML = "";
            data.forEach((t) => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${t.id}</td>
                    <td>${t.nom}</td>
                    <td>${t.montant_min}</td>
                    <td>${t.montant_max}</td>
                    <td>${t.duree_remboursement_min}</td>
                    <td>${t.duree_remboursement_max}</td>
                    <td>${t.taux}</td>
                    <td>
                        <button onclick='remplirFormulaireTypePret(${JSON.stringify(t)})'>✏️</button>
                        <button onclick='supprimerTypePret(${t.id})'>🗑️</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
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

        const data = `nom=${encodeURIComponent(nom)}&montant_min=${montant_min}&montant_max=${montant_max}&duree_remboursement_min=${duree_remboursement_min}&duree_remboursement_max=${duree_remboursement_max}&taux=${taux}`;

        if (id) {
            ajax("PUT", `/types_pret/${id}`, data, () => {
                resetFormTypePret();
                chargerTypesPret();
                document.querySelector('.success').style.display = 'block';
                setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
            });
        } else {
            ajax("POST", "/types_pret", data, () => {
                resetFormTypePret();
                chargerTypesPret();
                document.querySelector('.success').style.display = 'block';
                setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
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
<?php require_once '../partials_finance/footer.php'; ?>