<?php
$page_title = 'Login';
$body_page  = 'login';
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role     = trim($_POST['role'] ?? 'Buyer / Platform User');

    if ($email === '') {
        $error = 'Please enter your email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif (strpos($password, ' ') !== false) {
        $error = 'Password must not contain spaces.';
    } elseif (!preg_match('/[a-zA-Z]/', $password)) {
        $error = 'Password must include at least one letter.';
    } elseif (!preg_match('/[0-9]/', $password)) {
        $error = 'Password must include at least one number.';
    } elseif (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        $error = 'Password must include at least one special character (e.g. @, #, !, _).';
    } else {
        $foundUser = null;
        global $pdo;
        if ($pdo) {
            try {
                $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
                $stmt->execute([$email]);
                $foundUser = $stmt->fetch();
            } catch (Exception $e) {}
        }
        if ($foundUser && !empty($foundUser['password']) && !password_verify($password, $foundUser['password'])) {
            $error = 'Incorrect password. Please try again.';
        } else {
            $_SESSION['user_id'] = $foundUser['id'] ?? null;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = $foundUser['role'] ?? $role;
            $_SESSION['full_name'] = $foundUser['full_name'] ?? ($_POST['full_name'] ?? 'PurpleRoots User');
            $_SESSION['organization'] = $foundUser['organization'] ?? '';
            $_SESSION['phone'] = $foundUser['phone'] ?? '';
            $_SESSION['province'] = $foundUser['province'] ?? '';
            $_SESSION['municipality'] = $foundUser['municipality'] ?? '';
            $_SESSION['created_at'] = $foundUser['created_at'] ?? '';
            header('Location: dashboard.php');
            exit;
        }
    }
}
include __DIR__ . '/includes/navbar.php';
?>

<section class="auth-wrap">
    <div class="container">
        <form method="post" class="form-card mx-auto auth-card-enhanced">
            <span class="eyebrow mb-3"><span class="dot"></span> Welcome back</span>
            <h2 class="fw-black mb-2">Log in to PurpleRoots</h2>
            <p class="text-muted mb-4">Access your profile, source listings, marketplace inquiries, and traceability tools.</p>

            <?php if (!empty($_SESSION['registration_success'])): ?><div class="alert alert-success"><?= e($_SESSION['registration_success']); unset($_SESSION['registration_success']); ?></div><?php endif; ?>
            <?php if ($error): ?><div class="alert alert-warning"><?= e($error) ?></div><?php endif; ?>

            <label class="form-label">Email address</label>
            <input class="form-control mb-3" name="email" type="email" placeholder="name@example.com" required>

            <label class="form-label">Password</label>
            <input class="form-control mb-1" name="password" id="loginPassword" type="password"
                   placeholder="Enter your password"
                   minlength="8"
                   title="Min 8 characters — must include a letter, a number, and a special character. No spaces."
                   required>
            <div id="loginPasswordHint" class="small mb-3" style="min-height:1.2em"></div>

            <label class="form-label">User level for demo login</label>
            <select class="form-select mb-4" name="role">
                <option>Corporate Seller</option>
                <option>Farmer / Cooperative</option>
                <option>Processor / Brand</option>
                <option>Buyer / Platform User</option>
                <option>Administrator</option>
            </select>

            <button class="btn-pr btn-pr-primary w-100 justify-content-center" type="submit">Log in</button>

            <p class="text-center small text-muted mt-3 mb-0">
                Don’t have an account yet? <a href="register.php" class="fw-bold">Sign up or register here.</a>
            </p>
        </form>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
(function () {
    const input = document.getElementById('loginPassword');
    const hint  = document.getElementById('loginPasswordHint');
    if (!input || !hint) return;

    function check(val) {
        if (val === '') return { ok: false, msg: '' };
        if (val.includes(' '))              return { ok: false, msg: '✗ No spaces allowed.' };
        if (val.length < 8)                 return { ok: false, msg: '✗ At least 8 characters required.' };
        if (!/[a-zA-Z]/.test(val))          return { ok: false, msg: '✗ Must include at least one letter.' };
        if (!/[0-9]/.test(val))             return { ok: false, msg: '✗ Must include at least one number.' };
        if (!/[^a-zA-Z0-9]/.test(val))      return { ok: false, msg: '✗ Must include at least one special character (e.g. @, #, !, _).' };
        return { ok: true,  msg: '✓ Password meets all requirements.' };
    }

    input.addEventListener('input', function () {
        const result = check(input.value);
        if (result.msg === '') {
            hint.textContent = '';
            hint.style.color = '';
        } else {
            hint.textContent = result.msg;
            hint.style.color = result.ok ? 'var(--leaf-600)' : '#c0392b';
        }
    });
})();
</script>
