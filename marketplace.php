<?php
$page_title = 'Marketplace';
$body_page  = 'marketplace';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/ube_data.php';
include    __DIR__ . '/includes/navbar.php';
$categories = array_values(array_unique(array_map(fn($a) => $a['category'], $ube_regions)));
sort($categories);
?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow mb-3"><span class="dot"></span> Marketplace</span>
        <h1 class="fw-black display-5">National Philippine Ube Source Directory</h1>
        <p class="lead-copy">
            Browse province-level ube production leads, known ube product areas, market hubs,
            farmer/seller profiles, and QR-enabled reach-out cards across the Philippines.
        </p>
        <p class="small text-muted mb-0">Note: entries marked For Validation should be verified with DA, Provincial Agriculture Offices, Municipal Agriculture Offices, or official seller channels before commercial sourcing.</p>
    </div>
</section>

<section class="section-small">
    <div class="container">
        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <input class="form-control" data-search-products placeholder="Search province, region, municipality, product, farmer group, or company">
            </div>
            <div class="col-md-4">
                <select class="form-select" data-category-filter>
                    <option value="">All categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option><?= e($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <?php foreach ($ube_regions as $area): ?>
            <div class="col-sm-6 col-xl-4 product-item" data-category="<?= e($area['category']) ?>">
                <div class="product-card h-100">
                    <div class="product-img product-thumb" style="background-image:url('<?= e($area['thumbnail']) ?>')">
                        <span class="position-absolute top-0 end-0 m-3 badge-verified <?= $area['status'] === 'Verified' ? '' : 'badge-warning' ?>">
                            <i class="fa-solid fa-circle-check"></i> <?= e($area['status']) ?>
                        </span>
                    </div>
                    <div class="p-4">
                        <div class="d-flex justify-content-between gap-2">
                            <span class="chip"><?= e($area['badge']) ?></span>
                            <span class="small text-muted text-end"><?= e($area['region']) ?></span>
                        </div>
                        <h5 class="fw-bold mt-3"><?= e($area['province']) ?></h5>
                        <p class="text-muted small mb-2"><?= e($area['description']) ?></p>
                        <p class="small mb-2"><strong>Municipalities:</strong> <?= e(implode(', ', array_slice($area['municipalities'], 0, 5))) ?></p>
                        <p class="small mb-3"><strong>Products:</strong> <?= e(implode(', ', array_slice($area['products'], 0, 4))) ?></p>
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <strong class="gradient-text"><?= e($area['price']) ?></strong>
                            <a class="btn-pr btn-pr-light btn-sm" href="farmer-profile.php?province=<?= urlencode($area['province']) ?>">View Profile</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="section-header mb-4">
            <span class="eyebrow"><span class="dot"></span> Companies and Product Sellers</span>
            <h2 class="fw-black">Ube Product Businesses and Market Examples</h2>
            <p class="text-muted">These are starting points for seller validation. Confirm legitimacy through official business channels before transactions.</p>
        </div>
        <div class="row g-4">
            <?php foreach ($ube_companies as $company): ?>
                <div class="col-md-6 col-xl-3">
                    <div class="product-card h-100">
                        <div class="product-img product-thumb-sm" style="background-image:url('<?= e($company['thumbnail']) ?>')"></div>
                        <div class="p-4">
                            <span class="chip"><?= e($company['type']) ?></span>
                            <h5 class="fw-bold mt-3"><?= e($company['name']) ?></h5>
                            <p class="small text-muted mb-2"><?= e($company['location']) ?></p>
                            <p class="small mb-2"><strong>Code:</strong> <?= e($company['seller_code'] ?? ('SELL-' . $company['id'])) ?></p>
                            <p class="small mb-2"><strong>Products:</strong> <?= e($company['products']) ?></p>
                            <p class="small mb-2"><strong>Basic info:</strong> <?= e($company['info'] ?? 'Ube business or seller profile') ?></p>
                            <p class="small mb-3"><strong>Reach-out:</strong> scan the QR to open the best available official page, Messenger page, or government validation search for this seller.</p>
                            <div class="d-flex align-items-center justify-content-between gap-3 mt-3">
                                <a href="<?= e(ube_seller_reach_url($company)) ?>" target="_blank" rel="noopener"><img class="qr-img" src="<?= e(ube_qr_url(ube_seller_reach_url($company), 120)) ?>" alt="QR for <?= e($company['name']) ?>"></a>
                                <div class="d-flex flex-column gap-2">
                                    <a class="btn-pr btn-pr-primary btn-sm" href="traceability/trace_product.php?code=<?= urlencode(ube_seller_trace_code($company)) ?>">Trace Product</a>
                                    <a class="btn-pr btn-pr-light btn-sm" href="<?= e(ube_seller_reach_url($company)) ?>" target="_blank" rel="noopener">Reach Out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
