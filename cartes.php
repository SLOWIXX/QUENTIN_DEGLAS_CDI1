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

foreach ($houses as $houseName => $characters) {
  foreach ($characters as $character) {
    if (strtolower($character['name']) === strtolower($cardName)) {
      $characterFound = true;
      $imagePath = 'img/' . strtolower(str_replace(' ', '', $character['name'])) . '.png';
      $actor = $character['actor'] ?? 'Inconnu';
      $alternate_names = !empty($character['alternate_names']) ? implode(', ', $character['alternate_names']) : 'Aucun';
      $species = $character['species'] ?? 'Inconnu';
      $gender = $character['gender'] ?? 'Inconnu';
      $house = $character['house'] ?? 'Inconnue';
      $dateOfBirth = $character['dateOfBirth'] ?? 'Inconnue';
      $wand = isset($character['wand']) && is_array($character['wand'])
        ? (
            (!empty($character['wand']['wood']) ? $character['wand']['wood'] : '') .
            (!empty($character['wand']['core']) ? ', ' . $character['wand']['core'] : '') .
            (!empty($character['wand']['length']) ? ', ' . $character['wand']['length'] . ' pouces' : '')
          )
        : 'Inconnue';
      $patronus = $character['patronus'] ?? 'Inconnu';
      $alive = isset($character['alive']) ? ($character['alive'] ? 'Oui' : 'Non') : 'Inconnu';
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
        <img alt="Image de la carte" src="<?= $imagePath ?>">
      </div>

      <div class="details-container">
        <ul>
          <li id="carte-acteur"><strong>Acteur :</strong> <?= $actor ?></li>
          <li id="carte-maison"><strong>Maison :</strong> <?= $house ?></li>
          <li id="carte-rarete"><strong>Autres noms :</strong> <?= $alternate_names ?></li>
          <li id="carte-description"><strong>Description :</strong> Espèce : <?= $species ?> | Genre : <?= $gender ?> | Né le : <?= $dateOfBirth ?></li>
          <li>
            <h4>Caractéristiques : /100</h4>
          </li>
        </ul>
        <ul class="aligmement-caracteristiques">
          <li id="carte-caracteristiques-force"><strong>Baguette :</strong> <?= $wand ?></li>
          <li id="carte-caracteristiques-intelligence"><strong>Patronus :</strong> <?= $patronus ?></li>
          <li id="carte-caracteristiques-charisme"><strong>Vivant :</strong> <?= $alive ?></li>
          <li id="carte-caracteristiques-magie"><strong></strong></li>
        </ul>
        <ul>
          <li id="carte-backgroundStory"><strong></strong></li>
        </ul>
      </div>

    </div>
  </div>
  <script src="js/sidebar.js"></script>
</body>

</html>