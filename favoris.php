<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $characterName = trim($_POST['character_name'] ?? '');

    if (empty($characterName)) {
        echo json_encode(['success' => false, 'message' => 'Nom du personnage manquant.']);
        exit;
    }

    // Connexion à la base de données
    $host = '127.0.0.1';
    $dbname = 'compte';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier si le favori existe déjà
        $stmt = $pdo->prepare("SELECT id FROM favoris WHERE user_id = :user_id AND character_name = :character_name");
        $stmt->execute(['user_id' => $userId, 'character_name' => $characterName]);
        $favori = $stmt->fetch();

        if ($favori) {
            // Supprimer le favori
            $stmt = $pdo->prepare("DELETE FROM favoris WHERE id = :id");
            $stmt->execute(['id' => $favori['id']]);
            echo json_encode(['success' => true, 'message' => 'Favori supprimé.']);
        } else {
            // Ajouter le favori
            $stmt = $pdo->prepare("INSERT INTO favoris (user_id, character_name) VALUES (:user_id, :character_name)");
            $stmt->execute(['user_id' => $userId, 'character_name' => $characterName]);
            echo json_encode(['success' => true, 'message' => 'Favori ajouté.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
}