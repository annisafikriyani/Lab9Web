<?php
// helpers/functions.php - function umum yang dipakai banyak halaman

/* ---------- Latihan 2: library function ---------- */

/** Mengamankan teks sebelum dicetak ke HTML (mencegah XSS). */
function e(mixed $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

/** Memformat angka menjadi rupiah. Contoh: 250000 -> "Rp 250.000" */
function formatRupiah(float $angka): string
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/** Menghitung nominal diskon. Contoh: hitungDiskon(200000, 15) -> 30000 */
function hitungDiskon(float $harga, float $persen = 10): float
{
    return $harga * ($persen / 100);
}

/** Memeriksa apakah email valid. */
function validasiEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/** Memotong teks panjang dan menambahkan "...". */
function ringkasTeks(string $teks, int $batas = 50): string
{
    if (mb_strlen($teks) <= $batas) {
        return $teks;
    }
    return rtrim(mb_substr($teks, 0, $batas)) . '...';
}

/* ---------- URL dan routing ---------- */

/** Alamat folder aplikasi, aman untuk nama folder yang mengandung spasi. */
function baseUrl(): string
{
    $dir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $dir = rtrim($dir, '/');
    return implode('/', array_map('rawurlencode', explode('/', $dir)));
}

/** Membuat tautan router. Contoh: url('barang/edit', ['id' => 5]) */
function url(string $page, array $params = []): string
{
    $query = $params ? '&' . http_build_query($params) : '';
    return baseUrl() . '/index.php?page=' . $page . $query;
}

/** Alamat file statis (CSS, gambar). */
function assetUrl(string $path): string
{
    return baseUrl() . '/' . ltrim($path, '/');
}

/** Pindah halaman lewat router. */
function redirect(string $page): void
{
    header('Location: ' . url($page));
    exit;
}

/** Memberi class "active" pada menu yang sedang dibuka (Tantangan 1). */
function navClass(string $aktif, string $target): string
{
    $cocok = ($aktif === $target) || str_starts_with($aktif, $target . '/');
    return $cocok ? ' class="active"' : '';
}

/* ---------- Keamanan: CSRF ---------- */

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrfToken()) . '">';
}

function csrfValid(mixed $token): bool
{
    return isset($_SESSION['csrf']) && is_string($token)
        && hash_equals($_SESSION['csrf'], $token);
}

/* ---------- Pesan sukses/gagal (Tantangan 2) ---------- */

function setFlash(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

function getFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/* ---------- Login (Tantangan 3) ---------- */

function isLoggedIn(): bool
{
    return !empty($_SESSION['user']);
}
