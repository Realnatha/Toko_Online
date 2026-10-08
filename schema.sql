-- =====================================================
-- Studi Kasus: Toko Online (Kategori, Produk, Penjualan)
-- =====================================================
DROP DATABASE IF EXISTS toko_online;
CREATE DATABASE toko_online CHARACTER SET utf8mb4;
USE toko_online;

-- ---------- DDL ----------
CREATE TABLE kategori (
    id_kategori   INT AUTO_INCREMENT PRIMARY KEY,
    kode_kategori VARCHAR(10)  NOT NULL UNIQUE,
    nama_kategori VARCHAR(50)  NOT NULL,
    deskripsi     VARCHAR(150)
) ENGINE=InnoDB;

CREATE TABLE produk (
    id_produk   INT AUTO_INCREMENT PRIMARY KEY,
    id_kategori INT          NOT NULL,
    nama_produk VARCHAR(80)  NOT NULL,
    merek       VARCHAR(50),
    harga       DECIMAL(12,2) NOT NULL,
    stok        INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_produk_kategori FOREIGN KEY (id_kategori)
        REFERENCES kategori(id_kategori)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE penjualan (
    id_penjualan INT AUTO_INCREMENT PRIMARY KEY,
    id_produk    INT NOT NULL,
    nama_pembeli VARCHAR(60) NOT NULL,
    jumlah       INT NOT NULL,
    total_harga  DECIMAL(12,2) NOT NULL,
    tanggal      DATE NOT NULL,
    CONSTRAINT fk_penjualan_produk FOREIGN KEY (id_produk)
        REFERENCES produk(id_produk)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ---------- DML ----------
INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi) VALUES
('ELK', 'Elektronik',  'Perangkat elektronik dan gadget'),
('FSN', 'Fashion',     'Pakaian, tas, dan aksesori'),
('MKN', 'Makanan',     'Makanan dan minuman kemasan'),
('OLR', 'Olahraga',    'Perlengkapan olahraga'),
('BKU', 'Buku',        'Buku bacaan dan alat tulis');

INSERT INTO produk (id_kategori, nama_produk, merek, harga, stok) VALUES
(1, 'Headphone Bluetooth', 'SoundMax', 350000, 25),
(1, 'Power Bank 10000mAh', 'Charge+',  180000, 40),
(2, 'Kemeja Flanel',       'UrbanWear', 220000, 30),
(2, 'Tas Ransel',          'Trekker',   275000, 15),
(3, 'Keripik Singkong',    'Renyah',     15000, 100),
(4, 'Matras Yoga',         'FitLife',   120000, 20),
(5, 'Buku Pemrograman PHP','Informatika',95000, 12);

INSERT INTO penjualan (id_produk, nama_pembeli, jumlah, total_harga, tanggal) VALUES
(1, 'Andi Saputra',   1, 350000, '2025-01-10'),
(2, 'Budi Santoso',   2, 360000, '2025-01-12'),
(3, 'Citra Dewi',     1, 220000, '2025-01-15'),
(5, 'Dina Marlina',  10, 150000, '2025-01-18'),
(4, 'Eko Prasetyo',   1, 275000, '2025-01-20'),
(7, 'Fajar Nugroho',  2, 190000, '2025-01-22');

-- ---------- QUERY SAMPLE ----------
-- SELECT * FROM produk WHERE harga > 200000 ORDER BY harga DESC;

-- JOIN (produk + kategori)
-- SELECT p.nama_produk, k.nama_kategori, p.harga
-- FROM produk p JOIN kategori k ON p.id_kategori = k.id_kategori;

-- JOIN 3 tabel
-- SELECT j.id_penjualan, j.nama_pembeli, p.nama_produk, k.nama_kategori, j.total_harga
-- FROM penjualan j
-- JOIN produk p ON j.id_produk = p.id_produk
-- JOIN kategori k ON p.id_kategori = k.id_kategori;

-- UPDATE
-- UPDATE produk SET stok = stok - 1 WHERE id_produk = 1;

-- DELETE
-- DELETE FROM penjualan WHERE id_penjualan = 6;
