<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}




$host = '127.0.0.1'; // Adresse du serveur
$dbname = 'compte'; // Nom de la base de données
$user = 'root'; // Nom d'utilisateur (par défaut sur Laragon)
$pass = ''; // Mot de passe (vide par défaut sur Laragon)
$charset = 'utf8mb4'; // Jeu de caractères

try {
    // Connexion à MySQL
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Créer la table `compte` si elle n'existe pas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS compte (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Vérifier si la colonne `last_booster_opened` existe avant de l'ajouter
    $columnCheck = $pdo->query("SHOW COLUMNS FROM compte LIKE 'last_booster_opened'")->fetch();
    if (!$columnCheck) {
        $pdo->exec("
            ALTER TABLE compte ADD COLUMN last_booster_opened TIMESTAMP NULL DEFAULT NULL
        ");
    }

    // Créer la table `favoris` si elle n'existe pas
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS favoris (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            character_name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES compte(id)
        )
    ");

    // Créer la table `exchange_requests` si elle n'existe pas
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

    // Créer la table `user_cards` si elle n'existe pas
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($username) || empty($email) || empty($password)) {
            die("Tous les champs sont obligatoires.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die("Adresse e-mail invalide.");
        }

        // Vérifier si l'utilisateur ou l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM compte WHERE email = :email OR username = :username");
        $stmt->execute(['email' => $email, 'username' => $username]);
        if ($stmt->fetch()) {
            die("L'utilisateur ou l'email existe déjà.");
        }

        // Hacher le mot de passe
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Insérer l'utilisateur dans la base de données
        $stmt = $pdo->prepare("INSERT INTO compte (username, email, password_hash) VALUES (:username, :email, :password_hash)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $passwordHash]);

        echo "Inscription réussie.";
    } elseif ($action === 'login') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Vérifier si l'utilisateur existe
        $stmt = $pdo->prepare("SELECT id, username, password_hash FROM compte WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            die("Email ou mot de passe incorrect.");
        }

        // Connexion réussie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo "Connexion réussie.";
    }
}