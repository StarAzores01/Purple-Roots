<?php
$page_title = 'Philippine Ube Traceability Platform';
$body_page  = 'home';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/ube_data.php';
$sourceCount = count($ube_regions);
$clusterCount = count(array_unique(array_map(fn($a) => $a['region'], $ube_regions)));
$sellerCount = count($ube_companies);
include    __DIR__ . '/includes/navbar.php';
?>

<!-- ── Hero ──────────────────────────────────────────────────── -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Left: copy -->
            <div class="col-lg-6">
                <span class="eyebrow mb-4">
                    <span class="dot"></span> Philippine ube traceability platform
                </span>

                <h1 class="display-title mb-4">
                    Authentic <span class="gradient-text">Philippine Ube</span>,
                    traceable from farm to market.
                </h1>

                <p class="lead-copy mb-4">
                    PurpleRoots connects farmers, cooperatives, local brands, exporters,
                    and consumers through QR verification, farmer profiles, product listings,
                    and transparent batch histories.
                </p>

                <div class="d-flex flex-wrap gap-3 mb-5">
                    <a href="traceability/trace_product.php" class="btn-pr btn-pr-primary">
                        <i class="fa-solid fa-qrcode"></i> Verify product
                    </a>
                    <a href="marketplace.php" class="btn-pr btn-pr-light">
                        <i class="fa-solid fa-store"></i> Explore marketplace
                    </a>
                </div>

                <div class="row g-3">
                    <div class="col-4">
                        <div class="stat-card">
                            <div class="stat-value" data-counter="<?= $sourceCount ?>">0</div>
                            <div class="small text-muted fw-semibold">Province / area records</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <div class="stat-value" data-counter="<?= $clusterCount ?>">0</div>
                            <div class="small text-muted fw-semibold">Regions covered</div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-card">
                            <div class="stat-value" data-counter="<?= $sellerCount ?>">0</div>
                            <div class="small text-muted fw-semibold">Seller profiles</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: phone mockup -->
            <div class="col-lg-6">
                <div class="hero-visual">
                    <div class="phone-card">
                        <div class="phone-screen">
                            <span class="badge-verified bg-white">
                                <i class="fa-solid fa-circle-check"></i> Verified Ube Batch
                            </span>

                            <div class="qr-box">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= urlencode('PurpleRoots reach-out request | Bohol | Region VII - Central Visayas | UBE-BOH-2026-0046') ?>"
                                     alt="QR code – Bohol Ubi Growers Association"
                                     style="width:130px;height:130px;border-radius:8px;display:block;margin:auto">
                            </div>

                            <h4 class="fw-bold text-center">UBE-BOH-2026-0001</h4>
                            <p class="text-center opacity-75">
                                Bohol Ubi Growers Association &bull; Central Visayas
                            </p>

                            <div class="timeline mt-4">
                                <div class="timeline-item">
                                    <strong>Farm registered</strong>
                                    <div class="small opacity-75">Panglao, Guindulman, Corella, Bilar, Dauis</div>
                                </div>
                                <div class="timeline-item">
                                    <strong>Harvest validated</strong>
                                    <div class="small opacity-75">April 18, 2026</div>
                                </div>
                                <div class="timeline-item">
                                    <strong>Quality checked</strong>
                                    <div class="small opacity-75">Heirloom Ube Kinampay source documented</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="section-small pt-0">
    <div class="container">
        <div class="theme-banner-card">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
                <div>
                    <span class="eyebrow"><span class="dot"></span> Dashboard banner</span>
                    <h3 class="fw-black mb-1">Global Ube Consumer Market Banner</h3>
                    <p class="text-muted mb-0">Shows where ube demand is growing across Filipino communities, dessert brands, restaurants, bakeries, and specialty food channels.</p>
                </div>
                <span class="chip">Global market signal</span>
            </div>
            <div class="theme-banner-wrap">
                <img src="uploads/dashboard_banner_light.png" alt="Global ube consumer map light mode banner" class="theme-banner-img banner-light">
                <img src="uploads/dashboard_banner_dark.png" alt="Global ube consumer map dark mode banner" class="theme-banner-img banner-dark">
            </div>
        </div>
    </div>
</section>

<!-- ── Features ──────────────────────────────────────────────── -->
<section class="section-padding">
    <div class="container">
        <div class="text-center mx-auto mb-5" style="max-width:760px">
            <span class="eyebrow mb-3"><span class="dot"></span> Platform modules</span>
            <h2 class="fw-black display-6">
                Built for traceability, farmer empowerment, and market access.
            </h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <h5 class="fw-bold">Farmer profiles</h5>
                    <p class="text-muted mb-0">
                        Digital farm identity, certifications, cooperative affiliation,
                        and product records.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-qrcode"></i>
                    </div>
                    <h5 class="fw-bold">QR traceability</h5>
                    <p class="text-muted mb-0">
                        Verify origin, harvest date, supply chain timeline, and batch status.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h5 class="fw-bold">Supplier matching</h5>
                    <p class="text-muted mb-0">
                        Connect farmers and ube-based businesses with local and institutional buyers.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon mb-3">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h5 class="fw-bold">Analytics</h5>
                    <p class="text-muted mb-0">
                        Monitor verified products, marketplace activity, and scan trends.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── Featured products ─────────────────────────────────────── -->
<section class="section-small bg-white">
    <div class="container">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-end gap-3 mb-4">
            <div>
                <span class="eyebrow mb-3"><span class="dot"></span> Featured marketplace</span>
                <h2 class="fw-black" style="color:#201828 !important">Verified Philippine ube products</h2>
            </div>
            <a href="marketplace.php" class="btn-pr btn-pr-light">View all products</a>
        </div>

        <div class="row g-4">
            <?php foreach (ube_home_featured_products() as $p): ?>
            <div class="col-sm-6 col-xl-4">
                <div class="product-card">
                    <div class="product-img product-thumb" style="background-image:url('<?= e(ube_featured_product_thumbnail($p)) ?>')">
                        <span class="position-absolute top-0 end-0 m-3 badge-verified <?= ($p['status'] ?? '') === 'Verified' ? '' : 'badge-warning' ?>"><?= e($p['status'] ?? 'For Validation') ?></span>
                    </div>
                    <div class="p-4">
                        <span class="chip"><?= e($p['category']) ?></span>
                        <h5 class="fw-bold mt-2"><?= e($p['product_name']) ?></h5>
                        <p class="text-muted small">
                            From <?= e($p['farmer_name']) ?> &bull;
                            <?= e($p['city']) ?>, <?= e($p['province']) ?>
                        </p>
                        <div class="d-flex justify-content-between">
                            <strong class="gradient-text"><?= e($p['price']) ?></strong>
                            <a class="btn-pr btn-pr-light btn-sm"
                               href="products/product_details.php?code=<?= urlencode($p['batch_code']) ?>">
                                View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
