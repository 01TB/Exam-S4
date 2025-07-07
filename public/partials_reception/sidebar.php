<div class="sidebar" id="sidebar">
    <div class="hamburger" onclick="onClickHamburger()">☰</div>
    <ul>
        <li><a href="inserer.php">Insérer un prêt</a></li>
        <li><a href="liste_prets.php">Liste des prêts</a></li>
        <li><a href="liste_clients.php">Liste des clients</a></li>
    </ul>
</div>
<script>
    function onClickHamburger() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }
</script>