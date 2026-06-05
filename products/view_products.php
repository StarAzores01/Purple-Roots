<?php
$page_title = 'View Products';
$body_page  = 'products';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/ube_data.php';
include    __DIR__ . '/../includes/navbar.php';
$userRole = $_SESSION['user_role'] ?? 'Guest';
$canPost = can_add_product();
$canVerify = can_verify_products();
?>

<div class="dashboard-shell">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <main class="dashboard-main">
        <div class="topbar align-items-start">
            <div>
                <span class="eyebrow mb-2"><span class="dot"></span> Products</span>
                <h1 class="fw-black">Ube Source Management</h1>
                <p class="text-muted mb-2">Manage Philippine ube product sources, production areas, verified suppliers, and validation leads.</p>
                <span class="chip">Current access: <?= e($userRole) ?> · <?= $canPost ? 'Product posting enabled' : 'Browsing access' ?></span>
            </div>
            <?php if ($canPost): ?><a href="add_product.php" class="btn-pr btn-pr-primary"><i class="fa-solid fa-plus"></i> Add Product</a><?php else: ?><a href="../login.php" class="btn-pr btn-pr-light">Log in to add products</a><?php endif; ?>
        </div>

        <div class="source-table-tools mb-3">
            <div>
                <strong>National source records</strong>
                <p class="small text-muted mb-0">Use this table to review area profiles, product types, and traceability status before publishing to the marketplace.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <span class="chip"><?= count($ube_regions) ?> area records</span>
                <span class="chip"><?= count($ube_companies) ?> seller examples</span>
            </div>
        </div>

        <div class="table-card source-table-card">
            <div class="table-responsive">
                <table class="table mb-0 source-table">
                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Source Area</th>
                            <th>Region / Municipality</th>
                            <th>Products</th>
                            <th>Validation</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ube_regions as $area): ?>
                        <tr>
                            <td><span class="batch-pill"><?= e($area['batch_code']) ?></span></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="mini-map" style="background-image:url('../<?= e($area['thumbnail']) ?>')"></div>
                                    <div><strong><?= e($area['province']) ?></strong><br><span class="small text-muted"><?= e($area['category']) ?></span></div>
                                </div>
                            </td>
                            <td><?= e($area['region']) ?><br><span class="small text-muted"><?= e(implode(', ', array_slice($area['municipalities'], 0, 4))) ?></span></td>
                            <td><?= e(implode(', ', array_slice($area['products'], 0, 3))) ?></td>
                            <td><span class="<?= $area['status'] === 'Verified' ? 'badge-verified' : 'chip' ?>"><?= e($area['status']) ?></span></td>
                            <td class="text-end action-stack">
                                <a class="btn btn-sm btn-outline-primary" href="product_details.php?id=<?= e($area['id']) ?>">View</a>
                                <?php if ($canPost): ?><a class="btn btn-sm btn-outline-secondary" href="edit_product.php?id=<?= e($area['id']) ?>">Edit</a><?php endif; ?>
                                <?php if ($canVerify): ?>
                                    <a class="btn btn-sm btn-outline-success" href="verify_product.php?id=<?= e($area['id']) ?>&status=Verified">Validate</a>
                                    <a class="btn btn-sm btn-outline-warning" href="verify_product.php?id=<?= e($area['id']) ?>&status=For Validation">Hold</a>
                                    <a class="btn btn-sm btn-outline-danger" href="delete_product.php?id=<?= e($area['id']) ?>">Delete</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
