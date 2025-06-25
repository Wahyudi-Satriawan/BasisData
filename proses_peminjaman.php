<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die("Akses tidak sah.");
}

// Ambil dan amankan data dari form
$nim         = mysqli_real_escape_string($koneksi, $_POST['nim']);
$id_admin    = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
$kode_buku   = mysqli_real_escape_string($koneksi, $_POST['kode_buku']);
$tgl_pinjam  = mysqli_real_escape_string($koneksi, $_POST['tanggal_pinjam']);
$tgl_kembali = mysqli_real_escape_string($koneksi, $_POST['tanggal_kembali']);

// Cek apakah stok tersedia
$cekStok = mysqli_query($koneksi, "SELECT jumlah_stok FROM buku WHERE kode_buku = '$kode_buku'");
$stok = mysqli_fetch_assoc($cekStok);

if (!$stok || $stok['jumlah_stok'] <= 0) {
  die("Stok tidak mencukupi atau buku tidak ditemukan.");
}

// Cek apakah NIM ada di tabel mahasiswa (foreign key)
$cekMahasiswa = mysqli_query($koneksi, "SELECT nim FROM mahasiswa WHERE nim = '$nim'");
if (mysqli_num_rows($cekMahasiswa) === 0) {
  die("NIM tidak terdaftar dalam data mahasiswa.");
}

// Generate ID riwayat otomatis
$max = mysqli_query($koneksi, "SELECT MAX(id_riwayat) AS maxid FROM riwayat_peminjaman");
$lastId = mysqli_fetch_assoc($max)['maxid'];

$angkaBaru = $lastId ? (int)substr($lastId, 2) + 1 : 1; // potong 2 huruf "RI"
$id_riwayat = 'RI' . str_pad($angkaBaru, 3, '0', STR_PAD_LEFT); // hasil: RI001, RI002, dst

// Insert data ke riwayat_peminjaman
$query = mysqli_query($koneksi, "
  INSERT INTO riwayat_peminjaman (id_riwayat, nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
  VALUES ('$id_riwayat', '$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', 'Dipinjam')
");

if ($query) {
  // Kurangi stok buku
  mysqli_query($koneksi, "
    UPDATE buku SET jumlah_stok = jumlah_stok - 1 WHERE kode_buku = '$kode_buku'
  ");

  echo "<script>alert('Peminjaman berhasil disimpan.'); window.location='riwayat_peminjaman.php';</script>";
} else {
  echo "Gagal menyimpan data: " . mysqli_error($koneksi);
}
?>