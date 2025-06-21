<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
include 'koneksi.php';
?>

<?php include 'template/header.php'; ?>
<main>
  <h1>Selamat Datang</h1>
  <p>"Setiap buku adalah jendela. Setiap peminjaman adalah langkah kecil menuju dunia yang lebih luas."</p>
  <div class="menu-links">
    <a href="form_peminjaman.php">📄 Form Peminjaman</a>
    <a href="daftar_buku.php">📚 Daftar Buku</a>
    <a href="riwayat.php">📜 Riwayat Peminjaman</a>
  </div>
</main>
<?php include 'template/footer.php'; ?>