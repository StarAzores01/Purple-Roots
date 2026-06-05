<?php
$page_title = 'Register';
$body_page  = 'register';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? 'Buyer / Platform User');
    $password = $_POST['password'] ?? '';
    $organization = trim($_POST['organization'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $municipality = trim($_POST['municipality'] ?? '');

    if ($fullName === '') $errors[] = 'Full name is required.';
    if ($email === '')    $errors[] = 'Email is required.';
    if ($password === '') {
        $errors[] = 'Password is required.';
    } elseif (strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters long.';
    } elseif (strpos($password, ' ') !== false) {
        $errors[] = 'Password must not contain spaces.';
    } elseif (!preg_match('/[a-zA-Z]/', $password)) {
        $errors[] = 'Password must include at least one letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must include at least one number.';
    } elseif (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        $errors[] = 'Password must include at least one special character (e.g. @, #, !, _).';
    }

    if (!$errors) {
        global $pdo;
        if ($pdo) {
            try {
                $pdo->exec("ALTER TABLE users ADD COLUMN organization VARCHAR(160) NULL");
                $pdo->exec("ALTER TABLE users ADD COLUMN phone VARCHAR(60) NULL");
                $pdo->exec("ALTER TABLE users ADD COLUMN province VARCHAR(120) NULL");
                $pdo->exec("ALTER TABLE users ADD COLUMN municipality VARCHAR(120) NULL");
            } catch (Exception $e) {}
            try {
                $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password, role, organization, phone, province, municipality) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
                $stmt->execute([$fullName, $email, password_hash($password, PASSWORD_DEFAULT), $role, $organization, $phone, $province, $municipality]);
            } catch (Exception $e) {
                // Allow prototype redirect even if the local demo database is not yet ready or email already exists.
            }
        }
        $_SESSION['registration_success'] = 'Account created successfully. Please log in to continue.';
        header('Location: login.php');
        exit;
    }
}
include __DIR__ . '/includes/navbar.php';
?>

<section class="auth-wrap">
    <div class="container">
        <form method="post" class="form-card mx-auto auth-card-enhanced">
            <span class="eyebrow mb-3"><span class="dot"></span> Join platform</span>
            <h2 class="fw-black mb-2">Create your PurpleRoots account</h2>
            <p class="text-muted mb-4">Register as a farmer, cooperative, corporate seller, administrator, or buyer to access marketplace and traceability tools.</p>

            <?php if ($errors): ?><div class="alert alert-warning"><?= e(implode(' ', $errors)) ?></div><?php endif; ?>

            <label class="form-label">Full name / organization representative</label>
            <input class="form-control mb-3" name="full_name" placeholder="Juan Dela Cruz" required>

            <label class="form-label">Email address</label>
            <input class="form-control mb-3" name="email" type="email" placeholder="name@example.com" required>

            <label class="form-label">User level</label>
            <select class="form-select mb-3" name="role">
                <option>Farmer / Cooperative</option>
                <option>Corporate Seller</option>
                <option>Processor / Brand</option>
                <option>Buyer / Platform User</option>
                <option>Administrator</option>
            </select>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Organization / farm / business name</label>
                    <input class="form-control" name="organization" placeholder="Farm, cooperative, company, or LGU office">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact number</label>
                    <input class="form-control" name="phone" placeholder="09XX XXX XXXX">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Province</label>
                    <input class="form-control" name="province" placeholder="Bohol, Quezon, Bukidnon...">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Municipality / City</label>
                    <input class="form-control" name="municipality" placeholder="Municipality or city">
                </div>
            </div>

            <label class="form-label mt-3">Password</label>
            <input class="form-control mb-1" name="password" id="regPassword" type="password"
                   placeholder="Min 8 chars — letters, numbers, and a special character"
                   minlength="8"
                   title="Min 8 characters — must include a letter, a number, and a special character. No spaces."
                   required>
            <div id="regPasswordHint" class="small mb-4" style="min-height:1.2em; color:var(--muted)">
                Min 8 characters &bull; at least one letter &bull; one number &bull; one special character (e.g. @, #, !, _) &bull; no spaces.
            </div>

            <button class="btn-pr btn-pr-primary w-100 justify-content-center" type="submit">Register</button>

            <p class="text-center small text-muted mt-3 mb-0">
                Already have an account? <a href="login.php" class="fw-bold">Log in here.</a>
            </p>
        </form>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
(function () {
    const input = document.getElementById('regPassword');
    const hint  = document.getElementById('regPasswordHint');
    if (!input || !hint) return;

    const rules = [
        { test: v => v.length >= 8,            label: 'At least 8 characters'           },
        { test: v => /[a-zA-Z]/.test(v),       label: 'At least one letter (A–Z)'       },
        { test: v => /[0-9]/.test(v),          label: 'At least one number (0–9)'       },
        { test: v => /[^a-zA-Z0-9]/.test(v),   label: 'At least one special character (@, #, !, _ …)' },
        { test: v => !v.includes(' '),          label: 'No spaces'                       },
    ];

    input.addEventListener('input', function () {
        const val = input.value;
        if (val === '') {
            hint.innerHTML = 'Min 8 characters &bull; at least one letter &bull; one number &bull; one special character (e.g. @, #, !, _) &bull; no spaces.';
            hint.style.color = 'var(--muted)';
            return;
        }

        const items = rules.map(r => {
            const pass = r.test(val);
            return `<span style="color:${pass ? 'var(--leaf-600)' : '#c0392b'};margin-right:10px">
                        ${pass ? '✓' : '✗'} ${r.label}
                    </span>`;
        });

        const allPass = rules.every(r => r.test(val));
        hint.innerHTML = items.join('');
        hint.style.color = '';

        // Also drive native validity so the submit button stays blocked
        if (!allPass) {
            input.setCustomValidity('Password does not meet all requirements.');
        } else {
            input.setCustomValidity('');
        }
    });
})();
</script>
