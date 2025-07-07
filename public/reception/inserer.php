<?php
require_once '../partials_reception/header.php';
require_once '../partials_reception/sidebar.php';
?>
<style>
    main {
        margin-left: 0;
        padding: 2rem;
        font-family: 'Inter', sans-serif;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        max-width: 400px;
    }

    select,
    input {
        padding: 10px;
        border: 1px solid #FFDB4D;
        border-radius: 5px;
    }

    button {
        padding: 10px;
        background-color: #FFCC00;
        color: #0D0D0D;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button:hover {
        background-color: #FFC6B3;
    }
</style>
<main>
    <h2>Insérer un prêt</h2>
    <form id="loanForm">
        <select name="id_client" required>
            <option value="">Sélectionner un client</option>
            <option value="1">Client 1</option>
            <option value="2">Client 2</option>
        </select>
        <select name="id_type_pret" id="loanType" required>
            <option value="">Sélectionner un type de prêt</option>
            <option value="1">Prêt personnel (5%)</option>
            <option value="2">Prêt auto (7%)</option>
        </select>
        <input type="number" name="montant_pret" placeholder="Montant du prêt" required>
        <button type="submit">Insérer</button>
    </form>
</main>
<script>
    document.getElementById('loanForm').addEventListener('submit', function(e) {
        e.preventDefault();
        // Simulation Ajax statique
        const data = new FormData(this);
        console.log('Prêt inséré :', Object.fromEntries(data));
        alert('Prêt inséré avec succès !');
    });
</script>
<?php require_once '../partials_reception/footer.php'; ?>