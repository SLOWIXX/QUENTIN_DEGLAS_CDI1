<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
  // Redirige vers la page d'inscription/connexion
  header("Location: register.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="profil-body">
  <h1 class="titre-profil">Profil Utilisateur</h1>
  <button class="hamburger" id="hamburger">&#9776;</button>
  <div class="sidebar" id="sidebar">
    <button class="close-btn" id="close-btn">&larr;</button>
    <h2 id="Menu">Options</h2>
    <ul>
      <li><a href="register.php">Accueil</a></li>
      <li><a href="profil.php">Profil</a></li>
      <li><a href="booster.php">Bootser</a></li>
      <li><a href="trade.html">Échanges</a></li>
      <li><a href="deco.php">Déconnexion</a></li>
    </ul>
  </div>

  <div class="container-profil-info">
    <div class="info-profil">
      <p class="titre-info-pseudo">
        Pseudo : <span id="username-profil"></span>
      </p>
      <p class="titre-info-pseudo">Email: <span id="email-profil"></span></p>
    </div>
  </div>

  <h2>Vos Cartes</h2>

  <div class="titre-cartes">
    <p>FAVORIS</p>
  </div>

  <div class="titre-cartes">
    <p>Cartes débloquées</p>
  </div>


  <footer class="footer">
    <div class="footer-container">
      <div class="footer-logo-slogan">
        <img src="img/logo.webp" alt="Logo de Poudlard" class="footer-logo">
        <p class="footer-slogan">"L'univers magique à portée de baguette"</p>
      </div>

      <div class="footer-navigation">
        <a href="/" class="footer-link">Accueil</a>
        <a href="/cartes" class="footer-link">Mes Cartes</a>
        <a href="/echange" class="footer-link">Échanges</a>
        <a href="/contact" class="footer-link">Contact</a>
      </div>

      <blockquote class="footer-quote">
        "Happiness can be found, even in the darkest of times, if one only remembers to turn on the light." – Albus
        Dumbledore
      </blockquote>

      <div class="footer-social">
        <a href="https://www.linkedin.com/in/quentin-deglas-81699832b" class="social-link">
          <img src="img/linkedin.png" alt="linkedin" class="social-icon">
        </a>
        <a href="https://www.instagram.com/quentin__dgls" class="social-link">
          <img src="img/instagram.png" alt="Instagram" class="social-icon">
        </a>
        <a href="https://github.com/SLOWIXX" class="social-link">
          <img src="img/github.png" alt="github" class="social-icon">
        </a>
        <a href="https://discord.gg/CaGXXD7tpV" class="social-link">
          <img src="img/discord.png" alt="Discord" class="social-icon">
        </a>
      </div>


      <div class="footer-legal">
        <p>© 2025-2025 SLOWIXX Industries, LLC. All Rights Reserved.</p>
        <a href="#" class="legal-link">Mentions légales</a> |
        <a href="#" class="legal-link">Politique de confidentialité</a>
      </div>
    </div>
  </footer>



  <script src="js/sidebar.js"></script>
</body>

</html>