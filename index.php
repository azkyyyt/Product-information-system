<?php

// Presentation Layer: Merajut seluruh komponen menggunakan require_once
require_once 'products.php';
require_once 'functions.php';

$totalNilaiAset = hitungTotalNilaiStok($products);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Product Information System</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .kritis {
            background-color: #ffcccc;
        }
    </style>
</head>
<body>

    <h2>Product Information System</h2>
    <p>Total Nilai Aset Gudang: Rp <?= $totalNilaiAset ?></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $item): ?>
                <?php $kelasBaris = getWarnaBaris($item['stok']); ?>
                <tr class="<?= $kelasBaris ?>">
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['nama'] ?></td>
                    <td><?= $item['kategori'] ?></td>
                    <td><?= $item['harga'] ?></td>
                    <td><?= $item['stok'] ?></td>
                    <td><?= $item['deskripsi'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
