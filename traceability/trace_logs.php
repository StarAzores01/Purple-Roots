<?php
$page_title = 'Trace Logs';
$body_page  = 'traceability';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/ube_data.php';
include    __DIR__ . '/../includes/navbar.php';
?>

<div class="dashboard-shell">
    <?php include __DIR__ . '/../includes/sidebar.php'; ?>
    <main class="dashboard-main">
        <div class="topbar"><div><span class="eyebrow mb-2"><span class="dot"></span> Trace Logs</span><h1 class="fw-black">QR Scan Logs</h1></div></div>
        <div class="table-card">
            <table class="table mb-0">
                <thead><tr><th>Batch</th><th>Source Area</th><th>Action</th><th>Date</th></tr></thead>
                <tbody>
                    <?php foreach ($ube_regions as $i => $area): ?>
                    <tr>
                        <td><?= e($area['batch_code']) ?></td>
                        <td><?= e($area['province']) ?></td>
                        <td><?= $i % 2 === 0 ? 'QR scan' : 'Source verified' ?></td>
                        <td><?= date('Y-m-d H:i', strtotime('-' . $i . ' day')) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
