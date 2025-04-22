<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$errors = [
    'username' => '',
    'email' => '',
    'password' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json'); // Indique que la réponse est au format JSON

    // Connexion à la base de données
    $dbFile = __DIR__ . '/database.sqlite';
    $pdo = new PDO("sqlite:$dbFile");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_POST['action'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';

    if ($csrfToken !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'errors' => ['csrf' => 'Requête invalide.']]);
        exit;
    }

    if ($action === 'register') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validation des champs
        if (empty($username)) {
            $errors['username'] = "Le nom d'utilisateur est requis.";
        }
        if (empty($email)) {
            $errors['email'] = "L'email est requis.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email est invalide.";
        }
        if (empty($password)) {
            $errors['password'] = "Le mot de passe est requis.";
        }

        // Vérification si l'email ou le nom d'utilisateur existe déjà
        if (empty($errors['email']) && empty($errors['username'])) {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
            $stmt->execute(['email' => $email, 'username' => $username]);
            if ($stmt->fetch()) {
                $errors['email'] = "L'email ou le nom d'utilisateur est déjà utilisé.";
            }
        }

        // Si aucune erreur, inscription
        if (empty(array_filter($errors))) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password_hash)");
            $stmt->execute(['username' => $username, 'email' => $email, 'password_hash' => $passwordHash]);

            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit;
        }
    } elseif ($action === 'login') {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        // Validation des champs
        if (empty($email)) {
            $errors['email'] = "L'email est requis.";
        }
        if (empty($password)) {
            $errors['password'] = "Le mot de passe est requis.";
        }

        // Vérification des identifiants
        if (empty($errors['email']) && empty($errors['password'])) {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if (!$user || !password_verify($password, $user['password_hash'])) {
                $errors['email'] = "Email ou mot de passe incorrect.";
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                echo json_encode(['success' => true]);
                exit;
            }
        }

        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription / Connexion</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body id="login-body">
  <div class="positionLogin">
    <div class="login">
      <div class="toggleForm">
        <button class="boutonRegister" id="showRegisterForm">
          <div class="texte-bouton-register">S'inscrire</div>
        </button>
        <button class="boutonLogin" id="showLoginForm">
          <div class="texte-bouton-register">Se connecter</div>
        </button>
      </div>

      <!-- Formulaire d'inscription -->
      <form id="registerForm">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="hidden" name="action" value="register">
        <div class="formInput">
          <label for="usernameRegister">Nom d'utilisateur</label>
          <input id="usernameRegister" name="username" class="input-register" type="text" required>
          <div id="registerUsernameError" class="error-message"></div>
        </div>
        <div class="formInput">
          <label for="mailRegister">E-mail</label>
          <input id="mailRegister" name="email" class="input-register" type="email" required>
          <div id="registerEmailError" class="error-message"></div>
        </div>
        <div class="formInput password-container">
          <label for="passwordRegister">Mot de passe</label>
          <input id="passwordRegister" name="password" class="input-register" type="password" required>
          <div id="registerPasswordError" class="error-message"></div>
        </div>
        <button type="submit" id="submitRegisterForm">S'inscrire</button>
      </form>

      <!-- Formulaire de connexion -->
      <form id="loginForm" style="display: none;">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
        <input type="hidden" name="action" value="login">
        <div class="formInput">
          <label for="mailLogin">E-mail</label>
          <input id="mailLogin" name="email" class="input-register" type="email" required>
          <div id="loginEmailError" class="error-message"></div>
        </div>
        <div class="formInput password-container">
          <label for="passwordLogin">Mot de passe</label>
          <input id="passwordLogin" name="password" class="input-register" type="password" required>
          <div id="loginPasswordError" class="error-message"></div>
        </div>
        <button type="submit" id="submitLoginForm">Se connecter</button>
      </form>
    </div>
  </div>

  <script src="js/toggleform.js"></script>
  <script src="js/savemail.js"></script>
  <script src="js/co.js"></script>
</body>

</html>