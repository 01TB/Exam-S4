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

    .filter {
        margin-bottom: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #FFC6B3;
    }

    th {
        background-color: #FFF2E6;
        color: #0D0D0D;
    }
</style>
<main>
    <h2>Liste des prêts</h2>
    <input type="text" class="filter" placeholder="Filtrer par ID ou statut">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Client 1</td>
                <td>5000</td>
                <td>Approuvé</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Client 2</td>
                <td>3000</td>
                <td>En attente</td>
            </tr>
        </tbody>
    </table>
</main>
<?php require_once '../partials_reception/footer.php'; ?>