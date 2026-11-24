<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

if (isLoggedIn()) {
    redirect('dashboard');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = (string) ($_POST['username'] ?? '');
    $pass = (string) ($_POST['password'] ?? '');

    if (!csrfValid($_POST['csrf'] ?? null)) {
        $error = 'Permintaan tidak valid. Muat ulang halaman.';
    } else {
        $userOk = hash_equals(ADMIN_USER, $user);
        $passOk = password_verify($pass, ADMIN_PASS_HASH);

        if ($userOk && $passOk) {
            session_regenerate_id(true);
            $_SESSION['user'] = ADMIN_USER;

            $tujuan = $_SESSION['intended'] ?? 'barang/list';
            unset($_SESSION['intended']);
            setFlash('success', 'Login berhasil. Selamat datang, ' . ADMIN_USER . '.');
            redirect($tujuan);
        }
        $error = 'Username atau password salah.';
    }
}
?>
<section class="card">
    <h2>Login</h2>
    <p class="muted">Halaman tambah, ubah, dan hapus barang hanya bisa diakses setelah login.</p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <?= csrfField() ?>
        <div class="input">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required autofocus>
        </div>
        <div class="input">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
</section>
