<?php
$page_title = 'About';
$body_page  = 'about';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
include    __DIR__ . '/includes/navbar.php';
?>

<!-- ── Page hero ─────────────────────────────────────────────── -->
<section class="page-hero">
    <div class="container">
        <span class="eyebrow mb-3"><span class="dot"></span> About</span>
        <h1 class="fw-black display-5">
            Preserving the value of Philippine ube through traceability.
        </h1>
        <p class="lead-copy">
            PurpleRoots is designed as a digital platform for authentic ube products,
            transparent sourcing, farmer visibility, and buyer trust.
        </p>
    </div>
</section>

<!-- ── Mission cards ─────────────────────────────────────────── -->
<section class="section-padding">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card">
                    <h4>Mission</h4>
                    <p class="text-muted">
                        Help consumers and buyers verify where ube products come from.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h4>Farmers</h4>
                    <p class="text-muted">
                        Give growers and cooperatives a digital profile for market access.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card">
                    <h4>Buyers</h4>
                    <p class="text-muted">
                        Support sourcing through product records and QR traceability.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
