<?php
if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrfValid($_POST['csrf'] ?? null)) {
    unset($_SESSION['user']);
    session_regenerate_id(true);
    setFlash('success', 'Anda telah logout.');
    redirect('dashboard');
}

redirect('dashboard');
