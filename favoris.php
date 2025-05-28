<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $characterName = trim($_POST['character_name'] ?? '');

    if (empty($characterName)) {
        echo json_encode(['success' => false, 'message' => 'Nom du personnage manquant.']);
        exit;
    }

 require_once "config/db.php";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT id FROM favoris WHERE user_id = :user_id AND character_name = :character_name");
        $stmt->execute(['user_id' => $userId, 'character_name' => $characterName]);
        $favori = $stmt->fetch();

        if ($favori) {
            $stmt = $pdo->prepare("DELETE FROM favoris WHERE id = :id");
            $stmt->execute(['id' => $favori['id']]);
            echo json_encode(['success' => true, 'message' => 'Favori supprimé.']);
        } else {
            $stmt = $pdo->prepare("INSERT INTO favoris (user_id, character_name) VALUES (:user_id, :character_name)");
            $stmt->execute(['user_id' => $userId, 'character_name' => $characterName]);
            echo json_encode(['success' => true, 'message' => 'Favori ajouté.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
}