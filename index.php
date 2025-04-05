<?php
include "./api.php";
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cartes Gryffondor</title>
  <link rel="stylesheet" href="./css/css.css" />
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
      </div>
    </header>


    <div class="main-container">
      <?php if (is_array($houses)): ?>
        <?php foreach ($houses as $house => $characters): ?>
          <div class="maison-container" id="house-<?= htmlspecialchars($house) ?>">
            <h2 class="house-title"><?= htmlspecialchars($house) ?></h2>
            <ul class="carte-container">
              <?php foreach ($characters as $character): ?>
                <li class="carte" data-name="<?= htmlspecialchars(strtolower($character['name'])) ?>">
                  <?php if (!empty($character['image'])): ?>
                    <img src="<?= htmlspecialchars($character['image']) ?>" alt="Image de <?= htmlspecialchars($character['name']) ?>" class="carte-image" /><br />
                  <?php else: ?>
                    <img src="placeholder_photo.webp" alt="Image de <?= htmlspecialchars($character['name']) ?>" class="carte-image" />
                  <?php endif; ?>
                    <strong class="carte-name"><?= !empty($character['name']) ? htmlspecialchars($character['name']) : "Nom inconnu" ?></strong><br />
                    <strong class="carte-name"><?= !empty($character['actor']) ? htmlspecialchars($character['actor']) : "Nom inconnu" ?></strong><br />
                    <strong class="carte-name"><?= !empty($character['house']) ? htmlspecialchars($character['house']) : "Nom inconnu" ?></strong><br />
                    <strong class="carte-name"><?= !empty($character['dateOfBirth']) ? htmlspecialchars($character['dateOfBirth']) : "Nom inconnu" ?></strong><br />
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
    </div>
  </footer>

  <script src="js/sidebar.js"></script>
  <script src="js/script.js"></script>
</body>

</html>