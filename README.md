# Product Information System (Mini Project 1)

Proyek ini adalah sistem manajemen data informasi produk berbasis web sederhana yang menerapkan konsep **Separation of Concerns (Pemisahan Peran)** dan arsitektur 3-tier modular PHP.

---

## Struktur & Fungsi Setiap Berkas

| Nama Berkas | Lapisan (Layer) | Fungsi Utama |
|---|---|---|
| `products.php` | **Data Layer** | Menyimpan kumpulan data produk dalam bentuk *Multidimensional Array*. |
| `functions.php` | **Processing Layer** | Berisi fungsi-fungsi pengolah data (hitung total aset & logika warna baris). |
| `index.php` | **Presentation Layer** | Merajut berkas data & fungsi via `require_once` dan merender tabel di browser. |
| `index.html` | **Versi Statis** | Berkas HTML murni untuk dapat dilihat langsung tanpa web server PHP. |

---

## 🧠 Penjelasan Logika & Alur Sistem (Data Flow)

Sistem ini bekerja dengan alur logis dari **Data Layer ➔ Processing Layer ➔ Presentation Layer**:

1. **Pengambilan Data**: `index.php` memuat berkas `products.php` menggunakan `require_once` untuk mengambil array `$products`.
2. **Pemrosesan Data**: `index.php` memuat `functions.php` dan memanggil:
   - `hitungTotalNilaiStok($products)` untuk menghitung total akumulasi `harga * stok`.
   - `getWarnaBaris($stok)` untuk setiap baris produk saat perulangan berjalan.
3. **Penyajian Data (Render)**: `index.php` mengulang (`foreach`) setiap baris produk dan mencetaknya ke dalam tabel HTML. Jika `stok < 3`, baris tabel diberi kelas CSS `kritis` sehingga warnanya menjadi merah muda.

---

##  Bedah Kode & Penjelasan Fungsi

# 1. File `products.php` (Data Layer)

```php
<?php

// Data Layer: Multidimensional array penampung data komoditas produk
$products = [
    [
        "id" => 1,
        "nama" => "Beras 5kg",
        "kategori" => "Sembako",
        "harga" => 65000,
        "stok" => 10,
        "deskripsi" => "Beras kualitas baik"
    ],
    [
        "id" => 2,
        "nama" => "Minyak Goreng 2L",
        "kategori" => "Sembako",
        "harga" => 32000,
        "stok" => 2,
        "deskripsi" => "Minyak kelapa sawit"
    ],
    [
        "id" => 3,
        "nama" => "Gula Pasir 1kg",
        "kategori" => "Sembako",
        "harga" => 15000,
        "stok" => 5,
        "deskripsi" => "Gula tebu murni"
    ],
    [
        "id" => 4,
        "nama" => "Telur 1kg",
        "kategori" => "Sembako",
        "harga" => 27000,
        "stok" => 1,
        "deskripsi" => "Telur ayam segar"
    ]
];
```

* **Penjelasan Fungsi Kode**:
  * `$products`: Variabel utama penampung data menggunakan *Multidimensional Associative Array*.
  * `'id'`, `'nama'`, `'kategori'`, `'harga'`, `'stok'`, `'deskripsi'`: Kunci (*key*) untuk memetakan atribut data produk.
  * **Arah Data**: Data mentah ini dikirim ke `index.php` untuk diolah oleh `functions.php` dan ditampilkan.

---

# 2. File `functions.php` (Processing Layer)

```php
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
```

* **Penjelasan Fungsi Kode**:
  1. `hitungTotalNilaiStok($products)`:
     * **Input**: Menerima parameter array data produk (`$products`).
     * **Proses**: Melakukan perulangan `foreach` untuk mengalikan `harga` dengan `stok` tiap barang, lalu dijumlahkan ke variabel `$total`.
     * **Return**: Mengembalikan nilai numerik total aset gudang.
     * **Arah Data**: Hasil kembaliannya digunakan oleh `index.php` untuk mencetak total nilai aset.

  2. `getWarnaBaris($stok)`:
     * **Input**: Menerima parameter angka kuantitas stok barang (`$stok`).
     * **Proses**: Mengevaluasi kondisi logis `if ($stok < 3)`.
     * **Return**: Mengembalikan string `'kritis'` jika stok kurang dari 3, atau string kosong `''` jika stok aman (3 atau lebih).
     * **Arah Data**: String kembalian disuntikkan ke atribut `<tr class="...">` pada `index.php` untuk menentukan warna baris.

---

# 3. File `index.php` (Presentation Layer)

```php
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
```

* **Penjelasan Fungsi Kode**:
  * `require_once 'products.php';`: Memuat berkas data produk secara mutlak 1 kali.
  * `require_once 'functions.php';`: Memuat berkas fungsi logika secara mutlak 1 kali.
  * `foreach ($products as $item)`: Mengiterasi setiap barang dan merender baris elemen `<tr>` serta kolom `<td>`.
  * `.kritis`: Kelas CSS untuk memberi warna latar belakang merah muda `#ffcccc` pada baris produk yang stoknya di bawah 3.

---

# 🚀 Cara Mengoperasikan & Melihat Tampilan

# Cara 1: Membuka Berkas HTML (Paling Mudah)
1. Buka File Explorer di komputer Anda.
2. Masuk ke folder proyek: `C:\Users\Azkia Akbar Pratama\Documents\product-info-system\`
3. **Klik dua kali (double click)** pada berkas `index.html`.
4. Berkas akan langsung terbuka di browser favorit Anda.

# Cara 2: Menjalankan dengan Server PHP (Server-Side)
1. Buka **Command Prompt (CMD)** atau **PowerShell**.
2. Masuk ke direktori proyek:
   ```cmd
   cd "C:\Users\Azkia Akbar Pratama\Documents\product-info-system"
   ```
3. Jalankan server bawaan PHP:
   ```cmd
   php -S localhost:8000
   ```
4. Buka browser dan ketik alamat: **`http://localhost:8000`**

### Cara 3: Menjalankan Menggunakan XAMPP
1. Salin seluruh folder `product-info-system` ke dalam direktori `C:\xampp\htdocs\`.
2. Jalankan modul **Apache** pada XAMPP Control Panel.
3. Buka browser dan akses alamat: **`http://localhost/product-info-system`**
