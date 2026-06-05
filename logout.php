<?php
$page_title = 'Logout';
$body_page  = 'logout';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
include    __DIR__ . '/includes/navbar.php';

session_destroy();
?>

<section class="auth-wrap">
    <div class="container">
        <div class="form-card mx-auto text-center">
            <h2 class="fw-black">You have been logged out.</h2>
            <a href="index.php" class="btn-pr btn-pr-primary mt-3">
                Back to home
            </a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
