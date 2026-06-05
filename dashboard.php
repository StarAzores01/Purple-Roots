<?php
$page_title = 'Dashboard';
$body_page  = 'dashboard';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/ube_data.php';
include __DIR__ . '/includes/navbar.php';
$verified = count(array_filter($ube_regions, fn($a) => $a['status'] === 'Verified'));
$regions = count(array_unique(array_map(fn($a) => $a['region'], $ube_regions)));
$companies = count($ube_companies);
$featuredMaps = array_values(array_filter($ube_regions, fn($a) => in_array($a['province'], ['Bohol','Quezon','Pampanga','Batangas','Bukidnon','Leyte','Antique','Negros Occidental'])));
?>
<section class="page-hero"><div class="container"><span class="eyebrow mb-3"><span class="dot"></span> Dashboard</span><h1 class="fw-black display-5">PurpleRoots National Ube Dashboard</h1><p class="lead-copy">A broader view of Philippine ube source leads, verified production areas, validation areas, businesses, products, and traceability records.</p></div></section>
<section class="section-small pt-0"><div class="container">
    <div class="theme-banner-card mb-4">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
            <div>
                <span class="eyebrow"><span class="dot"></span> Consumer market banner</span>
                <h3 class="fw-black mb-1">Global Ube Market Overview</h3>
                <p class="text-muted mb-0">Highlights major ube consumer markets, diaspora demand centers, and regional opportunity areas for Philippine purple yam products.</p>
            </div>
            <span class="chip">Global demand view</span>
        </div>
        <div class="theme-banner-wrap">
            <img src="uploads/dashboard_banner_light.png" alt="Global ube consumer map light mode banner" class="theme-banner-img banner-light">
            <img src="uploads/dashboard_banner_dark.png" alt="Global ube consumer map dark mode banner" class="theme-banner-img banner-dark">
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3"><div class="stat-card"><h3><?= count($ube_regions) ?></h3><p>Province / Area Records</p></div></div>
        <div class="col-md-3"><div class="stat-card"><h3><?= $regions ?></h3><p>Regions Covered</p></div></div>
        <div class="col-md-3"><div class="stat-card"><h3><?= $verified ?></h3><p>Verified / Stronger Entries</p></div></div>
        <div class="col-md-3"><div class="stat-card"><h3><?= $companies ?></h3><p>Business / Seller Examples</p></div></div>
    </div>

    <div class="section-header mb-4">
        <span class="eyebrow"><span class="dot"></span> Featured location maps</span>
        <h2 class="fw-black">Satellite and Violet Geographical Thumbnails</h2>
        <p class="text-muted">Key documented source areas use detailed satellite or geographic map imagery. Validation entries use a PurpleRoots-styled Philippines location thumbnail.</p>
    </div>
    <div class="row g-4 mb-5">
        <?php foreach ($featuredMaps as $area): ?>
        <div class="col-md-6 col-xl-3">
            <a class="text-decoration-none" href="farmer-profile.php?province=<?= urlencode($area['province']) ?>">
                <div class="product-card h-100">
                    <div class="product-img product-thumb" style="background-image:url('<?= e($area['thumbnail']) ?>')"></div>
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <h6 class="fw-bold mb-0 text-dark"><?= e($area['province']) ?></h6>
                            <span class="chip"><?= e($area['status']) ?></span>
                        </div>
                        <p class="small text-muted mb-0 mt-2"><?= e($area['region']) ?></p>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="table-wrapper source-table-wrap"><table class="data-table source-table"><thead><tr><th>Region</th><th>Province / Area</th><th>Municipalities</th><th>Known Products</th><th>Status</th><th>Profile</th></tr></thead><tbody>
    <?php foreach ($ube_regions as $area): ?><tr><td><?= e($area['region']) ?></td><td><?= e($area['province']) ?></td><td><?= e(implode(', ', array_slice($area['municipalities'],0,4))) ?></td><td><?= e(implode(', ', array_slice($area['products'],0,3))) ?></td><td><?= e($area['status']) ?></td><td><a href="farmer-profile.php?province=<?= urlencode($area['province']) ?>">View</a></td></tr><?php endforeach; ?>
    </tbody></table></div>
</div></section><?php include __DIR__ . '/includes/footer.php'; ?>
