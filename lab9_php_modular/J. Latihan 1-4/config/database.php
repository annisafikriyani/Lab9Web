<?php
// config/database.php - SATU-SATUNYA tempat koneksi database (MySQLi, sama seperti Lab 8)

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'latihan1';

/**
 * Mengembalikan koneksi MySQLi. Koneksi dibuat saat pertama kali dipakai,
 * sehingga halaman tanpa database (Profil, Kontak, Login) tetap bisa dibuka.
 */
function db(): mysqli
{
    static $conn = null;

    if ($conn === null) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $conn->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            // Detail error hanya ke log server, tidak ditampilkan ke pengguna
            error_log('Koneksi database gagal: ' . $e->getMessage());
            throw new RuntimeException('Koneksi database gagal.');
        }
    }

    return $conn;
}
