<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit;
}

// Récupération des informations de l'utilisateur depuis la session
$username = $_SESSION['username'] ?? 'Utilisateur inconnu';
$email = $_SESSION['email'] ?? 'Email inconnu';

// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'compte';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les favoris de l'utilisateur
    $stmt = $pdo->prepare("SELECT character_name FROM favoris WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Utilisateur</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body id="profil-body">
  <h1 class="titre-profil">Profil Utilisateur</h1>
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

  <div class="container-profil-info">
    <div class="info-profil">
      <p class="titre-info-pseudo">
        Pseudo : <span id="username-profil"><?php echo htmlspecialchars($username); ?></span>
      </p>
      <p class="titre-info-pseudo">Email: <span id="email-profil"><?php echo htmlspecialchars($email); ?></span></p>
    </div>
  </div>

  <h2>Vos Cartes</h2>

  <h2>Vos Favoris</h2>
    <div class="main-container">
        <?php if (!empty($favoris)): ?>
            <ul class="carte-container">
                <?php foreach ($favoris as $favori): ?>
                    <li class="carte" data-name="<?= htmlspecialchars(strtolower($favori['character_name'])) ?>">
                        <a href="cartes.php?name=<?= urlencode($favori['character_name']) ?>" class="carte-link">
                            <?php
                            $defaultImage = 'img/' . strtolower(str_replace(' ', '', $favori['character_name'])) . '.png';
                            ?>
                            <img src="<?= $defaultImage ?>" alt="Image de <?= htmlspecialchars($favori['character_name']) ?>"
                                class="carte-image" /><br />
                            <strong class="carte-name"><?= htmlspecialchars($favori['character_name']) ?></strong><br />
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez pas encore ajouté de cartes en favoris.</p>
        <?php endif; ?>
    </div>

  <div class="titre-cartes">
    <p>Cartes débloquées</p>
  </div>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-logo-slogan">
        <img src="img/logo.webp" alt="Logo de Poudlard" class="footer-logo">
        <p class="footer-slogan">"L'univers magique à portée de baguette"</p>
      </div>

      <div class="footer-navigation">
        <a href="/" class="footer-link">Accueil</a>
        <a href="/cartes" class="footer-link">Mes Cartes</a>
        <a href="/echange" class="footer-link">Échanges</a>
        <a href="/contact" class="footer-link">Contact</a>
      </div>

      <blockquote class="footer-quote">
        "Happiness can be found, even in the darkest of times, if one only remembers to turn on the light." – Albus
        Dumbledore
      </blockquote>

      <div class="footer-social">
        <a href="https://www.linkedin.com/in/quentin-deglas-81699832b" class="social-link">
          <img src="img/linkedin.png" alt="linkedin" class="social-icon">
        </a>
        <a href="https://www.instagram.com/quentin__dgls" class="social-link">
          <img src="img/instagram.png" alt="Instagram" class="social-icon">
        </a>
        <a href="https://github.com/SLOWIXX" class="social-link">
          <img src="img/github.png" alt="github" class="social-icon">
        </a>
        <a href="https://discord.gg/CaGXXD7tpV" class="social-link">
          <img src="img/discord.png" alt="Discord" class="social-icon">
        </a>
      </div>

      <div class="footer-legal">
        <p>© 2025-2025 SLOWIXX Industries, LLC. All Rights Reserved.</p>
        <a href="#" class="legal-link">Mentions légales</a> |
        <a href="#" class="legal-link">Politique de confidentialité</a>
      </div>
    </div>
  </footer>

  <script src="js/sidebar.js"></script>
</body>

</html>