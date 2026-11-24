<?php if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); } ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> - <?= e(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= e(assetUrl('assets/css/style.css')) ?>">
</head>
<body>
<div class="container">
    <header>
        <h1><?= e(APP_NAME) ?></h1>
        <p>Refactoring CRUD Lab 8 dengan template, function, dan router</p>
    </header>

    <nav>
        <a href="<?= e(url('dashboard')) ?>"<?= navClass($activePage, 'dashboard') ?>>Dashboard</a>
        <a href="<?= e(url('profil')) ?>"<?= navClass($activePage, 'profil') ?>>Profil</a>
        <a href="<?= e(url('kontak')) ?>"<?= navClass($activePage, 'kontak') ?>>Kontak</a>
        <a href="<?= e(url('barang/list')) ?>"<?= navClass($activePage, 'barang/list') ?>>Data Barang</a>
        <?php if (isLoggedIn()): ?>
            <a href="<?= e(url('barang/add')) ?>"<?= navClass($activePage, 'barang/add') ?>>Tambah Barang</a>
            <form class="nav-form" method="post" action="<?= e(url('auth/logout')) ?>">
                <?= csrfField() ?>
                <button type="submit" class="link-button">Logout (<?= e($_SESSION['user']) ?>)</button>
            </form>
        <?php else: ?>
            <a href="<?= e(url('auth/login')) ?>"<?= navClass($activePage, 'auth/login') ?>>Login</a>
        <?php endif; ?>
    </nav>

    <main>
        <?php if ($flash = getFlash()): ?>
            <div class="alert alert-<?= e($flash['tipe']) ?>"><?= e($flash['pesan']) ?></div>
        <?php endif; ?>
