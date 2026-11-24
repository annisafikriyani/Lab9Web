<?php if (!defined('APP_RUNNING')) { http_response_code(403); exit('Akses langsung tidak diizinkan.'); } ?>
<section class="card">
    <h2>Profil</h2>
    <table class="detail">
        <tr><th>Nama</th><td><?= e(PROFIL_NAMA) ?></td></tr>
        <tr><th>NIM</th><td><?= e(PROFIL_NIM) ?></td></tr>
        <tr><th>Kelas</th><td><?= e(PROFIL_KELAS) ?></td></tr>
    </table>
</section>

<section class="card">
    <h2>Demo Function (helpers/functions.php)</h2>
    <ul>
        <li>formatRupiah(250000): <strong><?= e(formatRupiah(250000)) ?></strong></li>
        <li>hitungDiskon(250000): <strong><?= e(formatRupiah(hitungDiskon(250000))) ?></strong> (diskon 10%, nilai default)</li>
        <li>hitungDiskon(250000, 15): <strong><?= e(formatRupiah(hitungDiskon(250000, 15))) ?></strong> (diskon 15%)</li>
        <li>validasiEmail('nama@email.com'): <strong><?= validasiEmail('nama@email.com') ? 'valid' : 'tidak valid' ?></strong></li>
        <li>validasiEmail('abc'): <strong><?= validasiEmail('abc') ? 'valid' : 'tidak valid' ?></strong></li>
        <li>ringkasTeks(...): <strong><?= e(ringkasTeks('Ini adalah contoh teks panjang yang akan diringkas oleh function ringkasTeks.', 40)) ?></strong></li>
    </ul>
</section>
