<?php
include 'koneksi.php';

echo "<pre>";
print_r($_POST);
echo "</pre>";

// Validasi form
if (
    !isset($_POST['nim'], $_POST['id_admin'], $_POST['kode_buku'], $_POST['tanggal_pinjam'], $_POST['tanggal_kembali'])
) {
    die("Form tidak lengkap.");
}

$nim         = $_POST['nim'];
$id_admin    = $_POST['id_admin'];
$kode_buku   = $_POST['kode_buku'];
$tgl_pinjam  = $_POST['tanggal_pinjam'];
$tgl_kembali = $_POST['tanggal_kembali'];
$status      = 'Dipinjam';

// Validasi isi
if ($nim == "" || $id_admin == "" || $kode_buku == "") {
    die("Field wajib tidak boleh kosong.");
}

// Insert ke tabel peminjaman
$peminjaman = mysqli_query($koneksi, "
    INSERT INTO peminjaman (nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
    VALUES ('$nim', $id_admin, '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status')
");

// Insert ke tabel riwayat
$riwayat = mysqli_query($koneksi, "
    INSERT INTO riwayat_peminjaman (nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status, keterangan)
    VALUES ('$nim', $id_admin, '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status', 'Transaksi peminjaman awal')
");

if ($peminjaman && $riwayat) {
    echo "Data peminjaman berhasil disimpan.<br><a href='form_peminjaman.php'>Kembali</a>";
} else {
    echo "Gagal menyimpan: " . mysqli_error($koneksi);
}
?>
