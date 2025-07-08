<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CPbank - Connexion</title>
  <!-- Tailwind CSS and DaisyUI CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <!-- Google Fonts: Playfair Display, Inter -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <!-- Heroicons CDN -->
  <script src="https://unpkg.com/heroicons@2.1.1/dist/heroicons.min.js"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #F5F6F7;
      /* Off-White */
      color: #101820;
      /* Near Black */
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      justify-content: center;
      align-items: center;
    }

    h1 {
      font-family: 'Playfair Display', serif;
      color: #003A70;
      /* Dark Blue */
    }

    .login-container {
      max-width: 400px;
      width: 100%;
      padding: 2rem;
      background-color: #F5F6F7;
      /* Off-White */
      border-radius: 0.5rem;
      box-shadow: 0 10px 15px rgba(0, 58, 112, 0.1);
      /* Shadow with Dark Blue tint */
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 20px rgba(0, 58, 112, 0.15);
    }

    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .success,
    .error {
      display: none;
      padding: 1rem;
      border-radius: 0.5rem;
      animation: fadeIn 0.5s ease-in;
      margin-top: 1rem;
    }

    .success {
      background-color: #007CBA;
      /* Light Blue */
      color: #F5F6F7;
      /* Off-White */
    }

    .error {
      background-color: #A0B2B8;
      /* Light Gray */
      color: #101820;
      /* Near Black */
    }

    .logo-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
  </style>
</head>

<body>
  <!-- Header -->
  <header class="w-full bg-[#003A70] py-4">
    <div class="container mx-auto px-4 flex items-center justify-center">
      <svg class="h-8 w-8 mr-2 fill-[#007CBA]" viewBox="0 0 24 24">
        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
      </svg>
      <h1 class="text-2xl font-bold text-[#007CBA] font-['Playfair_Display']">CPbank</h1>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-4 flex-grow flex items-center justify-center">
    <div class="login-container fade-in">
      <div class="logo-container">
        <svg class="h-8 w-8 mr-2 fill-[#007CBA]" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
        </svg>
        <h1 class="text-2xl font-['Playfair_Display'] text-[#003A70]">CPbank</h1>
      </div>
      <form id="loginForm">
        <div class="form-control mb-4">
          <label class="label" for="nom">
            <span class="label-text text-[#101820] font-['Playfair_Display']">Nom d'utilisateur</span>
            <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
          </label>
          <input type="text" id="nom" name="nom" placeholder="Nom d'utilisateur" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
        </div>
        <div class="form-control mb-4">
          <label class="label" for="password">
            <span class="label-text text-[#101820] font-['Playfair_Display']">Mot de passe</span>
            <svg class="h-5 w-5 text-[#007CBA] ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 1.104-.896 2-2 2H7v2h3c1.104 0 2 .896 2 2v4H5v-4c0-1.104.896-2 2-2h3V9H7c-1.104 0-2-.896-2-2V5h7v4zm6 6h-2v2h2v-2zm0-4h-2v2h2v-2zm0-4h-2v2h2V9z"></path>
            </svg>
          </label>
          <input type="password" id="password" name="password" placeholder="Mot de passe" class="input input-bordered border-[#A0B2B8] focus:border-[#007CBA]" required>
        </div>
        <button type="submit" class="btn bg-[#003A70] text-[#F5F6F7] hover:bg-[#007CBA] w-full flex items-center justify-center">
          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path>
          </svg>
          Se connecter
        </button>
        <p class="success">Connexion réussie</p>
        <p class="error">Erreur de connexion</p>
      </form>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-[#F5F6F7] text-[#101820] text-center py-4 font-['Inter']">
    <p>© 2025 CPbank. Tous droits réservés.</p>
  </footer>

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
          setTimeout(() => window.location.href = response.redirect, 1000);
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