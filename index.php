<?php
include "./api.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cartes Gryffondor</title>
  <link rel="stylesheet" href="./css/style.css" />
</head>

<body id="design_cartes-body">
  <div class="container-haut">

    <button class="hamburger" id="hamburger">&#9776;</button>
    <div class="sidebar" id="sidebar">
      <button class="close-btn" id="close-btn">&larr;</button>
      <h2 id="Menu">Options</h2>
      <ul>
        <li><a href="#">Accueil</a></li>
        <li><a href="profil.html">Profil</a></li>
        <li><a href="booster.html">Bootser</a></li>
        <li><a href="trade.html">Échanges</a></li>
        <li><a href="deco.html">Déconnexion</a></li>
      </ul>
    </div>

    <header>
      <div class="site-title">
        <h2 class="text">CARTES DISPONIBLES</h2>
      </div>
      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Rechercher une carte par nom..." />
      </div>
    </header>


    <div class="main-container">
      <?php if (is_array($houses)): ?>
        <?php foreach ($houses as $house => $characters): ?>
          <div class="maison-container" id="house-<?= htmlspecialchars($house) ?>">
            <div class="house-title">
              <h2><?= htmlspecialchars($house) ?></h2>
            </div>
            <ul class="carte-container">
              <?php foreach ($characters as $character): ?>
                <li class="carte" data-name="<?= htmlspecialchars(strtolower($character['name'])) ?>">
                  <?php if (!empty($character['image'])): ?>
                    <img src="<?= htmlspecialchars($character['image']) ?>" alt="Image de <?= htmlspecialchars($character['name']) ?>" class="carte-image" /><br />
                  <?php endif; ?>
                  <?php if (!empty($character['name'])): ?>
                    <strong class="carte-name"><?= htmlspecialchars($character['name']) ?></strong><br />
                  <?php endif; ?>
                  <?php if (!empty($character['actor'])): ?>
                    <strong class="carte-info">Acteur : <?= htmlspecialchars($character['actor']) ?></strong><br />
                  <?php endif; ?>
                  <?php if (!empty($character['house'])): ?>
                    <strong class="carte-info">Maison : <?= htmlspecialchars($character['house']) ?></strong><br />
                  <?php endif; ?>
                  <?php if (!empty($character['dateOfBirth'])): ?>
                    <strong class="carte-info">Date de naissance : <?= htmlspecialchars($character['dateOfBirth']) ?></strong><br />
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Impossible de récupérer les données de l'API.</p>
      <?php endif; ?>
    </div>
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
        "Happiness can be found, even in the darkest of times, if one only remembers to turn on the light." – Albus Dumbledore
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
  <script src="js/script.js"></script>
</body>

</html>