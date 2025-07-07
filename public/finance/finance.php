<?php
require_once '../partials_finance/header.php';
?>
<main>
    <h2>Tableau de bord - Administration</h2>
    <h3>Derniers dépôts</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Investisseur</th>
                <th>Montant</th>
                <th>Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <!-- Données statiques pour exemple -->
            <tr>
                <td>1</td>
                <td>Jean Dupont</td>
                <td>10000.00</td>
                <td>2025-07-01</td>
                <td>Investissement initial</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Marie Durand</td>
                <td>5000.00</td>
                <td>2025-07-02</td>
                <td>Fonds de réserve</td>
            </tr>
        </tbody>
    </table>
    <h3>Types de prêts</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Montant Min</th>
                <th>Montant Max</th>
                <th>Durée Min (mois)</th>
                <th>Durée Max (mois)</th>
                <th>Taux (%)</th>
            </tr>
        </thead>
        <tbody>
            <!-- Données statiques pour exemple -->
            <tr>
                <td>1</td>
                <td>Prêt personnel</td>
                <td>1000.00</td>
                <td>5000.00</td>
                <td>6</td>
                <td>24</td>
                <td>5.00</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Prêt auto</td>
                <td>5000.00</td>
                <td>20000.00</td>
                <td>12</td>
                <td>60</td>
                <td>7.00</td>
            </tr>
        </tbody>
    </table>
</main>
<?php require_once '../partials_finance/footer.php'; ?>