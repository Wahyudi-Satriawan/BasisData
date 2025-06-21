<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
include 'template/header.php';
include 'koneksi.php';

// Tampilkan data dari form (debug)
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Validasi data dari form
if (!isset($_POST['nim'], $_POST['id_admin'], $_POST['kode_buku'], $_POST['tanggal_pinjam'], $_POST['tanggal_kembali'])) {
    die("Form tidak lengkap.");
}

// Ambil dan amankan input
$nim         = mysqli_real_escape_string($koneksi, $_POST['nim']);
$id_admin    = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
$kode_buku   = mysqli_real_escape_string($koneksi, $_POST['kode_buku']);
$tgl_pinjam  = $_POST['tanggal_pinjam'];
$tgl_kembali = $_POST['tanggal_kembali'];
$status_pinjam = 'Dipinjam';
$status_riwayat = 'Tepat Waktu'; // karena ini awal peminjaman

if ($nim === "" || $id_admin === "" || $kode_buku === "") {
    die("Field wajib tidak boleh kosong.");
}

// Buat ID peminjaman otomatis
$ambilIdTerakhir = mysqli_query($koneksi, "SELECT MAX(id_peminjaman) as max_id FROM peminjaman");
$dataId = mysqli_fetch_assoc($ambilIdTerakhir);
$lastId = $dataId['max_id'];

if ($lastId) {
    $angka = (int)substr($lastId, 1); // P001 -> 1
    $angkaBaru = $angka + 1;
    $id_peminjaman = 'P' . str_pad($angkaBaru, 3, '0', STR_PAD_LEFT);
} else {
    $id_peminjaman = 'P001';
}

// Buat ID riwayat otomatis
$ambilIdR = mysqli_query($koneksi, "SELECT MAX(id_riwayat) as max_id FROM riwayat_peminjaman");
$dataIdR = mysqli_fetch_assoc($ambilIdR);
$lastIdR = $dataIdR['max_id'];

if ($lastIdR) {
    $angka = (int)substr($lastIdR, 1); // R001 -> 1
    $angkaBaru = $angka + 1;
    $id_riwayat = 'R' . str_pad($angkaBaru, 3, '0', STR_PAD_LEFT);
} else {
    $id_riwayat = 'R001';
}

// Insert ke tabel peminjaman
$peminjaman = mysqli_query($koneksi, "
    INSERT INTO peminjaman (id_peminjaman, nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
    VALUES ('$id_peminjaman', '$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status_pinjam')
");

// Insert ke tabel riwayat_peminjaman
$riwayat = mysqli_query($koneksi, "
    INSERT INTO riwayat_peminjaman (id_riwayat, nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
    VALUES ('$id_riwayat', '$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status_riwayat')
");

// Cek keberhasilan
if ($peminjaman && $riwayat) {
    echo "Data peminjaman berhasil disimpan.<br><a href='form_peminjaman.php'>Kembali</a>";
} else {
    echo "Gagal menyimpan: " . mysqli_error($koneksi);
}
?>