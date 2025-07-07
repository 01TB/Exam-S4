<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>CPbank - Connexion</title>
  <link rel="stylesheet" href="css/reception.css">
</head>

<body>
  <div class="login-container">
    <div class="logo-container">
      <svg class="logo-icon" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
      </svg>
      <h1>CPbank</h1>
    </div>
    <form id="loginForm">
      <div>
        <label for="username">Nom d'utilisateur</label>
        <input type="text" id="username" name="nom" required>
      </div>
      <div>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="mdp" required>
      </div>
      <button type="submit">Se connecter</button>
      <p class="error">Erreur de connexion</p>
      <p class="success">Connexion réussie</p>
    </form>
  </div>
  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      // Simulation d'une connexion (à remplacer par une vérification réelle)
      setTimeout(() => {
        document.querySelector('.success').style.display = 'block';
        setTimeout(() => window.location.href = 'finance/finance.php', 1000);
      }, 500);
    });
  </script>
</body>

</html>