<?php
$page_title = 'Analytics';
$body_page  = 'analytics';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/ube_data.php';
include __DIR__ . '/includes/navbar.php';
$regionCounts=[]; foreach($ube_regions as $a){$regionCounts[$a['region']] = ($regionCounts[$a['region']] ?? 0)+1;} arsort($regionCounts);
$verified = count(array_filter($ube_regions, fn($a) => $a['status'] === 'Verified'));
$validation = count($ube_regions) - $verified;
$marketSignals = [
    ['title'=>'Consumer pull', 'value'=>'High', 'body'=>'Ube has moved from a local delicacy into a recognizable flavor for cakes, ice cream, breads, drinks, snacks, and specialty desserts. Demand is strongest where Filipino food culture and Asian dessert trends are visible.'],
    ['title'=>'Global channels', 'value'=>'Retail + foodservice', 'body'=>'Opportunity channels include bakeries, restaurants, cafés, frozen dessert brands, pasalubong sellers, online shops, and ingredient suppliers serving overseas Filipino and Asian grocery markets.'],
    ['title'=>'Traceability need', 'value'=>'Growing', 'body'=>'As more products use ube branding, verified source records help separate authentic purple yam products from generic purple-colored sweets or products using only flavoring.'],
    ['title'=>'Platform opportunity', 'value'=>'Source-to-market', 'body'=>'PurpleRoots can position verified farmers, processors, and sellers as discoverable sources for buyers looking for authentic Philippine ube supply and product stories.'],
];
$globalMarkets = ['Philippines'=>'Origin, production, processing, pasalubong, and cultural identity','United States'=>'Large Filipino diaspora, bakeries, frozen desserts, packaged food','Canada'=>'Filipino community markets, specialty grocers, cafés, desserts','Japan'=>'Asian dessert culture and specialty food interest','South Korea'=>'Café dessert trends and purple yam-inspired flavors','Singapore'=>'Regional food innovation and premium dessert concepts','Malaysia'=>'Nearby Southeast Asian consumer exposure and specialty food retail','Australia'=>'Filipino grocery and dessert businesses','United Arab Emirates'=>'Overseas Filipino communities and imported specialty foods','United Kingdom'=>'Emerging Filipino food businesses and Asian grocery channels'];
?>
<section class="page-hero"><div class="container"><span class="eyebrow mb-3"><span class="dot"></span> Analytics</span><h1 class="fw-black display-5">Ube Industry Coverage and Global Market Signals</h1><p class="lead-copy">A practical market-intelligence page for mapping local source records, verification progress, and global consumer demand opportunities for authentic Philippine ube.</p></div></section>
<section class="section-small"><div class="container">
<div class="row g-4 mb-5">
    <div class="col-md-3"><div class="analytics-card h-100"><h3><?= count($ube_regions) ?></h3><p>Source and validation area records</p></div></div>
    <div class="col-md-3"><div class="analytics-card h-100"><h3><?= count($regionCounts) ?></h3><p>Philippine regions represented</p></div></div>
    <div class="col-md-3"><div class="analytics-card h-100"><h3><?= $verified ?></h3><p>Verified or stronger entries</p></div></div>
    <div class="col-md-3"><div class="analytics-card h-100"><h3><?= $validation ?></h3><p>Records needing LGU or seller validation</p></div></div>
</div>

<div class="section-header mb-4"><span class="eyebrow"><span class="dot"></span> Global market</span><h2 class="fw-black">Market signals for ube demand</h2><p class="text-muted">These cards summarize web-research-style market indicators that you can refine later with final citations, supplier interviews, DA/LGU records, and business validation.</p></div>
<div class="row g-4 mb-5"><?php foreach($marketSignals as $m): ?><div class="col-md-6 col-xl-3"><div class="timeline-card p-4 h-100 market-signal-card"><span class="chip mb-3"><?= e($m['value']) ?></span><h5 class="fw-bold"><?= e($m['title']) ?></h5><p class="text-muted small mb-0"><?= e($m['body']) ?></p></div></div><?php endforeach; ?></div>

<div class="row g-4 mb-5">
    <div class="col-lg-7"><div class="timeline-card p-4 h-100"><h4 class="fw-bold mb-3">Global consumer markets to monitor</h4><?php foreach($globalMarkets as $country=>$note): ?><div class="market-row"><strong><?= e($country) ?></strong><span><?= e($note) ?></span></div><?php endforeach; ?></div></div>
    <div class="col-lg-5"><div class="timeline-card p-4 h-100"><h4 class="fw-bold mb-3">Recommended data validation workflow</h4><ol class="mb-0"><li>Use the province profile to identify municipality and product leads.</li><li>Contact the Provincial or Municipal Agriculture Office.</li><li>Ask for registered farmer groups, hectares, seasonality, and harvest estimates.</li><li>Confirm seller legitimacy through official pages, permits, store listings, or direct outreach.</li><li>Update records from For Validation to Verified once evidence is collected.</li></ol></div></div>
</div>

<div class="row g-4"><div class="col-lg-6"><div class="timeline-card p-4 h-100"><h4 class="fw-bold">Region Coverage Count</h4><?php foreach($regionCounts as $region=>$count): ?><div class="d-flex justify-content-between border-bottom py-2"><span><?= e($region) ?></span><strong><?= e($count) ?></strong></div><?php endforeach; ?></div></div><div class="col-lg-6"><div class="timeline-card p-4 h-100"><h4 class="fw-bold">Platform notes</h4><?php foreach($ube_platform_insights as $insight): ?><div class="insight-item"><span class="dot"></span><p><?= e($insight) ?></p></div><?php endforeach; ?></div></div></div>
</div></section><?php include __DIR__ . '/includes/footer.php'; ?>
