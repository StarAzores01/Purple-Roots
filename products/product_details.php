<?php
$page_title = 'Product Details';
$body_page  = 'products';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/ube_data.php';
$id = $_GET['id'] ?? $_GET['code'] ?? 1;
$product = get_product($id);
foreach (ube_home_featured_products() as $fp) {
    if ((string)($fp['batch_code'] ?? '') === (string)$id || (string)($fp['id'] ?? '') === (string)$id) { $product = $fp; break; }
}
$area = $product ? find_ube_area($product['batch_code'] ?? $product['province']) : null;
$productThumb = $product ? ube_featured_product_thumbnail($product) : 'uploads/logo.png';
include __DIR__ . '/../includes/navbar.php';
?>
<section class="page-hero"><div class="container"><span class="eyebrow mb-3"><span class="dot"></span> Product Details</span><h1 class="fw-black display-5"><?= e($product['product_name'] ?? 'Product not found') ?></h1></div></section>
<section class="section-small"><div class="container"><?php if($product): ?><div class="row g-4"><div class="col-lg-5"><div class="profile-card p-4 text-center"><img class="profile-thumb mb-3" src="../<?= e($productThumb) ?>" alt="thumbnail"><?php if($area): ?><a href="<?= e(ube_source_reach_url($area)) ?>" target="_blank" rel="noopener"><img class="qr-img-lg" src="<?= e(ube_qr_url(ube_source_reach_url($area), 180)) ?>" alt="QR reach-out code"></a><p class="small text-muted mt-2 mb-0">Scan to open the official validation/search channel for this source area.</p><?php endif; ?></div></div><div class="col-lg-7"><div class="timeline-card p-4"><h3 class="fw-black"><?= e($product['product_name']) ?></h3><p><?= e($product['description']) ?></p><p><strong>Category:</strong> <?= e($product['category']) ?></p><p><strong>Province:</strong> <?= e($product['province']) ?></p><p><strong>Municipalities:</strong> <?= e($product['city']) ?></p><p><strong>Farmer / Seller:</strong> <?= e($product['farmer_name']) ?></p><p><strong>Price:</strong> <?= e($product['price']) ?></p><p><strong>Status:</strong> <?= e($product['status']) ?></p><p><strong>Batch Code:</strong> <?= e($product['batch_code']) ?></p><a class="btn-pr btn-pr-primary" href="../traceability/trace_product.php?code=<?= urlencode($product['batch_code']) ?>">Trace Product</a></div></div></div><?php else: ?><div class="timeline-card p-4"><p>Product not found.</p></div><?php endif; ?></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
