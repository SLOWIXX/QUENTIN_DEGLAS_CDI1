<?php
require_once "config/session.php";

$cardName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Carte inconnue';

$cardImage = 'images/not-found.png';
$actor = 'Inconnu';
$house = 'Inconnue';
$rarete = 'Inconnue';
$description = 'Aucune description disponible';
$force = 0;
$intelligence = 0;
$charisme = 0;
$magie = 0;
$backgroundStory = 'Aucune histoire disponible';

require 'api.php';
$characterFound = false;

foreach ($houses as $house => $characters) {
  foreach ($characters as $character) {
    if (strtolower($character['name']) === strtolower($cardName)) {
      $characterFound = true;
      $imagePath = 'img/' . strtolower(str_replace(' ', '', $character['name'])) . '.png';
      $cardImage = file_exists($imagePath) ? $imagePath : 'img/default.png';
      $actor = !empty($character['actor']) ? $character['actor'] : $actor;
      $house = !empty($character['house']) ? $character['house'] : $house;
      $rarete = !empty($character['rarete']) ? $character['rarete'] : $rarete;
      $description = !empty($character['description']) ? $character['description'] : $description;
      $force = isset($character['caracteristiques']['force']) ? $character['caracteristiques']['force'] : $force;
      $intelligence = isset($character['caracteristiques']['intelligence']) ? $character['caracteristiques']['intelligence'] : $intelligence;
      $charisme = isset($character['caracteristiques']['charisme']) ? $character['caracteristiques']['charisme'] : $charisme;
      $magie = isset($character['caracteristiques']['magie']) ? $character['caracteristiques']['magie'] : $magie;
      $backgroundStory = !empty($character['backgroundStory']) ? $character['backgroundStory'] : $backgroundStory;
      break 2;
    }
  }
}

if (!$characterFound) {
  echo "Personnage non trouvé.";
  exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Détails de la carte</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="body-cartes">
<button class="hamburger" id="hamburger">&#9776;</button>
    <div class="sidebar" id="sidebar">
      <button class="close-btn" id="close-btn">&larr;</button>
      <h2 id="Menu">Options</h2>
      <ul>
        <li><a href="index.php">Accueil</a></li>
        <li><a href="profil.php">Profil</a></li>
        <li><a href="booster.php">Bootser</a></li>
        <li><a href="trade.html">Échanges</a></li>
        <li><a href="deco.php">Déconnexion</a></li>
      </ul>
    </div>
  <div class="page-cartes-container">
    <h1 id="carte-nom"><?= $cardName ?></h1>
    <div class="content">

      <div class="image-container">
        <img alt="Image de la carte" src="<?= $cardImage ?>">
      </div>

      <div class="details-container">
        <ul>
          <li id="carte-acteur"><strong>Acteur :</strong> <?= $actor ?></li>
          <li id="carte-maison"><strong>Maison :</strong> <?= $house ?></li>
          <li id="carte-rarete"><strong>Rareté :</strong> <?= $rarete ?></li>
          <li id="carte-description"><strong>Description :</strong> <?= $description ?></li>
          <li>
            <h4>Caractéristiques : /100</h4>
          </li>
        </ul>
        <ul class="aligmement-caracteristiques">
          <li id="carte-caracteristiques-force"><strong>Force :</strong> <?= $force ?></li>
          <li id="carte-caracteristiques-intelligence"><strong>Intelligence :</strong> <?= $intelligence ?></li>
          <li id="carte-caracteristiques-charisme"><strong>Charisme :</strong> <?= $charisme ?></li>
          <li id="carte-caracteristiques-magie"><strong>Magie :</strong> <?= $magie ?></li>
        </ul>
        <ul>
          <li id="carte-backgroundStory"><strong>Histoire :</strong> <?= $backgroundStory ?></li>
        </ul>
      </div>

    </div>
  </div>
  <script src="js/sidebar.js"></script>
</body>

</html>