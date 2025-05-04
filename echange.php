<?php
// Connexion à la base de données
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

// Démarrer la session et récupérer l'ID de l'utilisateur connecté
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Erreur : Vous devez être connecté pour accéder à cette page.");
}
$loggedInUserId = $_SESSION['user_id'];

// Récupérer les utilisateurs
try {
    $stmt = $pdo->query("SELECT id, username FROM compte");
    $users = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des utilisateurs : " . htmlspecialchars($e->getMessage()));
}

// Récupérer les cartes de l'utilisateur connecté
try {
    $stmt = $pdo->prepare("SELECT id, card_name FROM user_cards WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $loggedInUserId]);
    $loggedInUserCards = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cartes de l'utilisateur connecté : " . htmlspecialchars($e->getMessage()));
}

// Récupérer les cartes de tous les utilisateurs
try {
    $stmt = $pdo->query("SELECT user_id, card_name FROM user_cards");
    $allUserCards = $stmt->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des cartes des utilisateurs : " . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Échange</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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
    <div class="exchange-container">
        <h2>Proposer un échange</h2>
        <form id="exchange-form">
            <!-- Sélection de l'utilisateur -->
            <label for="user-select">Choisissez un utilisateur :</label>
            <select id="user-select" name="user_id" required>
                <option value="">Sélectionnez un utilisateur</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($user['username']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Sélection de la carte à donner -->
            <label for="give-card">Choisissez une carte à donner :</label>
            <select id="give-card" name="give_card" required>
                <option value="">Sélectionnez une carte</option>
                <?php foreach ($loggedInUserCards as $card): ?>
                    <option value="<?= htmlspecialchars($card['card_name']) ?>"><?= htmlspecialchars($card['card_name']) ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Sélection de la carte à recevoir -->
            <label for="receive-card">Choisissez une carte à recevoir :</label>
            <select id="receive-card" name="receive_card" required>
                <option value="">Sélectionnez une carte</option>
            </select>

            <!-- Message -->
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="4" placeholder="Ajoutez un message pour l'autre utilisateur..."></textarea>

            <!-- Bouton de soumission -->
            <button type="submit" class="submit-btn">Envoyer la demande</button>
        </form>
        <div id="confirmation-message" style="display: none; color: green; margin-top: 10px;">
            Votre demande a été envoyée avec succès !
        </div>
    </div>

    <script>
        // Cartes de tous les utilisateurs (injectées depuis PHP)
        const allUserCards = <?= json_encode($allUserCards) ?>;

        // Mettre à jour les cartes à recevoir en fonction de l'utilisateur sélectionné
        document.getElementById('user-select').addEventListener('change', function() {
            const userId = this.value;
            const receiveCardSelect = document.getElementById('receive-card');

            // Vider les options actuelles
            receiveCardSelect.innerHTML = '<option value="">Sélectionnez une carte</option>';

            // Ajouter les nouvelles options
            if (allUserCards[userId]) {
                allUserCards[userId].forEach(card => {
                    const option = document.createElement('option');
                    option.value = card.card_name;
                    option.textContent = card.card_name;
                    receiveCardSelect.appendChild(option);
                });
            }
        });

        // Intercepter la soumission du formulaire
        document.getElementById('exchange-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche l'envoi du formulaire
            document.getElementById('confirmation-message').style.display = 'block'; // Affiche le message de confirmation
        });
    </script>
      <script src="js/sidebar.js"></script>
</body>
</html>