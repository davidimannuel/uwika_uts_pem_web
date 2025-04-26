# Warehouse Management System  
**Subjek:** UTS Pemrograman Web  
**Nama:** David  
**NRP:** 31123022  

## Studi Kasus

PT Indomarco Prismatama merupakan salah satu perusahaan retail yang memiliki banyak cabang.  
Guna mempertahankan harga yang kompetitif, perusahaan ini harus memiliki sistem gudang yang efisien dan tercatat dengan baik.

**Tugas:**  
Buatlah sistem untuk membantu proses pencatatan warehouse produk barang retail.  
Alur yang harus dikelola dalam warehouse ini adalah:

- **Penerimaan barang** (Inbound)
- **Penyimpanan inventaris** (Stock inventory management)
- **Pencatatan barang keluar** (Outbound)

Semua barang dianggap **berasal dari satu supplier**, sehingga tidak perlu dibuat master supplier.  
Perlu diperhatikan **jumlah stok** dari masing-masing barang dan **kategorinya**.

---

## Asumsi

- Semua barang **hanya dari satu supplier**, sehingga **tidak perlu** ada tabel master supplier.
- Tidak ada autentikasi
- **Satu barang hanya bisa memiliki satu kategori.**
- Sistem hanya mendukung **dua unit**:
  - `PCS` (satuan barang)
  - `PACK` (kumpulan PCS, bisa berupa karton, plastik, atau unit lain).
- Saat **menambahkan barang baru**, **stok tidak bisa langsung diinput**.  
  Stok hanya dapat **ditambahkan melalui menu stock transactions** (Inbound/Outbound).
- **Informasi unit** (`unit`, `pcs_per_pack`) **tidak bisa diubah setelah barang dibuat** untuk menjaga **konsistensi stok**.
- Jika barang memiliki informasi `pcs_per_pack`, user dapat input jumlah **PCS**, dan sistem akan otomatis mengonversinya menjadi **PACK** apabila jumlah PCS memenuhi kelipatan `pcs_per_pack`.

---

## Struktur Fitur

- **Item Categories**: Manajemen kategori barang.
- **Items**: Manajemen data barang termasuk nama, kategori, unit (`PCS` atau `PACK`), dan `pcs_per_pack` (jika unit = `PACK`).
- **Inbound Transactions**: Mencatat penerimaan barang ke dalam stok.
- **Outbound Transactions**: Mencatat pengeluaran barang dari stok.

---

## Teknologi yang Digunakan

- PHP (Native, tanpa framework besar)
- PostgreSQL (Database)
- Bootstrap 5 (Frontend styling)
- Struktur MVC sederhana untuk manajemen kode

---

## Cara Menjalankan

1. **Clone/download** project ini ke local server (XAMPP/Laragon/dsb).
2. **Import database** menggunakan file SQL yang disediakan.
3. **Set konfigurasi koneksi database** di file konfigurasi.
4. **Akses project via browser**.

---

## Resources Belajar

- Tutorial PHP MVC oleh Laracasts:
  - [Playlist YouTube](https://www.youtube.com/playlist?list=PL3VM-unCzF8ipG50KDjnzhugceoSG3RTC)
  - [PHP for Beginners Full Course (YouTube)](https://www.youtube.com/watch?v=fw5ObX8P6as&t=5278s&pp=ygUPcGhwIGZ1bGwgY291cnNl)
  - [GitHub Repository PHP For Beginners](https://github.com/laracasts/PHP-For-Beginners-Series)
- Standar coding PHP:
  - [PSR-1: Basic Coding Standard - PHP-FIG](https://www.php-fig.org/psr/psr-1/)

---

## Note Tambahan

- Validasi form dilakukan pada sisi server dan sebagian pada sisi client (JavaScript dasar).
- Gunakan transaksi stock (Inbound/Outbound) untuk semua perubahan jumlah barang.
- Data `pcs_per_pack` diperlukan hanya untuk barang dengan unit `PACK`.
