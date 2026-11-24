<?php
require_once __DIR__ . '/helpers.php';

$total = hitungTotal(15000, 3);
echo "Total belanja: " . formatRupiah($total) . "<br>";
echo "Suhu: 100°C = " . konversiCelciusKeFahrenheit(100) . "°F<br>";
echo e('<script>alert("uji")</script>');
?>