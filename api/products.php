<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../includes/functions.php';
echo json_encode(['products'=>get_products()], JSON_UNESCAPED_UNICODE);
?>
