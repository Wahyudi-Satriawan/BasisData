<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan di URL.");
}
$id = $_GET['id'];

$ambil = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id'");
$data = mysqli_fetch_assoc($ambil);

if ($data) {
    $nim = $data['nim'];
    $id_admin = $data['id_admin'];
    $kode_buku = $data['kode_buku'];
    $tgl_pinjam = $data['tanggal_pinjam'];
    $tgl_kembali = $data['tanggal_kembali'];
    $status = 'dikembalikan';
    $keterangan = 'Buku dikembalikan';

    // Tanpa kutip untuk INT
    $insert = mysqli_query($koneksi, "
        INSERT INTO riwayat_peminjaman
        (nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status, keterangan)
        VALUES
        ('$nim', $id_admin, '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status', '$keterangan')
    ");

    if ($insert) {
        mysqli_query($koneksi, "DELETE FROM peminjaman WHERE id_peminjaman = '$id'");
        echo "Buku telah dikembalikan dan dipindahkan ke riwayat.<br><a href='daftar_peminjaman.php'>Kembali</a>";
    } else {
        echo "Gagal memasukkan ke riwayat: " . mysqli_error($koneksi);
    }
} else {
    echo "Data tidak ditemukan.";
}
?>
