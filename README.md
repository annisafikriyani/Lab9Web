# Lab9Web - Praktikum 9: PHP Modular

**Nama:** Annisa Fikriyani

**NIM:** 312510314 

**Kelas:** I252A

## Tujuan
Memisahkan aplikasi PHP ke dalam file-file modular: include/require, template, function, routing, dan integrasi dengan CRUD database (Lab 8).

## Cara Menjalankan
1. Salin project ke `C:\xampp\htdocs\lab9_php_modular\`
2. Start **Apache** dan **MySQL** di XAMPP
3. Buka `http://localhost/lab9_php_modular/<nama folder>/<file>.php`
4. Untuk Latihan J: buka `http://localhost/lab9_php_modular/J. Latihan 1-4/index.php`, login dengan `admin` / `admin123` untuk menambah, mengubah, dan menghapus data

## Struktur Folder
```
lab9_php_modular/
├── C. Include vs Require/
├── D. Template Layout PHP/
├── E. Function PHP/
├── G. Routing PHP/
└── J. Latihan 1-4/
    ├── index.php            (router)
    ├── .htaccess            (URL rewrite)
    ├── database.sql
    ├── config/              (app.php, database.php)
    ├── helpers/             (functions.php, barang.php)
    ├── views/               (header, footer, dashboard, profil, kontak, 404)
    ├── modules/
    │   ├── barang/          (list, add, edit, delete)
    │   └── auth/            (login, logout)
    ├── assets/css/
    └── gambar/
```

---

## C. include vs require
- Membuat `pesan.php`, `uji-include.php`, `uji-require.php`
- Mengganti nama `pesan.php` untuk menguji error

<img width="1917" height="1016" alt="Screenshot 2026-11-24 205931" src="https://github.com/user-attachments/assets/4107e9b0-4bab-4c45-ba5d-0f278ca91a7d" />

<img width="1917" height="1016" alt="Screenshot 2026-11-24 210308" src="https://github.com/user-attachments/assets/d722579d-da89-4b33-9505-fe6f34dcec39" />

<img width="1917" height="1013" alt="Screenshot 2026-11-24 210254" src="https://github.com/user-attachments/assets/bb55a0ad-5a9a-4c98-b628-797d9fc9cb81" />

## D. Template Layout
- Membuat `header.php`, `footer.php`, `home.php`, `about.php`, `kontak.php`, `style.css`
- Setiap halaman memanggil header dan footer dengan `require_once`, sehingga hanya konten tengah yang berbeda

**Analisis hasil:**
1. Bagian yang dipakai bersama: header, navigasi, footer, dan `style.css`.
2. Jika teks navigasi diubah di `header.php`, semua halaman ikut berubah tanpa edit satu per satu.
3. Konten halaman tidak ditaruh di `header.php` karena header dipakai bersama; jika konten khusus ditaruh di sana, semua halaman akan berisi sama.
4. Manfaat `require_once`: tidak ada duplikasi kode, perawatan mudah, tampilan konsisten, dan file tidak termuat ganda.

<img width="1917" height="1015" alt="Screenshot 2026-11-24 211512" src="https://github.com/user-attachments/assets/e21d607c-a0cf-4719-acf1-b3db1736c27a" />


<img width="1917" height="1022" alt="Screenshot 2026-11-24 211528" src="https://github.com/user-attachments/assets/db73f5a7-0955-448b-a91b-b0e96eaa208b" />


## E. Function
- Contoh function: tanpa parameter, dengan parameter, dengan return, type declaration dan nilai default
- Latihan di `helpers.php`: `konversiCelciusKeFahrenheit`, `tentukanStatusNilai`, `hitungTotal`
- Dipanggil dari `halaman1.php` dan `halaman2.php` dengan `require_once`

<img width="1917" height="495" alt="Screenshot 2026-11-24 213836" src="https://github.com/user-attachments/assets/b107cd4b-e76e-4bf9-a769-eb9242883e65" />

<img width="1917" height="630" alt="Screenshot 2026-11-24 213822" src="https://github.com/user-attachments/assets/cc4b8356-b43b-461e-b414-5307719314ad" />

halaman1
<img width="1917" height="1015" alt="Screenshot 2026-11-24 213607" src="https://github.com/user-attachments/assets/ea9ac1fd-5e6c-49f1-9f96-4c22b140740d" />

halaman2
<img width="1917" height="1022" alt="Screenshot 2026-11-24 213601" src="https://github.com/user-attachments/assets/179fde58-d9d9-4546-888e-37715a9ec714" />


## G. Routing
- `index.php` menjadi router dengan whitelist rute
- Parameter `page` yang tidak terdaftar, kosong, atau bukan string menghasilkan halaman 404
- Input URL tidak pernah dipakai langsung sebagai path file (mencegah path traversal)

| Rute | Halaman |
|---|---|
| `dashboard` | Dashboard |
| `user/list` | Daftar pengguna |
| `user/add` | Tambah pengguna |
| `user/edit` | Edit pengguna |
| lainnya | 404 |

<img width="1916" height="1078" alt="Screenshot 2026-11-24 215510" src="https://github.com/user-attachments/assets/3f087f97-d503-4830-b2d8-af1678d64f70" />

<img width="1917" height="1078" alt="Screenshot 2026-11-24 215525" src="https://github.com/user-attachments/assets/9dcf1e9c-09d2-4e39-b71a-80f23f1e2085" />

<img width="1917" height="1078" alt="Screenshot 2026-11-24 215532" src="https://github.com/user-attachments/assets/499e1e28-e0bb-40fa-bde7-40bcd9246032" />

<img width="1917" height="1078" alt="Screenshot 2026-11-24 215607" src="https://github.com/user-attachments/assets/b742ccca-63ec-4d1c-93e5-7267aa2910d0" />

## J. Latihan Terstruktur

### Latihan 1: Template multi-halaman
Halaman Home (Dashboard), Profil, dan Kontak memakai `views/header.php` dan `views/footer.php` yang sama. Tidak ada salinan kode header/footer di file halaman.

<img width="1917" height="1025" alt="image" src="https://github.com/user-attachments/assets/72073848-d181-498e-8f50-02d2fe115373" />

<img width="1908" height="1016" alt="image" src="https://github.com/user-attachments/assets/860e4709-f672-4c4a-83de-f7aa27caa128" />

<img width="1917" height="1017" alt="image" src="https://github.com/user-attachments/assets/642702cb-77a8-45bb-ac22-3c7c1814930d" />

<img width="1917" height="1020" alt="image" src="https://github.com/user-attachments/assets/00043fd6-c9f5-43f9-9b70-ecdedf5852f6" />


### Latihan 2: Library function
`helpers/functions.php` berisi:
- `formatRupiah()`: memformat angka menjadi rupiah
- `hitungDiskon()`: menghitung nominal diskon (persen default 10)
- `validasiEmail()`: memvalidasi format email
- `ringkasTeks()`: memotong teks panjang dan menambah `...`

<img width="1917" height="1016" alt="image" src="https://github.com/user-attachments/assets/31afad78-27f2-4c1b-8651-e1a1a372151f" />


### Latihan 3: Router aman
Router memiliki 9 rute dalam whitelist. Rute tidak dikenal menghasilkan status 404 dan input URL tidak dipakai langsung sebagai path file.

> **halaman 404 dari rute yang tidak dikenal]**
<img width="952" height="1018" alt="image" src="https://github.com/user-attachments/assets/90c53505-b942-45ec-9871-120db3777580" />


### Latihan 4: Refactoring CRUD
CRUD data barang dari Lab 8 dipecah ke struktur modular. Koneksi database hanya di `config/database.php`, semua halaman memakai template bersama dan diakses lewat router.

Perbaikan dari kode Lab 8:
- Query memakai prepared statement (mencegah SQL injection)
- Hapus data lewat POST dengan token CSRF, bukan link GET
- Upload gambar divalidasi (jenis file dan ukuran)
- Kolom Harga Jual dan Harga Beli yang tertukar di tabel sudah diperbaiki

<img width="958" height="803" alt="image" src="https://github.com/user-attachments/assets/7f278677-c415-44e4-a7b5-c9d8d5375de2" />

<img width="961" height="791" alt="image" src="https://github.com/user-attachments/assets/50338294-5104-4f18-a0e8-8a22401c41f7" />

harus log in baru bisa edit dll 
<img width="533" height="137" alt="image" src="https://github.com/user-attachments/assets/210f009e-ecd2-4876-84d5-31b496e9b5d8" />

<img width="951" height="945" alt="image" src="https://github.com/user-attachments/assets/08f4f63c-5bce-4027-a8d8-ac46014fccf3" />

<img width="872" height="797" alt="image" src="https://github.com/user-attachments/assets/cba9c439-ec39-402b-9dcb-a338989c7b74" />

<img width="915" height="681" alt="image" src="https://github.com/user-attachments/assets/6d3a0157-dfdd-4921-9488-a02b0156e76a" />

<img width="917" height="856" alt="image" src="https://github.com/user-attachments/assets/f4653088-9fb1-4b40-b383-182d349d14e9" />

<img width="945" height="861" alt="image" src="https://github.com/user-attachments/assets/be651158-c79a-41d2-8a5c-9c648dc800d2" />


### Tantangan Mandiri
- **Menu aktif:** menu yang sedang dibuka diberi highlight
- **Pesan sukses/gagal:** muncul setelah tambah, ubah, hapus, login, dan logout
- **Pembatasan akses:** tambah, ubah, dan hapus barang hanya bisa setelah login
- **URL rewrite:** `.htaccess` meneruskan `/barang/list` ke `index.php?page=barang/list` (butuh `mod_rewrite` aktif)

> **halaman Login]**
<img width="917" height="466" alt="image" src="https://github.com/user-attachments/assets/fea14e4e-c32f-46dc-9a81-f82a337a9dd1" />

<img width="145" height="67" alt="image" src="https://github.com/user-attachments/assets/298e28f0-2753-4672-a51f-3bd498a0d7e9" />

> **menu navigasi yang sedang aktif (ter-highlight)]**
<img width="903" height="77" alt="image" src="https://github.com/user-attachments/assets/63aa3f25-ac1f-4e8c-8f59-c45c5abea146" />


## Kendala dan Solusi
- **Browser error "Can't reach this page"**: file dibuka dengan `start home.php`, bukan lewat Apache. Solusi: nyalakan Apache dan buka lewat `http://localhost/...`
- **`Failed opening required ... list.php`**: file modul belum berada di folder `modules/user/`. Solusi: dipindahkan ke folder yang benar
- **Halaman tanpa gaya**: `style.css` tidak berada di `assets/css/`. Solusi: dipindahkan ke folder yang sesuai
