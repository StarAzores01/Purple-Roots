<?php
$page_title = 'Edit Product';
$body_page  = 'products';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
if (!is_logged_in()) { header('Location: ../login.php'); exit; }
if (!can_add_product()) { header('Location: view_products.php?error=posting_denied'); exit; }
include    __DIR__ . '/../includes/navbar.php';
?>

<?php
$editing = isset($_GET['id']);
$product = $editing ? get_product($_GET['id']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    save_product($_POST, $editing ? $_GET['id'] : null);
    header('Location: view_products.php');
    exit;
}
?>

<div class="dashboard-shell">

    <?php include __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="dashboard-main">

        <!-- Topbar -->
        <div class="topbar">
            <div>
                <span class="eyebrow mb-2"><span class="dot"></span> Products</span>
                <h1 class="fw-black"><?= $editing ? 'Edit Product' : 'Add Product' ?></h1>
            </div>
        </div>

        <!-- Form -->
        <form method="post" class="form-card" style="max-width:900px">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Product name</label>
                    <input name="product_name" class="form-control" required
                           value="<?= e($product['product_name'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <input name="category" class="form-control"
                           value="<?= e($product['category'] ?? 'Raw Ube') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Province</label>
                    <input name="province" class="form-control"
                           value="<?= e($product['province'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">City</label>
                    <input name="city" class="form-control"
                           value="<?= e($product['city'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Supplier / farmer</label>
                    <input name="farmer_name" class="form-control"
                           value="<?= e($product['farmer_name'] ?? '') ?>">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input name="price" class="form-control"
                           value="<?= e($product['price'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <?php if (can_verify_products()): ?>
                        <select name="status" class="form-select">
                            <option <?= (($product['status'] ?? '') === 'Verified') ? 'selected' : '' ?>>Verified</option>
                            <option <?= (($product['status'] ?? '') === 'Pending') ? 'selected' : '' ?>>Pending</option>
                            <option <?= (($product['status'] ?? 'For Validation') === 'For Validation') ? 'selected' : '' ?>>For Validation</option>
                        </select>
                        <div class="form-text">Administrator access: you can publish verified records.</div>
                    <?php else: ?>
                        <input type="hidden" name="status" value="For Validation">
                        <input class="form-control" value="For Validation" disabled>
                        <div class="form-text">Seller submissions require administrator validation before being marked Verified.</div>
                    <?php endif; ?>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Harvest date</label>
                    <input type="date" name="harvest_date" class="form-control"
                           value="<?= e($product['harvest_date'] ?? '') ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Batch code</label>
                    <input name="batch_code" class="form-control"
                           value="<?= e($product['batch_code'] ?? 'UBE-' . date('mdy') . '-' . rand(1000, 9999)) ?>">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Icon</label>
                    <input name="icon" class="form-control"
                           value="<?= e($product['icon'] ?? '🍠') ?>">
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control"><?= e($product['description'] ?? '') ?></textarea>
                </div>

            </div>

            <button class="btn-pr btn-pr-primary mt-4">Save Product</button>
            <a href="view_products.php" class="btn-pr btn-pr-light mt-4">Cancel</a>
        </form>

    </main>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
