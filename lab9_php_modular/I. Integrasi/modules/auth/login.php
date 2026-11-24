<?php
// Jika sudah login, langsung arahkan ke halaman barang
if (sudahLogin()) {
    redirect('barang/list');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Akun latihan sederhana (bisa disesuaikan)
    if ($username === 'admin' && $password === '12345') {
        $_SESSION['user_login'] = [
            'username' => $username,
            'nama'     => 'Administrator',
        ];
        setFlash('success', 'Login berhasil! Selamat datang.');
        redirect('barang/list');
    }

    setFlash('error', 'Username atau password salah. Coba gunakan admin / 12345.');
    redirect('login');
}
?>

<h2>Login</h2>
<p>Masukkan username dan password untuk mengakses data barang.</p>
<p><small>Akun uji coba: <strong>admin</strong> / <strong>12345</strong></small></p>

<form method="POST" action="index.php?page=login">
    <p>
        <label for="username">Username</label><br>
        <input type="text" id="username" name="username" required>
    </p>
    <p>
        <label for="password">Password</label><br>
        <input type="password" id="password" name="password" required>
    </p>
    <button type="submit">Masuk</button>
</form>