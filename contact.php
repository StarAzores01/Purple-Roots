<?php
$page_title = 'Contact';
$body_page  = 'contact';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';
include    __DIR__ . '/includes/navbar.php';
?>

<!-- ── Page hero ─────────────────────────────────────────────── -->
<section class="page-hero">
    <div class="container">
        <span class="eyebrow mb-3"><span class="dot"></span> Contact</span>
        <h1 class="fw-black display-5">Partner with PurpleRoots</h1>
        <p class="lead-copy">
            For farmers, cooperatives, bakeries, processors, and buyers
            interested in verified ube sourcing.
        </p>
    </div>
</section>

<!-- ── Contact form ──────────────────────────────────────────── -->
<section class="section-small">
    <div class="container">
        <div class="form-card mx-auto">

            <label class="form-label">Name</label>
            <input class="form-control mb-3" placeholder="Your full name">

            <label class="form-label">Email</label>
            <input class="form-control mb-3" type="email" placeholder="you@example.com">

            <label class="form-label">Message</label>
            <textarea class="form-control mb-3" rows="5" placeholder="How can we help?"></textarea>

            <button class="btn-pr btn-pr-primary" data-toast="Message submitted.">
                Send message
            </button>

        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
