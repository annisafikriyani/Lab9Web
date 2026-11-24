<?php
// index.php - titik masuk aplikasi (router)
const APP_RUNNING = true;

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

require_once __DIR__ . '/config/app.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';
require_once __DIR__ . '/helpers/barang.php';

/*
 * Whitelist rute. Hanya halaman yang terdaftar di sini yang boleh dibuka.
 * auth   => true  : wajib login (Tantangan 3)
 * layout => false : halaman aksi tanpa tampilan (langsung redirect)
 */
$routes = [
    'dashboard'     => ['file' => '/views/dashboard.php',         'title' => 'Dashboard'],
    'profil'        => ['file' => '/views/profil.php',            'title' => 'Profil'],
    'kontak'        => ['file' => '/views/kontak.php',            'title' => 'Kontak'],
    'barang/list'   => ['file' => '/modules/barang/list.php',     'title' => 'Data Barang'],
    'barang/add'    => ['file' => '/modules/barang/add.php',      'title' => 'Tambah Barang',  'auth' => true],
    'barang/edit'   => ['file' => '/modules/barang/edit.php',     'title' => 'Ubah Barang',    'auth' => true],
    'barang/delete' => ['file' => '/modules/barang/delete.php',   'title' => 'Hapus Barang',   'auth' => true, 'layout' => false],
    'auth/login'    => ['file' => '/modules/auth/login.php',      'title' => 'Login'],
    'auth/logout'   => ['file' => '/modules/auth/logout.php',     'title' => 'Logout',         'layout' => false],
];

$page = $_GET['page'] ?? 'dashboard';

// Input URL tidak pernah dipakai langsung sebagai path file
if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $activePage  = '';
    $pageTitle   = '404';
    $contentFile = __DIR__ . '/views/404.php';
    $useLayout   = true;
} else {
    $route       = $routes[$page];
    $activePage  = $page;
    $pageTitle   = $route['title'];
    $contentFile = __DIR__ . $route['file'];
    $useLayout   = $route['layout'] ?? true;

    // Halaman yang dilindungi login
    if (!empty($route['auth']) && !isLoggedIn()) {
        if ($useLayout) {
            $_SESSION['intended'] = $page; // setelah login kembali ke halaman ini
        }
        setFlash('error', 'Silakan login terlebih dahulu untuk mengakses halaman itu.');
        redirect('auth/login');
    }
}

// Halaman aksi (hapus, logout): tidak ada tampilan
if (!$useLayout) {
    require $contentFile;
    exit;
}

// Isi halaman dijalankan lebih dulu dan ditampung, supaya error database
// tidak merusak tampilan header/footer.
ob_start();
try {
    require $contentFile;
    $konten = ob_get_clean();
} catch (Throwable $e) {
    ob_end_clean();
    error_log($e->getMessage());
    http_response_code(500);
    $konten = '<section class="card"><h2>Terjadi kesalahan</h2>'
            . '<p>Data tidak dapat diproses. Pastikan MySQL di XAMPP sudah menyala '
            . 'dan database <strong>' . e(DB_NAME) . '</strong> sudah dibuat (lihat database.sql).</p></section>';
}

require_once __DIR__ . '/views/header.php';
echo $konten;
require_once __DIR__ . '/views/footer.php';
