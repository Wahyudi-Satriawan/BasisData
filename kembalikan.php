<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
include 'template/header.php';
?>

<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
  die("ID peminjaman tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data peminjaman yang ingin dikembalikan
$ambil = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id'");
$data  = mysqli_fetch_assoc($ambil);

if (!$data) {
  die("Data tidak ditemukan.");
}

$nim         = $data['nim'];
$id_admin    = $data['id_admin'];
$kode_buku   = $data['kode_buku'];
$tgl_pinjam  = $data['tanggal_pinjam'];
$tgl_kembali  = $data['tanggal_kembali'];
$hari_ini    = date('Y-m-d');

// Tentukan status pengembalian
$status_pengembalian = ($hari_ini > $tgl_kembali) ? 'Terlambat' : 'Tepat Waktu';

// Update status di tabel peminjaman
mysqli_query($koneksi, "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id_peminjaman = '$id'");

// Tambahkan entri ke riwayat
mysqli_query($koneksi, "INSERT INTO riwayat_peminjaman (id_riwayat, nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
VALUES (NULL, '$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$hari_ini', '$status_pengembalian')");

// Kembalikan stok buku
mysqli_query($koneksi, "UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE kode_buku = '$kode_buku'");

echo "<script>alert('Buku berhasil dikembalikan.'); window.location='daftar_peminjaman.php';</script>";
?>