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

// Tampilkan data dari form (debug)
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Validasi data dari form
if (
    !isset($_POST['nim'], $_POST['id_admin'], $_POST['kode_buku'], $_POST['tanggal_pinjam'], $_POST['tanggal_kembali'])
) {
    die("Form tidak lengkap.");
}

// Ambil dan amankan input
$nim         = mysqli_real_escape_string($koneksi, $_POST['nim']);
$id_admin    = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
$kode_buku   = mysqli_real_escape_string($koneksi, $_POST['kode_buku']);
$tgl_pinjam  = $_POST['tanggal_pinjam'];
$tgl_kembali = $_POST['tanggal_kembali'];
$status      = 'Dipinjam';

// Validasi isi
if ($nim === "" || $id_admin === "" || $kode_buku === "") {
    die("Field wajib tidak boleh kosong.");
}

// ✅ Buat ID peminjaman manual (otomatis + increment)
// Misalnya format: P001, P002, dst
$ambilIdTerakhir = mysqli_query($koneksi, "SELECT MAX(id_peminjaman) as max_id FROM peminjaman");
$dataId = mysqli_fetch_assoc($ambilIdTerakhir);
$lastId = $dataId['max_id'];

if ($lastId) {
    $angka = (int)substr($lastId, 1); // ambil angka dari P001 -> 1
    $angkaBaru = $angka + 1;
    $id_peminjaman = 'P' . str_pad($angkaBaru, 3, '0', STR_PAD_LEFT); // jadi P002 dst
} else {
    $id_peminjaman = 'P001'; // jika belum ada data
}

// Insert ke tabel peminjaman
$peminjaman = mysqli_query($koneksi, "
    INSERT INTO peminjaman (id_peminjaman, nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status)
    VALUES ('$id_peminjaman', '$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status')
");

// Insert ke tabel riwayat_peminjaman (boleh pakai ID yang sama atau tanpa)
$riwayat = mysqli_query($koneksi, "
    INSERT INTO riwayat_peminjaman (nim, id_admin, kode_buku, tanggal_pinjam, tanggal_kembali, status, keterangan)
    VALUES ('$nim', '$id_admin', '$kode_buku', '$tgl_pinjam', '$tgl_kembali', '$status', 'Transaksi peminjaman awal')
");

// Cek keberhasilan
if ($peminjaman && $riwayat) {
    echo "Data peminjaman berhasil disimpan.<br><a href='form_peminjaman.php'>Kembali</a>";
} else {
    echo "Gagal menyimpan: " . mysqli_error($koneksi);
}
?>
