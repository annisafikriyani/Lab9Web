-- database.sql
-- Jika database "latihan1" dan tabel "data_barang" dari Lab 8 sudah ada, TIDAK PERLU diimpor.
-- Jalankan file ini di phpMyAdmin (tab SQL) hanya jika belum punya.

CREATE DATABASE IF NOT EXISTS latihan1 CHARACTER SET utf8mb4;
USE latihan1;

CREATE TABLE IF NOT EXISTS data_barang (
    id_barang  INT AUTO_INCREMENT PRIMARY KEY,
    nama       VARCHAR(100) NOT NULL,
    kategori   VARCHAR(50)  NOT NULL,
    harga_jual DECIMAL(12,0) NOT NULL DEFAULT 0,
    harga_beli DECIMAL(12,0) NOT NULL DEFAULT 0,
    stok       INT NOT NULL DEFAULT 0,
    gambar     VARCHAR(255) NOT NULL DEFAULT ''
);

-- Data contoh (hapus tanda komentar jika ingin dipakai)
-- INSERT INTO data_barang (nama, kategori, harga_jual, harga_beli, stok) VALUES
-- ('Laptop Gaming', 'Komputer', 12000000, 10500000, 5),
-- ('Smart TV 43 inch', 'Elektronik', 4500000, 3900000, 8),
-- ('Smartphone 5G', 'Hand Phone', 3000000, 2600000, 12);
