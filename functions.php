<?php

// Processing Layer: Fungsi mengalkulasi nilai total aset gudang
function hitungTotalNilaiStok($products) {
    $total = 0;
    foreach ($products as $item) {
        $total += $item['harga'] * $item['stok'];
    }
    return $total;
}

// Logika conditional menyaring warna baris jika stok kritis (< 3)
function getWarnaBaris($stok) {
    if ($stok < 3) {
        return 'kritis';
    }
    return '';
}
