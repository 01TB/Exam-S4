<?php
require_once '../partials_finance/header.php';
?>
<main>
    <h2>Insérer un type de prêt</h2>
    <form id="loanTypeForm">
        <div>
            <label for="nom">Nom du type de prêt</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div>
            <label for="montant_min">Montant minimum</label>
            <input type="number" id="montant_min" name="montant_min" step="0.01" required>
        </div>
        <div>
            <label for="montant_max">Montant maximum</label>
            <input type="number" id="montant_max" name="montant_max" step="0.01" required>
        </div>
        <div>
            <label for="duree_remboursement_min">Durée de remboursement minimum (mois)</label>
            <input type="number" id="duree_remboursement_min" name="d two_remboursement_min" step="1" required>
        </div>
        <div>
            <label for="duree_remboursement_max">Durée de remboursement maximum (mois)</label>
            <input type="number" id="duree_remboursement_max" name="duree_remboursement_max" step="1" required>
        </div>
        <div>
            <label for="taux">Taux d'intérêt (%)</label>
            <input type="number" id="taux" name="taux" step="0.01" required>
        </div>
        <button type="submit">Insérer</button>
        <p class="success">Type de prêt inséré avec succès !</p>
        <p class="error">Erreur lors de l'insertion</p>
    </form>
</main>
<script>
    document.getElementById('loanTypeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Simulation d'insertion
        const data = new FormData(this);
        console.log('Type de prêt inséré :', Object.fromEntries(data));
        document.querySelector('.success').style.display = 'block';
        setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
    });
</script>
<?php require_once '../partials_finance/footer.php'; ?>