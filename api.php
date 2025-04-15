<?php


require 'vendor/autoload.php';

use GuzzleHttp\Client;

$dataFile = __DIR__ . '/data/data.json';
if (!file_exists($dataFile)) {
    die("Le fichier data.json est introuvable.");
}

$jsonContent = file_get_contents($dataFile);
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

$data = json_decode($response->getBody(), true);

if ($data === null) {
    die("Erreur lors du décodage des données JSON.");
}

$houses = [];
foreach ($data as $character) {
    if (!in_array($character['name'], $allowedNames)) {
        continue;
    }

    $house = $character['house'] ?? 'Unknown';
    if (!isset($houses[$house])) {
        $houses[$house] = [];
    }
    $houses[$house][] = $character;
}



