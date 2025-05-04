<?php


require 'vendor/autoload.php';

use GuzzleHttp\Client;

$dataFile = __DIR__ . '/data/data.json';
if (!file_exists($dataFile)) {
    die("Le fichier data.json est introuvable.");
}

$jsonContent = file_get_contents($dataFile);
$characters = json_decode($jsonContent, true);

if ($characters === null) {
    die("Erreur lors du décodage du fichier data.json.");
}


$allowedNames = json_decode($jsonContent, true);

if ($allowedNames === null) {
    die("Erreur lors du décodage du fichier data.json.");
}

$allowedNames = array_column($allowedNames, 'name');

$client = new Client([
    'verify' => false 
]);

$apiUrl = "https://hp-api.onrender.com/api/characters";
$response = $client->request('GET', $apiUrl);

if ($response->getStatusCode() !== 200) {
    die("Erreur lors de la récupération des données de l'API.");
}

$apiData = json_decode($response->getBody(), true);

if ($apiData === null) {
    die("Erreur lors du décodage des données JSON de l'API.");
}

// Charger les données de data.json
$dataFile = __DIR__ . '/data/data.json';
if (!file_exists($dataFile)) {
    die("Le fichier data.json est introuvable.");
}

$jsonContent = file_get_contents($dataFile);
$dataJson = json_decode($jsonContent, true);

if ($dataJson === null) {
    die("Erreur lors du décodage du fichier data.json.");
}

// Associer les données de l'API avec celles de data.json
$characters = [];
foreach ($dataJson as $characterFromJson) {
    foreach ($apiData as $characterFromApi) {
        if (strtolower($characterFromJson['name']) === strtolower($characterFromApi['name'])) {
            $characters[] = array_merge($characterFromJson, [
                'actor' => $characterFromApi['actor'] ?? 'Inconnu'
            ]);
            break;
        }
    }
}

$houses = [];
foreach ($characters as $character) {
    $house = $character['house'] ?? 'Unknown';
    if (!isset($houses[$house])) {
        $houses[$house] = [];
    }
    $houses[$house][] = $character;
}



