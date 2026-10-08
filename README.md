# Toko Online – Tugas Web PHP + MySQL

Web sederhana yang menampilkan 3 tabel berelasi (Kategori, Produk, Penjualan) dari database MySQL.

## Cara Menjalankan
1. Install XAMPP/Laragon, aktifkan Apache & MySQL.
2. Salin folder project ke `htdocs/` (mis. `htdocs/toko-online`).
3. Buka phpMyAdmin → tab **Import** → pilih `database/schema.sql` → Go.
4. Sesuaikan user/password di `services/config.php` bila perlu.
5. Buka `http://localhost/toko-online/`.

## Struktur Project
```
toko-online/
├── services/config.php   # koneksi mysqli
├── database/schema.sql   # DDL + DML + query sample
├── index.php             # halaman utama (3 tabel)
├── style.css             # styling (1 warna brand, flex, responsive)
└── README.md
```

## Entitas & Atribut
**kategori** (Master): `id_kategori` (PK), `kode_kategori` (UNIQUE), `nama_kategori`, `deskripsi`

**produk** (Master): `id_produk` (PK), `id_kategori` (FK → kategori), `nama_produk`, `merek`, `harga`, `stok`

**penjualan** (Transaksi): `id_penjualan` (PK), `id_produk` (FK → produk), `nama_pembeli`, `jumlah`, `total_harga`, `tanggal`

## Relasi & Kardinalitas
| Relasi | Kardinalitas | Penjelasan |
|---|---|---|
| kategori → produk | **1 : N** | Satu kategori punya banyak produk; satu produk hanya di satu kategori |
| produk → penjualan | **1 : N** | Satu produk bisa terjual berkali-kali; satu baris penjualan untuk satu produk |
| kategori → penjualan | 1 : N (tidak langsung) | Melalui tabel produk (JOIN 3 tabel) |

```
KATEGORI 1 ──< PRODUK 1 ──< PENJUALAN
```

## Query Sample
```sql
-- SELECT
SELECT * FROM produk WHERE harga > 200000 ORDER BY harga DESC;

-- JOIN
SELECT p.nama_produk, k.nama_kategori, p.harga
FROM produk p JOIN kategori k ON p.id_kategori = k.id_kategori;

-- JOIN 3 tabel
SELECT j.id_penjualan, j.nama_pembeli, p.nama_produk, k.nama_kategori, j.total_harga
FROM penjualan j
JOIN produk p ON j.id_produk = p.id_produk
JOIN kategori k ON p.id_kategori = k.id_kategori;

-- UPDATE
UPDATE produk SET stok = stok - 1 WHERE id_produk = 1;

-- DELETE
DELETE FROM penjualan WHERE id_penjualan = 6;
```
