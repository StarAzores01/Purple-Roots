<?php
$page_title = 'Farmer Profile';
$body_page  = 'farmer';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/ube_data.php';

$selectedProvince = $_GET['province'] ?? $ube_regions[0]['province'];
$selectedArea = find_ube_area($selectedProvince) ?: $ube_regions[0];
$qrText = $selectedArea['contact']['qr_data'] ?? ($selectedArea['province'] . ' PurpleRoots inquiry');
$bars = ube_barcode_bars($selectedArea['batch_code']);
include __DIR__ . '/includes/navbar.php';
?>

<section class="page-hero">
    <div class="container">
        <span class="eyebrow mb-3"><span class="dot"></span> Farmer / Source Profile</span>
        <h1 class="fw-black display-5"><?= e($selectedArea['province']) ?></h1>
        <p class="lead-copy"><?= e($selectedArea['description']) ?></p>
        <p class="small text-muted mb-0">Status: <?= e($selectedArea['status']) ?> • <?= e($selectedArea['batch_code']) ?></p>
    </div>
</section>

<section class="section-small">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3">
                <div class="timeline-card p-3 sticky-profile-list">
                    <h5 class="fw-bold mb-3">Province / Area Directory</h5>
                    <?php foreach ($ube_regions as $area): ?>
                        <a class="profile-link d-block mb-2 <?= $area['province'] === $selectedArea['province'] ? 'active' : '' ?>" href="farmer-profile.php?province=<?= urlencode($area['province']) ?>">
                            <?= e($area['province']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="profile-card p-4 mb-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5">
                            <img class="profile-thumb" src="<?= e($selectedArea['thumbnail']) ?>" alt="<?= e($selectedArea['province']) ?> thumbnail">
                        </div>
                        <div class="col-md-7">
                            <span class="badge-verified mb-3 d-inline-block"><i class="fa-solid fa-circle-check"></i> <?= e($selectedArea['badge']) ?></span>
                            <h3 class="fw-black"><?= e($selectedArea['province']) ?></h3>
                            <p class="text-muted mb-1"><?= e($selectedArea['region']) ?></p>
                            <p><?= e($selectedArea['description']) ?></p>
                            <p class="mb-0"><strong>Estimated price / position:</strong> <?= e($selectedArea['price']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6"><div class="timeline-card p-4 h-100"><h5 class="fw-bold">Municipalities / Areas</h5><ul class="mb-0"><?php foreach ($selectedArea['municipalities'] as $m): ?><li><?= e($m) ?></li><?php endforeach; ?></ul></div></div>
                    <div class="col-md-6"><div class="timeline-card p-4 h-100"><h5 class="fw-bold">Known Ube Products</h5><ul class="mb-0"><?php foreach ($selectedArea['products'] as $product): ?><li><?= e($product) ?></li><?php endforeach; ?></ul></div></div>
                    <div class="col-md-6"><div class="timeline-card p-4 h-100"><h5 class="fw-bold">Farmer / Seller Setup</h5><ul class="mb-0"><?php foreach ($selectedArea['farmer_groups'] as $group): ?><li><?= e($group) ?></li><?php endforeach; ?></ul></div></div>
                    <div class="col-md-6"><div class="timeline-card p-4 h-100"><h5 class="fw-bold">Production Details</h5><ul class="mb-0"><?php foreach ($selectedArea['production'] as $label => $value): ?><li><strong><?= e($label) ?>:</strong> <?= e($value) ?></li><?php endforeach; ?></ul></div></div>
                </div>

                <div class="timeline-card p-4 mt-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-8">
                            <h5 class="fw-bold">Reach-Out Information</h5>
                            <p class="mb-1"><strong>Office:</strong> <?= e($selectedArea['contact']['office']) ?></p>
                            <p class="mb-1"><strong>Phone:</strong> <?= e($selectedArea['contact']['phone']) ?></p>
                            <p class="mb-3"><strong>Email:</strong> <?= e($selectedArea['contact']['email']) ?></p>
                            <a class="btn-pr btn-pr-primary" href="traceability/trace_product.php?code=<?= urlencode($selectedArea['batch_code']) ?>">Open Traceability Page</a>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="<?= e($qrText) ?>" target="_blank" rel="noopener"><img class="qr-img-lg" src="<?= e(ube_qr_url($qrText, 180)) ?>" alt="QR reach-out code"></a>
                            <div class="barcode mt-3" aria-label="barcode">
                                <?php foreach ($bars as $w): ?><span style="width:<?= intval($w) ?>px"></span><?php endforeach; ?>
                            </div>
                            <p class="small text-muted mt-2 mb-0"><?= e($selectedArea['batch_code']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
