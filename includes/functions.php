<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/ube_data.php';

/* ── Escape helper ─────────────────────────────────────────── */
function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}


/* ── User access helpers ───────────────────────────────────── */
function is_logged_in() {
    return !empty($_SESSION['user_email']);
}

function current_user_role() {
    return $_SESSION['user_role'] ?? 'Guest';
}

function is_admin_user() {
    return strcasecmp(current_user_role(), 'Administrator') === 0;
}

function can_add_product() {
    $role = current_user_role();
    return in_array($role, ['Farmer / Cooperative', 'Corporate Seller', 'Processor / Brand', 'Administrator'], true);
}

function can_verify_products() {
    return is_admin_user();
}

function get_current_user_profile() {
    global $pdo;
    $profile = [
        'full_name' => $_SESSION['full_name'] ?? 'PurpleRoots User',
        'email' => $_SESSION['user_email'] ?? '',
        'role' => current_user_role(),
        'organization' => $_SESSION['organization'] ?? '',
        'phone' => $_SESSION['phone'] ?? '',
        'province' => $_SESSION['province'] ?? '',
        'municipality' => $_SESSION['municipality'] ?? '',
        'created_at' => $_SESSION['created_at'] ?? '',
        'id' => $_SESSION['user_id'] ?? null,
    ];
    if ($pdo && !empty($profile['email'])) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$profile['email']]);
            $row = $stmt->fetch();
            if ($row) {
                $profile['full_name'] = $row['full_name'] ?? $profile['full_name'];
                $profile['email'] = $row['email'] ?? $profile['email'];
                $profile['role'] = $row['role'] ?? $profile['role'];
                $profile['organization'] = $row['organization'] ?? $profile['organization'];
                $profile['phone'] = $row['phone'] ?? $profile['phone'];
                $profile['province'] = $row['province'] ?? $profile['province'];
                $profile['municipality'] = $row['municipality'] ?? $profile['municipality'];
                $profile['created_at'] = $row['created_at'] ?? $profile['created_at'];
                $profile['id'] = $row['id'] ?? $profile['id'];
                $_SESSION['user_id'] = $profile['id'];
            }
        } catch (Exception $e) {}
    }
    return $profile;
}


function ube_featured_product_thumbnail($product) {
    $name = strtolower($product['product_name'] ?? '');
    $province = strtolower($product['province'] ?? '');
    $code = strtoupper($product['batch_code'] ?? '');
    if (str_contains($name, 'heritage ube kinampay') || str_contains($name, 'ube kinampay') || $province === 'antique' || $province === 'negros occidental' || str_contains($code, 'UBE-ANT') || str_contains($code, 'UBE-NEG')) {
        return 'uploads/Heritage Ube Kinampay.jpg';
    }
    if (str_contains($name, 'planting material') || $province === 'leyte' || str_contains($code, 'UBE-LEY')) {
        return 'uploads/Ube Planting Materials - Leyte.jpg';
    }
    if (str_contains($name, 'commercial-grade') || str_contains($name, 'commercial-grade ube') || $province === 'bukidnon' || str_contains($code, 'UBE-BUK')) {
        return 'uploads/Commercial-Grade Ube Supply - Bukidnon.jpg';
    }
    if (!empty($product['thumbnail'])) return $product['thumbnail'];
    $area = find_ube_area($product['batch_code'] ?? ($product['province'] ?? ''));
    return $area['thumbnail'] ?? 'uploads/logo.png';
}

function ube_home_featured_products() {
    return [
        [
            'id' => 'UBE-ANT-2026-0041',
            'product_name' => 'Heritage Ube Kinampay - Antique and Negros Occidental',
            'category' => 'Heritage / Traditional Source',
            'province' => 'Antique and Negros Occidental',
            'city' => 'San Jose de Buenavista, Sibalom, Bacolod, Bago, La Carlota',
            'farmer_name' => 'Heritage growers and Western Visayas ube source leads',
            'price' => '₱40-60/kg standard when available',
            'status' => 'For Validation',
            'harvest_date' => '2026-05-11',
            'batch_code' => 'UBE-ANT-2026-0041',
            'description' => 'Heritage-style ube listing connected to traditional Kinampay cultivation and Western Visayas ube delicacy production.',
            'icon' => '🍠',
            'thumbnail' => 'uploads/Heritage Ube Kinampay.jpg',
        ],
        [
            'id' => 'UBE-LEY-2026-0052',
            'product_name' => 'Ube Planting Materials - Leyte',
            'category' => 'Research / Planting Material Hub',
            'province' => 'Leyte',
            'city' => 'Baybay, Tacloban, Ormoc',
            'farmer_name' => 'Research partners and local root crop stakeholders',
            'price' => 'Research-based sourcing',
            'status' => 'For Validation',
            'harvest_date' => '2026-05-11',
            'batch_code' => 'UBE-LEY-2026-0052',
            'description' => 'Leyte listing for ube planting materials, propagation leads, and root crop research support channels.',
            'icon' => '🌱',
            'thumbnail' => 'uploads/Ube Planting Materials - Leyte.jpg',
        ],
        [
            'id' => 'UBE-BUK-2026-0059',
            'product_name' => 'Commercial-Grade Ube Supply - Bukidnon',
            'category' => 'Commercial Expansion Area',
            'province' => 'Bukidnon',
            'city' => 'Malaybalay, Valencia, Maramag',
            'farmer_name' => 'Commercial/root crop growers and bulk supply leads',
            'price' => '₱40-60/kg standard',
            'status' => 'For Validation',
            'harvest_date' => '2026-05-11',
            'batch_code' => 'UBE-BUK-2026-0059',
            'description' => 'Bukidnon-based source profile for commercial-grade fresh ube, bulk inquiries, and farm-source procurement validation.',
            'icon' => '🟣',
            'thumbnail' => 'uploads/Commercial-Grade Ube Supply - Bukidnon.jpg',
        ],
    ];
}

function ube_seller_trace_code($seller) {
    $name = strtolower($seller['name'] ?? '');
    $location = strtolower($seller['location'] ?? '');
    if (str_contains($name, 'bren raphael') || str_contains($location, 'rizal') || str_contains($location, 'antipolo')) return 'UBE-RIZ-2026-0027';
    if (str_contains($name, 'conti') || str_contains($location, 'metro manila')) return 'UBE-MET-2026-0001';
    if (str_contains($name, 'good shepherd') || str_contains($location, 'benguet') || str_contains($location, 'baguio')) return 'UBE-BEN-2026-0004';
    if (str_contains($name, 'eng bee tin') || str_contains($location, 'manila') || str_contains($location, 'binondo')) return 'UBE-MET-2026-0001';
    if (str_contains($location, 'bohol')) return 'UBE-BOH-2026-0046';
    if (str_contains($location, 'bukidnon')) return 'UBE-BUK-2026-0059';
    if (str_contains($location, 'leyte')) return 'UBE-LEY-2026-0052';
    if (str_contains($location, 'western visayas') || str_contains($name, 'kinampay')) return 'UBE-ANT-2026-0041';
    return 'UBE-BOH-2026-0046';
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ../login.php');
        exit;
    }
}

/* ── Sample / fallback product data ───────────────────────── */
function sample_products() {
    if (function_exists('ube_source_products')) {
        return ube_source_products();
    }
    return [];
}

/* ── CRUD helpers ──────────────────────────────────────────── */
function get_products() {
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->query('SELECT * FROM products ORDER BY id DESC');
            return $stmt->fetchAll();
        } catch (Exception $e) {}
    }
    return sample_products();
}

function get_product($id_or_code) {
    global $pdo;
    if ($pdo) {
        try {
            $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ? OR batch_code = ? LIMIT 1');
            $stmt->execute([$id_or_code, $id_or_code]);
            $row = $stmt->fetch();
            if ($row) return $row;
        } catch (Exception $e) {}
    }
    foreach (sample_products() as $p) {
        if (
            (string)$p['id'] === (string)$id_or_code ||
            strtolower($p['batch_code']) === strtolower((string)$id_or_code)
        ) {
            return $p;
        }
    }
    return null;
}


function get_products_by_user($email, $user_id = null) {
    global $pdo;
    if (!$pdo || empty($email)) return [];
    try { $pdo->exec("ALTER TABLE products ADD COLUMN owner_type VARCHAR(80) DEFAULT 'Farmer / Cooperative'"); } catch (Exception $e) {}
    try { $pdo->exec("ALTER TABLE products ADD COLUMN submitted_by VARCHAR(120) NULL"); } catch (Exception $e) {}
    try { $pdo->exec("ALTER TABLE products ADD COLUMN seller_id INT NULL"); } catch (Exception $e) {}
    try { $pdo->exec("ALTER TABLE products ADD COLUMN seller_id INT NULL"); } catch (Exception $e) {}
    try {
        if (!empty($user_id)) {
            $stmt = $pdo->prepare('SELECT * FROM products WHERE submitted_by = ? OR seller_id = ? ORDER BY id DESC');
            $stmt->execute([$email, $user_id]);
        } else {
            $stmt = $pdo->prepare('SELECT * FROM products WHERE submitted_by = ? ORDER BY id DESC');
            $stmt->execute([$email]);
        }
        return $stmt->fetchAll();
    } catch (Exception $e) {
        return [];
    }
}

function save_product($data, $id = null) {
    global $pdo;
    if (!$pdo) return false;
    try { $pdo->exec("ALTER TABLE products ADD COLUMN owner_type VARCHAR(80) DEFAULT 'Farmer / Cooperative'"); } catch (Exception $e) {}
    try { $pdo->exec("ALTER TABLE products ADD COLUMN submitted_by VARCHAR(120) NULL"); } catch (Exception $e) {}
    try { $pdo->exec("ALTER TABLE products ADD COLUMN seller_id INT NULL"); } catch (Exception $e) {}

    // Only administrators can publish a record as Verified.
    // Seller submissions are kept in Pending or For Validation until admin review.
    if (!can_verify_products()) {
        $data['status'] = 'For Validation';
    }
    if (empty($data['submitted_by']) && !empty($_SESSION['user_email'])) {
        $data['submitted_by'] = $_SESSION['user_email'];
    }
    if (empty($data['seller_id']) && !empty($_SESSION['user_id'])) {
        $data['seller_id'] = $_SESSION['user_id'];
    }

    $fields = [
        'product_name', 'category', 'province', 'city',
        'farmer_name', 'price', 'status', 'harvest_date',
        'batch_code', 'description', 'icon', 'owner_type', 'submitted_by', 'seller_id',
    ];

    if ($id) {
        $set  = implode(', ', array_map(fn($f) => "$f = ?", $fields));
        $stmt = $pdo->prepare("UPDATE products SET $set WHERE id = ?");
        return $stmt->execute([...array_map(fn($f) => $data[$f] ?? '', $fields), $id]);
    }

    $cols = implode(', ', $fields);
    $qs   = implode(', ', array_fill(0, count($fields), '?'));
    $stmt = $pdo->prepare("INSERT INTO products ($cols) VALUES ($qs)");
    return $stmt->execute(array_map(fn($f) => $data[$f] ?? '', $fields));
}

function delete_product($id) {
    global $pdo;
    if (!$pdo) return false;
    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    return $stmt->execute([$id]);
}

function log_trace($batch_code, $action = 'QR scan') {
    global $pdo;
    if (!$pdo) return false;
    try {
        $stmt = $pdo->prepare('INSERT INTO trace_logs (batch_code, action, scanned_at) VALUES (?, ?, NOW())');
        return $stmt->execute([$batch_code, $action]);
    } catch (Exception $e) {
        return false;
    }
}
