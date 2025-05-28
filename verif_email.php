<?php
require_once "config/db.php";
header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$exists = false;

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare("SELECT id FROM compte WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $exists = $stmt->fetch() ? true : false;
}

echo json_encode(['exists' => $exists]);
?>
