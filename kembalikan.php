<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
include 'koneksi.php';

if (!isset($_POST['id_peminjaman'])) {
  die("ID peminjaman tidak dikirim.");
}

$id = $_POST['id_peminjaman'];

// Ambil data peminjaman berdasarkan ID
$result = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id'");
$data = mysqli_fetch_assoc($result);

if (!$data) {
  die("Data peminjaman tidak ditemukan.");
}

$tanggal_now = date('Y-m-d');
$tgl_kembali = $data['tanggal_kembali'];

// ❗ Logika penentuan status
$status = ($tanggal_now > $tgl_kembali) ? 'Terlambat' : 'Tepat Waktu';

// Update status di riwayat_peminjaman
mysqli_query($koneksi, "
  UPDATE riwayat_peminjaman
  SET status = '$status'
  WHERE nim = '{$data['nim']}' AND kode_buku = '{$data['kode_buku']}' AND tanggal_pinjam = '{$data['tanggal_pinjam']}'
");

// Hapus dari tabel peminjaman (karena sudah dikembalikan)
mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id_peminjaman = '$id'");

header("Location: daftar_peminjaman.php");
exit;
?>