<?php
$page_title = 'Generate QR';
$body_page  = 'traceability';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/ube_data.php';
include __DIR__ . '/../includes/navbar.php';
$code = $_GET['code'] ?? ($ube_regions[0]['batch_code'] ?? '');
$area = find_ube_area($code) ?: $ube_regions[0];
$qrText = ube_source_reach_url($area);
$bars = ube_barcode_bars($area['batch_code']);
?>
<section class="auth-wrap"><div class="container"><div class="form-card mx-auto text-center"><span class="eyebrow mb-3"><span class="dot"></span> QR / Barcode</span><h2 class="fw-black"><?= e($area['batch_code']) ?></h2><p class="text-muted mb-3"><?= e($area['province']) ?> • <?= e($area['badge']) ?></p><a href="<?= e($qrText) ?>" target="_blank" rel="noopener"><img class="qr-img-lg" src="<?= e(ube_qr_url($qrText, 220)) ?>" alt="QR code"></a><div class="barcode mt-3"><?php foreach($bars as $w): ?><span style="width:<?= intval($w) ?>px"></span><?php endforeach; ?></div><p class="text-muted mt-3">QR routes users to the selected source/reach-out information. The barcode is a local visual identifier generated from the batch code.</p><a href="trace_product.php?code=<?= urlencode($area['batch_code']) ?>" class="btn-pr btn-pr-primary">Open trace page</a></div></div></section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
