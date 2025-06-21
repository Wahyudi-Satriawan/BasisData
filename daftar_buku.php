<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}

include 'koneksi.php';

// logika update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
  $kode = $_POST['update'];
  $stok = intval($_POST['stok'][$kode]);
  mysqli_query($koneksi, "UPDATE buku SET jumlah_stok = $stok WHERE kode_buku = '$kode'");
  echo "<script>alert('Stok berhasil diperbarui'); window.location='daftar_buku.php';</script>";
}
?>


<?php include 'koneksi.php'; include 'template/header.php'; ?>
<main>
  <h2>Daftar Buku</h2>
  <form method="POST" action="">
    <table>
      <tr>
        <th>Kode</th><th>Judul</th><th>Pengarang</th><th>Tahun</th><th>Stok</th>
      </tr>
      <?php
        $buku = mysqli_query($koneksi, "SELECT * FROM buku");
        while($row = mysqli_fetch_assoc($buku)) {
          echo "<tr>
            <td>{$row['kode_buku']}</td>
            <td>{$row['judul']}</td>
            <td>{$row['pengarang']}</td>
            <td>{$row['tahun_terbit']}</td>
            <td>
              <form method='POST' style='display: flex; gap: 6px; align-items: center;'>
                <input type='hidden' name='update' value='{$row['kode_buku']}'>
                <input type='number' name='stok[{$row['kode_buku']}]' value='{$row['jumlah_stok']}' min='0' style='width: 60px;'>
                <button type='submit'>Simpan</button>
              </form>
            </td>
          </tr>";
        }
      ?>
    </table>
  </form>
</main>

<?php include 'template/footer.php'; ?>