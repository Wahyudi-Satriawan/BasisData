<?php
include 'koneksi.php';

if (!isset($_POST['id_riwayat'], $_POST['status'])) {
    die("Data tidak lengkap.");
}

$id_riwayat = mysqli_real_escape_string($koneksi, $_POST['id_riwayat']);
$status = mysqli_real_escape_string($koneksi, $_POST['status']);

$query = mysqli_query($koneksi, "
    UPDATE riwayat_peminjaman 
    SET status = '$status' 
    WHERE id_riwayat = '$id_riwayat'
");

if ($query) {
    header("Location: riwayat_peminjaman.php?update=success");
} else {
    echo "Gagal mengubah status: " . mysqli_error($koneksi);
}
