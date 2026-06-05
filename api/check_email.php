<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/functions.php';
$email = $_GET['email'] ?? '';
$exists = false;
if ($pdo && $email) {
  $stmt = $pdo->prepare('SELECT id FROM users WHERE email=? LIMIT 1');
  $stmt->execute([$email]);
  $exists = (bool)$stmt->fetch();
}
echo json_encode(['email'=>$email, 'exists'=>$exists]);
?>
