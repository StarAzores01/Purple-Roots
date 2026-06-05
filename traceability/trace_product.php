<?php
$page_title = 'Trace Product';
$body_page  = 'traceability';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/ube_data.php';
include __DIR__ . '/../includes/navbar.php';
$code = $_GET['code'] ?? ($ube_regions[0]['batch_code'] ?? '');
$area = find_ube_area($code) ?: $ube_regions[0];
$bars = ube_barcode_bars($area['batch_code']);
?>
<section class="page-hero"><div class="container"><span class="eyebrow mb-3"><span class="dot"></span> Traceability</span><h1 class="fw-black display-5">Trace Philippine Ube Source</h1><p class="lead-copy">Verify the source profile, products, municipality information, reach-out route, and validation status.</p></div></section>
<section class="section-small"><div class="container"><div class="row g-4"><div class="col-lg-5"><div class="profile-card p-4 text-center"><img class="profile-thumb mb-3" src="../<?= e($area['thumbnail']) ?>" alt="thumbnail"><h3 class="fw-black"><?= e($area['province']) ?></h3><p class="text-muted"><?= e($area['region']) ?></p><img class="qr-img-lg" src="<?= e(ube_qr_url(ube_source_reach_url($area), 200)) ?>" alt="QR code"><div class="barcode mt-3"><?php foreach($bars as $w): ?><span style="width:<?= intval($w) ?>px"></span><?php endforeach; ?></div><p class="small text-muted mt-2"><?= e($area['batch_code']) ?></p></div></div><div class="col-lg-7"><div class="timeline-card p-4"><span class="badge-verified mb-3 d-inline-block"><?= e($area['status']) ?></span><h4 class="fw-bold">Source Details</h4><p><?= e($area['description']) ?></p><p><strong>Municipalities:</strong> <?= e(implode(', ', $area['municipalities'])) ?></p><p><strong>Products:</strong> <?= e(implode(', ', $area['products'])) ?></p><p><strong>Price / position:</strong> <?= e($area['price']) ?></p><h5 class="fw-bold mt-4">Production Information</h5><ul><?php foreach($area['production'] as $k=>$v): ?><li><strong><?= e($k) ?>:</strong> <?= e($v) ?></li><?php endforeach; ?></ul><h5 class="fw-bold mt-4">Reach Out</h5><p class="mb-1"><strong>Office:</strong> <?= e($area['contact']['office']) ?></p><p class="mb-1"><strong>Phone:</strong> <?= e($area['contact']['phone']) ?></p><p class="mb-0"><strong>Email:</strong> <?= e($area['contact']['email']) ?></p></div></div></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
