<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
?>

<?php include 'koneksi.php'; include 'template/header.php'; ?>
<main>
  <h2>Riwayat Peminjaman</h2>
  <table>
    <tr><th>ID</th><th>NIM</th><th>Kode Buku</th><th>Pinjam</th><th>Kembali</th><th>Status</th></tr>
    <?php
      $riwayat = mysqli_query($koneksi, "SELECT * FROM riwayat_peminjaman");
      while($r = mysqli_fetch_assoc($riwayat)) {
        echo "<tr>
                <td>{$r['id_riwayat']}</td>
                <td>{$r['nim']}</td>
                <td>{$r['kode_buku']}</td>
                <td>{$r['tanggal_pinjam']}</td>
                <td>{$r['tanggal_kembali']}</td>
                <td>{$r['status']}</td>
              </tr>";
      }
    ?>
  </table>
</main>
<?php include 'template/footer.php'; ?>