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
  <h2>Formulir Peminjaman</h2>
  <form action="proses_peminjaman.php" method="post">
    <label>NIM:</label><input type="text" name="nim" required>
    <label>ID Admin:</label>
    <input type="text" name="id_admin_display" value="<?= $_SESSION['admin']; ?>" readonly style="background-color: #e9ecef;">
    <input type="hidden" name="id_admin" value="<?= $_SESSION['admin']; ?>">
    <label for="kode_buku">Pilih Buku:</label>
    <select name="kode_buku" id="kode_buku" required>
        <option value="">-- Pilih Kode Buku --</option>
        <?php
        include 'koneksi.php';
        $result = mysqli_query($koneksi, "SELECT kode_buku, judul FROM buku WHERE jumlah_stok > 0");
        while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='{$row['kode_buku']}'>{$row['kode_buku']} - {$row['judul']}</option>";
    }
  ?>
</select>
    <label>Tanggal Pinjam:</label><input type="date" name="tanggal_pinjam" required>
    <label>Tanggal Kembali:</label><input type="date" name="tanggal_kembali" required>
    <input type="submit" value="Pinjam">
  </form>
</main>
<?php include 'template/footer.php'; ?>