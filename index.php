<?php
include "./api.php";
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cartes Gryffondor</title>
    <link rel="stylesheet" href="css/style.css" />
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
          <li><a href="booster.html">Booster</a></li>
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
          <button id="searchButton">Rechercher</button>
        </div>
        <button id="placement-reset-button" style="display:none;">Réinitialiser</button>
      </header>

      <div class="cartes" id="cartes-container">
        <?php if (is_array($houses)): ?>
          <?php foreach ($houses as $house => $characters): ?>
            <h2>Maison : <?= htmlspecialchars($house) ?></h2>
            <ul>
              <?php foreach ($characters as $character): ?>
                <li class="carte" data-name="<?= htmlspecialchars(strtolower($character['name'])) ?>">
                  <strong>Name :</strong> <?= !empty($character['name']) ? htmlspecialchars($character['name']) : "Nom inconnu" ?><br/>
                  <?php if (!empty($character['image'])): ?>
                    <img src="<?= htmlspecialchars($character['image']) ?>" alt="Image de <?= htmlspecialchars($character['name']) ?>" style="width:100px;"><br/>
                  <?php else: ?>
                    <img src="placeholder_photo.webp" alt="Image de <?= htmlspecialchars($character['name']) ?>" style="width:100px;"><br/>
                  <?php endif; ?>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endforeach; ?>
        <?php else: ?>
          <p>Impossible de récupérer les données de l'API.</p>
        <?php endif; ?>
      </div>

      <button style="display:none;" onclick="window.location.href='design_cartes.html';">Voir toutes les maisons</button>
    </div>

    <footer class="footer">
      <div class="footer-container">
        <div class="footer-logo-slogan">
          <img src="img/logo.webp" alt="Logo de Poudlard" class="footer-logo" />
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
            <img src="img/linkedin.png" alt="linkedin" class="social-icon" />
          </a>
          <a href="https://www.instagram.com/quentin__dgls" class="social-link">
            <img src="img/instagram.png" alt="Instagram" class="social-icon" />
          </a>
          <a href="https://github.com/SLOWIXX" class="social-link">
            <img src="img/github.png" alt="github" class="social-icon" />
          </a>
          <a href="https://discord.gg/CaGXXD7tpV" class="social-link">
            <img src="img/discord.png" alt="Discord" class="social-icon" />
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
    <script src="js/defilement.js"></script>
    <script src="js/cartesgd.js"></script>
    <script src="js/obligationConnexion.js"></script>
    <script src="js/script.js"></script> 
    <script>
      checkLogin();
    </script>
  </body>
</html>
