<?php
include 'template/header.php';
include 'koneksi.php';
?>

<main>
  <h2>📚 Daftar Buku</h2>

  <?php
  $msg = '';
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['update'];
    $stok = intval($_POST['stok'][$kode]);
    if ($stok >= 0) {
      if (mysqli_query($koneksi, "UPDATE buku SET jumlah_stok = $stok WHERE kode_buku = '$kode'")) {
        $msg = 'Stok berhasil diperbarui.';
      } else {
        $msg = 'Gagal: ' . mysqli_error($koneksi);
      }
    } else {
      $msg = 'Stok tidak boleh negatif.';
    }
  }

  if ($msg) {
    echo '<div class="notif">' . htmlspecialchars($msg) . '</div>';
  }
  ?>

  <table class="styled-table">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Tahun</th>
        <th>Stok</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $q = mysqli_query($koneksi, "SELECT * FROM buku");
      while ($r = mysqli_fetch_assoc($q)) {
        echo "<tr>";
        echo "<form method='POST'>";
        echo "<td>" . $r['kode_buku'] . "</td>";
        echo "<td>" . htmlspecialchars($r['judul']) . "</td>";
        echo "<td>" . htmlspecialchars($r['pengarang']) . "</td>";
        echo "<td>" . $r['tahun_terbit'] . "</td>";
        echo "<td><input type='number' name='stok[" . $r['kode_buku'] . "]' value='" . $r['jumlah_stok'] . "' min='0' style='width:70px; padding:6px; border-radius:4px; border:1px solid #ccc;'></td>";
        echo "<td>
                <input type='hidden' name='update' value='" . $r['kode_buku'] . "'>
                <button type='submit' class='btn-update'>Simpan</button>
              </td>";
        echo "</form>";
        echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</main>

<?php include 'template/footer.php'; ?>
