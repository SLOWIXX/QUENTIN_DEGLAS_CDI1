<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Redirige vers la page d'inscription/connexion
    header("Location: register.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Déconnexion</title>
</head>

<body id="deco-body">
<div class="deco-container">
    <div class="deco-container-inte">
        <p class="deco-title">Êtes-vous sûr de vouloir vous déconnecter ?</p>
<form id="deco-form" class="deco-form" method="POST" action="deco.php">
    <button type="submit" name="confirm" value="yes" class="deco-btn">Oui</button>
    <button type="button" onclick="window.history.back();" class="deco-btn">Non</button>
</form>
    </div>
</div>
</body>

</html>

<?php
// Si l'utilisateur confirme la déconnexion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
    // Détruit la session
    session_unset();
    session_destroy();

    // Redirige vers la page d'inscription/connexion
    header("Location: register.php");
    exit;
}
?>