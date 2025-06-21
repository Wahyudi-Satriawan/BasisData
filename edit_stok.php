<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
include 'koneksi.php';

if (!isset($_GET['kode'])) {
  die("Kode buku tidak ditemukan.");
}

$kode = $_GET['kode'];
$buku = mysqli_query($koneksi, "SELECT * FROM buku WHERE kode_buku = '$kode'");
$data = mysqli_fetch_assoc($buku);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $stok = intval($_POST['stok']);
  mysqli_query($koneksi, "UPDATE buku SET jumlah_stok = $stok WHERE kode_buku = '$kode'");
  header("Location: daftar_buku.php");
  exit;
}
?>

<?php include 'template/header.php'; ?>
<main>
  <h2>Edit Stok Buku</h2>
  <form method="POST">
    <p><strong>Kode Buku:</strong> <?= $data['kode_buku']; ?></p>
    <p><strong>Judul:</strong> <?= $data['judul']; ?></p>
    <label for="stok">Jumlah Stok Baru:</label>
    <input type="number" name="stok" id="stok" value="<?= $data['jumlah_stok']; ?>" required>
    <input type="submit" value="Update">
  </form>
</main>
<?php include 'template/footer.php'; ?>