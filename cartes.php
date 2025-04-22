<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page d'inscription/connexion
    header("Location: register.php");
    exit;
}
?>
<?php
$cardName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Carte inconnue';

// Initialisation des variables par défaut
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
// Recherche du personnage avec le nom fourni dans l'URL
$characterFound = false;

// recherche le personnage dans les données récupérées
foreach ($houses as $house => $characters) {
    foreach ($characters as $character) {
        if (strtolower($character['name']) === strtolower($cardName)) {
            $characterFound = true;
            $cardImage = !empty($character['image']) ? $character['image'] : $cardImage;
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
          <li><h4>Caractéristiques : /100</h4></li>
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
</body>

</html>
