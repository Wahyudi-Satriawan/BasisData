<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
include 'koneksi.php';
include 'template/header.php';
?>

<main>
  <h2>📝 Formulir Peminjaman</h2>

  <form action="proses_peminjaman.php" method="POST">
    <label for="nim">NIM:</label>
    <input type="text" name="nim" id="nim" required placeholder="Masukkan NIM mahasiswa">

    <label for="admin_display">ID Admin:</label>
    <input type="text" id="admin_display" value="<?= $_SESSION['admin'] ?>" readonly style="background-color: #e9ecef;">
    <input type="hidden" name="id_admin" value="<?= $_SESSION['admin'] ?>">

    <label for="kode_buku">Pilih Buku:</label>
    <select name="kode_buku" id="kode_buku" required>
      <option value="">-- Pilih Buku --</option>
      <?php
        $q = mysqli_query($koneksi, "SELECT kode_buku, judul FROM buku WHERE jumlah_stok > 0");
        while ($r = mysqli_fetch_assoc($q)) {
          echo "<option value='" . $r['kode_buku'] . "'>" . $r['kode_buku'] . " – " . htmlspecialchars($r['judul']) . "</option>";
        }
      ?>
    </select>

    <label for="tanggal_pinjam">Tanggal Pinjam:</label>
    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required>

    <label for="tanggal_kembali">Tanggal Kembali:</label>
    <input type="date" name="tanggal_kembali" id="tanggal_kembali" required>

    <input type="submit" value="Pinjam">
  </form>
</main>

<?php include 'template/footer.php'; ?>