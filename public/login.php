<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>CPbank - Connexion</title>
  <link rel="stylesheet" href="css/finance.css">
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
        <input type="text" id="nom" name="nom" required>
      </div>
      <div>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit">Se connecter</button>
      <p class="error">Erreur de connexion</p>
      <p class="success">Connexion réussie</p>
    </form>
  </div>

  <script src="js/ajax.js"></script>

  <script>

    document.getElementById('loginForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const nom = document.getElementById('nom').value;
      const password = document.getElementById('password').value;
      const data = `nom=${encodeURIComponent(nom)}&password=${encodeURIComponent(password)}`;

      ajax("POST", "/login", data, (response) => {
        console.log("response:" + response)
        if (response.success) {
          document.querySelector('.success').style.display = 'block';
          setTimeout(() => window.location.href = 'interet.php', 1000);
        } else {
          document.querySelector('.error').style.display = 'block';
          document.querySelector('.error').textContent = response.message || 'Erreur de connexion';
          setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
        }
      }, (error) => {
        document.querySelector('.error').style.display = 'block';
        document.querySelector('.error').textContent = 'Erreur: ' + error;
        setTimeout(() => document.querySelector('.error').style.display = 'none', 2000);
      });
    });
  </script>
</body>

</html>