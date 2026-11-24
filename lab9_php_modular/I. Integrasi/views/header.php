<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lab9Web - PHP Modular</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Lab9Web - PHP Modular</h1>
        <p>Template, Function, Routing & CRUD Data Barang</p>
    </header>
    <nav>
        <a class="<?= menuAktif($page, 'dashboard') ?>" href="index.php?page=dashboard">Dashboard</a>
        <a class="<?= menuAktif($page, 'barang') ?>" href="index.php?page=barang/list">Data Barang</a>

        <?php if (sudahLogin()): ?>
            <a class="<?= menuAktif($page, 'logout') ?>" href="index.php?page=logout">
                Logout (<?= e($_SESSION['user_login']['username']) ?>)
            </a>
        <?php else: ?>
            <a class="<?= menuAktif($page, 'login') ?>" href="index.php?page=login">Login</a>
        <?php endif; ?>
    </nav>
    <main>
        <?php tampilkanFlash(); ?>