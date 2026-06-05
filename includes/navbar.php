<?php
if (!isset($page_title)) { $page_title = 'PurpleRoots'; }
if (!isset($body_page))  { $body_page  = 'home'; }
$base = (
    strpos($_SERVER['PHP_SELF'], '/products/')     !== false ||
    strpos($_SERVER['PHP_SELF'], '/traceability/') !== false ||
    strpos($_SERVER['PHP_SELF'], '/api/')           !== false
) ? '../' : './';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Dark mode flash prevention -->
    <script>
        try {
            if (localStorage.getItem('pr-theme') === 'dark')
                document.documentElement.setAttribute('data-theme', 'dark');
        } catch(e) {}
    </script>

    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- App CSS -->
    <link href="<?= $base ?>assets/css/style.css" rel="stylesheet">
    <script>
        window.PR_SESSION = {
            loggedIn: <?= !empty($_SESSION['user_email']) ? 'true' : 'false' ?>,
            fullName: <?= json_encode($_SESSION['full_name'] ?? 'PurpleRoots User') ?>,
            email: <?= json_encode($_SESSION['user_email'] ?? '') ?>,
            role: <?= json_encode($_SESSION['user_role'] ?? 'Guest') ?>
        };
    </script>

    <title><?= htmlspecialchars($page_title) ?> | PurpleRoots</title>
</head>
<body data-page="<?= htmlspecialchars($body_page) ?>">

<div id="appNavbar"></div>
