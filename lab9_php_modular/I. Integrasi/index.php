<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
ob_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/helpers/functions.php';

$routes = [
    'dashboard'     => __DIR__ . '/views/dashboard.php',
    'login'         => __DIR__ . '/modules/auth/login.php',
    'logout'        => __DIR__ . '/modules/auth/logout.php',
    'barang/list'   => __DIR__ . '/modules/barang/list.php',
    'barang/add'    => __DIR__ . '/modules/barang/add.php',
    'barang/edit'   => __DIR__ . '/modules/barang/edit.php',
    'barang/delete' => __DIR__ . '/modules/barang/delete.php',
];

$protectedRoutes = ['barang/list', 'barang/add', 'barang/edit', 'barang/delete'];
$page = $_GET['page'] ?? 'dashboard';

if (!is_string($page) || !array_key_exists($page, $routes)) {
    http_response_code(404);
    $page = '404';
    $contentFile = __DIR__ . '/views/404.php';
} else {
    if (in_array($page, $protectedRoutes, true)) {
        wajibLogin();
    }
    $contentFile = $routes[$page];
}

require_once __DIR__ . '/views/header.php';
require $contentFile;
require_once __DIR__ . '/views/footer.php';