<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit;
}

// Connexion à la base de données MySQL
$host = '127.0.0.1';
$dbname = 'compte';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}

// Récupère l'utilisateur connecté
$userId = $_SESSION['user_id'];

// Vérifie si un booster peut être ouvert
$stmt = $pdo->prepare("SELECT last_booster_opened FROM compte WHERE id = :user_id");
$stmt->execute(['user_id' => $userId]);
$user = $stmt->fetch();

$canOpenBooster = true;
if ($user && $user['last_booster_opened']) {
    $lastOpened = new DateTime($user['last_booster_opened']);
    $now = new DateTime();
    $interval = $now->diff($lastOpened);

    // Vérifie si 24 heures se sont écoulées depuis la dernière ouverture
    if ($interval->h < 24 && $interval->d === 0) {
        $canOpenBooster = false;
    }
}

// Charger les cartes disponibles depuis data.json
$dataFile = __DIR__ . '/data/data.json';
if (!file_exists($dataFile)) {
    die("Le fichier data.json est introuvable.");
}

$jsonContent = file_get_contents($dataFile);
$availableCards = json_decode($jsonContent, true);

if ($availableCards === null) {
    die("Erreur lors du décodage du fichier data.json.");
}

// Si le booster est ouvert
$cards = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $canOpenBooster) {
    // Récupère les cartes déjà possédées par l'utilisateur
    $stmt = $pdo->prepare("SELECT card_name FROM user_cards WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);
    $ownedCards = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Filtrer les cartes disponibles pour exclure celles déjà possédées
    $filteredCards = array_filter($availableCards, function ($card) use ($ownedCards) {
        return !in_array($card['name'], $ownedCards);
    });

    // Vérifie s'il reste suffisamment de cartes disponibles
    if (count($filteredCards) < 5) {
        die("Il n'y a pas assez de nouvelles cartes disponibles pour ouvrir un booster.");
    }

    // Sélectionne 5 cartes aléatoires parmi les cartes non possédées
    $randomKeys = array_rand($filteredCards, 5);
    foreach ($randomKeys as $key) {
        $cards[] = $filteredCards[$key];
    }

    // Ajoute les cartes à la collection de l'utilisateur
    $stmt = $pdo->prepare("INSERT INTO user_cards (user_id, card_name) VALUES (:user_id, :card_name)");
    foreach ($cards as $card) {
        $stmt->execute(['user_id' => $userId, 'card_name' => $card['name']]);
    }

    // Met à jour la date de la dernière ouverture de booster
    $stmt = $pdo->prepare("UPDATE compte SET last_booster_opened = NOW() WHERE id = :user_id");
    $stmt->execute(['user_id' => $userId]);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Déballer un Booster</title>
</head>

<body id="body-booster">
    <button class="hamburger" id="hamburger">&#9776;</button>
    <div class="sidebar" id="sidebar">
        <button class="close-btn" id="close-btn">&larr;</button>
        <h2 id="Menu">Options</h2>
        <ul>
            <li><a href="register.php">Accueil</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="booster.php">Booster</a></li>
            <li><a href="trade.html">Échanges</a></li>
            <li><a href="deco.php">Déconnexion</a></li>
        </ul>
    </div>

    <div class="booster-container">
        <h1>Déballer un Booster</h1>
        <div class="booster-status">
            <?php if ($canOpenBooster): ?>
                <p>Un booster est disponible !</p>
                <form method="POST" action="booster.php">
                    <button id="booster-btn" type="submit">Ouvrir un booster</button>
                </form>
            <?php else: ?>
                <p>Vous avez déjà ouvert un booster dans les dernières 24 heures. Revenez plus tard !</p>
            <?php endif; ?>
        </div>

        <?php if (!empty($cards)): ?>
            <div class="booster-result">
                <h2>Vous avez obtenu :</h2>
                <div class="carte-container">
                    <?php foreach ($cards as $card): ?>
                        <div class="carte">
                            <img src="<?= htmlspecialchars($card['image'] ?? 'img/default.png') ?>" 
                                 alt="Image de <?= htmlspecialchars($card['name']) ?>" 
                                 class="carte-image" />
                            <strong class="carte-name"><?= htmlspecialchars($card['name']) ?></strong>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="js/sidebar.js"></script>
</body>

</html>