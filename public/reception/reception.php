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

    .container {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .link-btn {
        padding: 10px;
        background-color: #FFCC00;
        color: #0D0D0D;
        text-decoration: none;
        border-radius: 5px;
    }

    .link-btn:hover {
        background-color: #FFDB4D;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #FFC6B3;
        text-align: left;
    }

    th {
        background-color: #FFF2E6;
        color: #0D0D0D;
    }
</style>
<main>
    <div class="container">
        <a href="liste_prets.php" class="link-btn">Liste des prêts</a>
        <a href="inserer.php" class="link-btn">Insérer un prêt</a>
    </div>
    <h2>5 derniers prêts</h2>
    <table>
        <thead>
            <tr>
                <th>ID Prêt</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <!-- Exemple statique, à remplacer par des données réelles -->
            <tr>
                <td>1</td>
                <td>5000</td>
                <td>Approuvé</td>
            </tr>
            <tr>
                <td>2</td>
                <td>3000</td>
                <td>En attente</td>
            </tr>
            <tr>
                <td>3</td>
                <td>7000</td>
                <td>Rejeté</td>
            </tr>
            <tr>
                <td>4</td>
                <td>2000</td>
                <td>Approuvé</td>
            </tr>
            <tr>
                <td>5</td>
                <td>4000</td>
                <td>En attente</td>
            </tr>
        </tbody>
    </table>
</main>
<?php require_once '../partials_reception/footer.php'; ?>