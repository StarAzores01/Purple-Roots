<?php
$page_title = 'Delete Product';
$body_page  = 'products';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
include    __DIR__ . '/../includes/navbar.php';

if (isset($_GET['id'])) {
    delete_product($_GET['id']);
}
?>

<section class="auth-wrap">
    <div class="container">
        <div class="form-card mx-auto text-center">

            <h2 class="fw-black">Product deleted</h2>
            <p class="text-muted">
                If MySQL is not connected, demo records cannot be deleted permanently.
            </p>
            <a href="view_products.php" class="btn-pr btn-pr-primary">
                Back to products
            </a>

        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
