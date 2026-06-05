<?php
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

if (!is_logged_in() || !can_verify_products()) {
    header('Location: view_products.php?error=admin_required');
    exit;
}

$id = $_GET['id'] ?? null;
$status = $_GET['status'] ?? 'Verified';
$allowed = ['Verified', 'Pending', 'For Validation'];
if (!in_array($status, $allowed, true)) $status = 'Verified';

if ($id) {
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('UPDATE products SET status = ? WHERE id = ?');
            $stmt->execute([$status, $id]);
        } catch (Exception $e) {}
    }
}
header('Location: view_products.php?updated=1');
exit;
