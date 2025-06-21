<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header('Location: login.php');
  exit;
}
?>

<?php include 'koneksi.php'; include 'template/header.php'; ?>
<main>
  <h2>Peminjaman Aktif</h2>
  <table>
    <tr><th>NIM</th><th>Kode Buku</th><th>Pinjam</th><th>Kembali</th><th>Aksi</th></tr>
    <?php
      $peminjaman = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE status = 'Dipinjam'");
      while($row = mysqli_fetch_assoc($peminjaman)) {
        echo "<tr>
                <td>{$row['nim']}</td>
                <td>{$row['kode_buku']}</td>
                <td>{$row['tanggal_pinjam']}</td>
                <td>{$row['tanggal_kembali']}</td>
                <td><a href='kembalikan.php?id={$row['id_peminjaman']}'>Kembalikan</a></td>
              </tr>";
      }
    ?>
  </table>
</main>
<?php include 'template/footer.php'; ?>