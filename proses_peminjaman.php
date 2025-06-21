<?php
include 'koneksi.php';

$nim            = $_POST['nim'];
$id_admin       = $_POST['id_admin'];
$kode_buku      = $_POST['kode_buku'];
$tgl_pinjam     = $_POST['tanggal_pinjam'];
$tgl_kembali    = $_POST['tanggal_kembali'];
$status         = 'Dipinjam';

// Masukkan ke tabel peminjaman
$peminjaman = mysqli_query($koneksi, "
    INSERT INTO peminjaman (nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
    VALUES ('$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status')
");

// Masukkan juga ke riwayat_peminjaman
$riwayat = mysqli_query($koneksi, "
    INSERT INTO riwayat_peminjaman (nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status, keterangan)
    VALUES ('$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status', 'Transaksi peminjaman awal')
");

if ($peminjaman && $riwayat) {
    echo "Data peminjaman berhasil disimpan.<br><a href='form_peminjaman.php'>Kembali</a>";
} else {
    echo "Gagal menyimpan: " . mysqli_error($koneksi);
}
?>
