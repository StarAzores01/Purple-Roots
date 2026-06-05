<?php
$page_title = 'View Profile';
$body_page  = 'profile';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/navbar.php';

if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}
$user = get_current_user_profile();
$role = $user['role'] ?? 'Guest';
$canPost = in_array($role, ['Farmer / Cooperative', 'Corporate Seller', 'Processor / Brand', 'Administrator'], true);
$canVerify = strcasecmp($role, 'Administrator') === 0;
$myProducts = get_products_by_user($user['email'] ?? '', $user['id'] ?? ($_SESSION['user_id'] ?? null));
?>

<div class="dashboard-shell">
    <?php include __DIR__ . '/includes/sidebar.php'; ?>
    <main class="dashboard-main">
        <div class="topbar align-items-start">
            <div>
                <span class="eyebrow mb-2"><span class="dot"></span> Account</span>
                <h1 class="fw-black">View Profile</h1>
                <p class="text-muted mb-0">Your PurpleRoots profile and platform access level.</p>
            </div>
            <a href="logout.php" class="btn-pr btn-pr-light"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="profile-card p-4 text-center h-100">
                    <div class="profile-avatar mx-auto mb-3"><?= e(strtoupper(substr($user['full_name'] ?: 'P', 0, 1))) ?></div>
                    <h3 class="fw-black mb-1"><?= e($user['full_name']) ?></h3>
                    <span class="badge-verified d-inline-flex mb-3"><i class="fa-solid fa-id-badge"></i> <?= e($role) ?></span>
                    <p class="text-muted small mb-0">This profile is used to control product posting, marketplace access, and validation permissions.</p>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="table-card p-4 h-100">
                    <h4 class="fw-black mb-3">Profile Information</h4>
                    <div class="profile-info-grid">
                        <div><span>Full name</span><strong><?= e($user['full_name']) ?></strong></div>
                        <div><span>Email</span><strong><?= e($user['email']) ?></strong></div>
                        <div><span>User level</span><strong><?= e($role) ?></strong></div>
                        <div><span>Organization / farm / business</span><strong><?= e($user['organization'] ?: 'Not provided') ?></strong></div>
                        <div><span>Contact number</span><strong><?= e($user['phone'] ?: 'Not provided') ?></strong></div>
                        <div><span>Province</span><strong><?= e($user['province'] ?: 'Not provided') ?></strong></div>
                        <div><span>Municipality / City</span><strong><?= e($user['municipality'] ?: 'Not provided') ?></strong></div>
                        <div><span>Date created</span><strong><?= e($user['created_at'] ?: 'Local session account') ?></strong></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-6">
                <div class="timeline-card p-4 h-100">
                    <h5 class="fw-black">Posting Access</h5>
                    <p class="text-muted mb-3"><?= $canPost ? 'This account can submit products, businesses, and source areas to the platform.' : 'This account can browse marketplace records and product profiles.' ?></p>
                    <?php if ($canPost): ?>
                        <a href="products/add_product.php" class="btn-pr btn-pr-primary"><i class="fa-solid fa-plus"></i> Add Product or Business</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="timeline-card p-4 h-100">
                    <h5 class="fw-black">Validation Access</h5>
                    <p class="text-muted mb-3"><?= $canVerify ? 'Administrator account: you can verify, validate, or keep submitted records under review.' : 'Only administrator accounts can mark products or locations as Verified.' ?></p>
                    <?php if ($canVerify): ?>
                        <a href="products/view_products.php" class="btn-pr btn-pr-light"><i class="fa-solid fa-shield-halved"></i> Review Listings</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="profile-products-section mt-4">
            <div class="table-card p-4">
                <div class="profile-section-header">
                    <div>
                        <span class="eyebrow mb-2"><span class="dot"></span> My submissions</span>
                        <h4 class="fw-black mb-1">Products and Businesses Added</h4>
                        <p class="text-muted mb-0">Listings submitted through your account are displayed here with their current administrator validation status.</p>
                    </div>
                    <?php if ($canPost): ?>
                        <a href="products/add_product.php" class="btn-pr btn-pr-primary"><i class="fa-solid fa-plus"></i> Add Product</a>
                    <?php endif; ?>
                </div>

                <?php if (isset($_GET['product_added']) && $_GET['product_added'] === 'success'): ?>
                    <div class="alert alert-success mt-3">Product added successfully. It is now waiting for administrator validation.</div>
                <?php endif; ?>

                <?php if (!empty($myProducts)): ?>
                    <div class="profile-product-grid mt-4">
                        <?php foreach ($myProducts as $product): ?>
                            <?php
                                $status = $product['status'] ?? 'For Validation';
                                $statusClass = $status === 'Verified' ? 'status-verified' : ($status === 'Rejected' ? 'status-rejected' : 'status-pending');
                            ?>
                            <div class="profile-product-card">
                                <div class="product-card-header">
                                    <div>
                                        <h5 class="fw-black mb-1"><?= e($product['product_name'] ?? 'Untitled product') ?></h5>
                                        <p class="small text-muted mb-0"><?= e($product['category'] ?? 'Product listing') ?></p>
                                    </div>
                                    <span class="status-pill <?= e($statusClass) ?>"><?= e($status) ?></span>
                                </div>
                                <div class="product-meta">
                                    <p><strong>Owner type:</strong> <?= e($product['owner_type'] ?? $role) ?></p>
                                    <p><strong>Location:</strong> <?= e($product['city'] ?? 'Not provided') ?>, <?= e($product['province'] ?? 'Not provided') ?></p>
                                    <p><strong>Batch code:</strong> <?= e($product['batch_code'] ?? 'Not generated') ?></p>
                                    <p><strong>Price / supply note:</strong> <?= e($product['price'] ?? 'Not provided') ?></p>
                                    <p><strong>Date submitted:</strong> <?= !empty($product['created_at']) ? e(date('F d, Y', strtotime($product['created_at']))) : 'Recently added' ?></p>
                                </div>
                                <div class="product-actions">
                                    <a href="products/product_details.php?id=<?= e($product['id'] ?? $product['batch_code']) ?>" class="btn-outline-pr">View Details</a>
                                    <?php if ($canPost || $canVerify): ?>
                                        <a href="products/edit_product.php?id=<?= e($product['id'] ?? '') ?>" class="btn-outline-pr">Edit</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state mt-4">
                        <h5 class="fw-black">No products added yet</h5>
                        <p class="text-muted mb-3">When you add a product, business, or source listing, it will appear here together with its validation status.</p>
                        <?php if ($canPost): ?>
                            <a href="products/add_product.php" class="btn-pr btn-pr-primary">Add Your First Product</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </main>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
