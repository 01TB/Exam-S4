<?php
require_once '../partials_finance/header.php';
?>
<main>
    <h2>Insérer un dépôt</h2>
    <form id="depositForm">
        <input type="hidden" name="id_user" value="1">
        <div>
            <label for="nom_investisseur">Nom de l'investisseur</label>
            <input type="text" id="nom_investisseur" name="nom_investisseur" required>
        </div>
        <div>
            <label for="montant">Montant</label>
            <input type="number" id="montant" name="montant" step="0.01" required>
        </div>
        <div>
            <label for="date_depot">Date du dépôt</label>
            <input type="date" id="date_depot" name="date_depot" required>
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <button type="submit">Insérer</button>
        <p class="success">Dépôt inséré avec succès !</p>
        <p class="error">Erreur lors de l'insertion</p>
    </form>
</main>
<script>
    document.getElementById('depositForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Simulation d'insertion
        const data = new FormData(this);
        console.log('Dépôt inséré :', Object.fromEntries(data));
        document.querySelector('.success').style.display = 'block';
        setTimeout(() => document.querySelector('.success').style.display = 'none', 2000);
    });
</script>
<?php require_once '../partials_finance/footer.php'; ?>