<?php
require_once "services/config.php";

// Query 1: Kategori + jumlah produk (LEFT JOIN + GROUP BY) -> relasi 1-to-Many
$qKategori = "SELECT k.id_kategori, k.kode_kategori, k.nama_kategori, k.deskripsi,
                     COUNT(p.id_produk) AS jumlah_produk
              FROM kategori k
              LEFT JOIN produk p ON p.id_kategori = k.id_kategori
              GROUP BY k.id_kategori, k.kode_kategori, k.nama_kategori, k.deskripsi
              ORDER BY k.id_kategori";
$rKategori = $conn->query($qKategori);

// Query 2: Produk + nama kategori (JOIN)
$qProduk = "SELECT p.id_produk, p.nama_produk, p.merek, p.harga, p.stok, k.nama_kategori
            FROM produk p
            JOIN kategori k ON p.id_kategori = k.id_kategori
            ORDER BY p.id_produk";
$rProduk = $conn->query($qProduk);

// Query 3: Penjualan + produk + kategori (JOIN 3 tabel)
$qJual = "SELECT j.id_penjualan, j.nama_pembeli, p.nama_produk, k.nama_kategori,
                 j.jumlah, j.total_harga, j.tanggal
          FROM penjualan j
          JOIN produk p   ON j.id_produk = p.id_produk
          JOIN kategori k ON p.id_kategori = k.id_kategori
          ORDER BY j.tanggal";
$rJual = $conn->query($qJual);

function rp($n) { return "Rp " . number_format($n, 0, ',', '.'); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Toko Online - Data Tabel</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar">
    <div class="brand">🛒 Toko Online</div>
    <div class="nav-links">
      <a href="#kategori">Kategori</a>
      <a href="#produk">Produk</a>
      <a href="#penjualan">Penjualan</a>
    </div>
  </nav>

  <main class="container">
    <header class="hero">
      <h1>Data Toko Online</h1>
      <p>Menampilkan 3 tabel berelasi: Kategori → Produk → Penjualan</p>
    </header>

    <section id="kategori" class="card">
      <h2>Tabel Kategori</h2>
      <div class="table-wrap">
        <table>
          <thead><tr><th>ID</th><th>Kode</th><th>Nama Kategori</th><th>Deskripsi</th><th>Jumlah Produk</th></tr></thead>
          <tbody>
          <?php while ($row = $rKategori->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id_kategori'] ?></td>
              <td><?= htmlspecialchars($row['kode_kategori']) ?></td>
              <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
              <td><?= htmlspecialchars($row['deskripsi']) ?></td>
              <td><?= $row['jumlah_produk'] ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="produk" class="card">
      <h2>Tabel Produk</h2>
      <div class="table-wrap">
        <table>
          <thead><tr><th>ID</th><th>Nama Produk</th><th>Merek</th><th>Kategori</th><th>Harga</th><th>Stok</th></tr></thead>
          <tbody>
          <?php while ($row = $rProduk->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id_produk'] ?></td>
              <td><?= htmlspecialchars($row['nama_produk']) ?></td>
              <td><?= htmlspecialchars($row['merek']) ?></td>
              <td><span class="badge"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
              <td><?= rp($row['harga']) ?></td>
              <td><?= $row['stok'] ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <section id="penjualan" class="card">
      <h2>Tabel Penjualan</h2>
      <div class="table-wrap">
        <table>
          <thead><tr><th>ID</th><th>Pembeli</th><th>Produk</th><th>Kategori</th><th>Jumlah</th><th>Total</th><th>Tanggal</th></tr></thead>
          <tbody>
          <?php while ($row = $rJual->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id_penjualan'] ?></td>
              <td><?= htmlspecialchars($row['nama_pembeli']) ?></td>
              <td><?= htmlspecialchars($row['nama_produk']) ?></td>
              <td><span class="badge"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
              <td><?= $row['jumlah'] ?></td>
              <td><?= rp($row['total_harga']) ?></td>
              <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <footer class="footer">&copy; <?= date('Y') ?> Toko Online - Tugas Praktikum</footer>
</body>
</html>
<?php $conn->close(); ?>
