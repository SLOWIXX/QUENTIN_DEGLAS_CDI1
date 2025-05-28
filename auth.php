<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once"db.php";

try {


    $pdo->exec("
        CREATE TABLE IF NOT EXISTS compte (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    $columnCheck = $pdo->query("SHOW COLUMNS FROM compte LIKE 'last_booster_opened'")->fetch();
    if (!$columnCheck) {
        $pdo->exec("
            ALTER TABLE compte ADD COLUMN last_booster_opened TIMESTAMP NULL DEFAULT NULL
        ");
    }

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS favoris (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            character_name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES compte(id)
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS exchange_requests (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            receiver_id INT NOT NULL,
            give_card VARCHAR(255) NOT NULL,
            receive_card VARCHAR(255) NOT NULL,
            message TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (sender_id) REFERENCES compte(id),
            FOREIGN KEY (receiver_id) REFERENCES compte(id)
        )
    ");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS user_cards (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            card_name VARCHAR(255) NOT NULL,
            obtained_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES compte(id)
        )
    ");
} catch (PDOException $e) {
    die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}

