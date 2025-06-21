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
  <h1>Selamat Datang</h1>
  <p>"Setiap buku adalah jendela yang membuka cakrawala ilmu dan membebaskan dari ketidaktahuan."</p>

  <div class="menu-links">
    <a href="form_peminjaman.php">📄 Form Peminjaman</a>
    <a href="daftar_buku.php">📚 Daftar Buku</a>
    <a href="riwayat_peminjaman.php">📜 Riwayat Peminjaman</a>
  </div>

  <section class="dashboard-stats">
    <h2>📊 Statistik</h2>

    <div class="stat-grid">
      <!-- Statistik: Buku Paling Sering Dipinjam -->
      <div class="stat-box center-text">
        <h3>📌 Buku Paling Sering Dipinjam</h3>
        <ul style="list-style: none; padding: 0;">
          <?php
          $sql_populer = "
            SELECT b.judul, COUNT(*) AS total_pinjam
            FROM riwayat_peminjaman r
            JOIN buku b ON r.kode_buku = b.kode_buku
            GROUP BY b.kode_buku
            ORDER BY total_pinjam DESC
            LIMIT 3
          ";

          $result = mysqli_query($koneksi, $sql_populer);
          if ($result && mysqli_num_rows($result) > 0) {
            while ($data = mysqli_fetch_assoc($result)) {
              echo "<li style='margin: 6px 0; font-weight: bold;'>" .
                   htmlspecialchars($data['judul']) . " ({$data['total_pinjam']}x)</li>";
            }
          } else {
            echo "<li>Tidak ada data.</li>";
          }
          ?>
        </ul>
      </div>

      <!-- Statistik: Jumlah Total Buku -->
      <div class="stat-box center-text">
        <h3>📚 Jumlah Total Buku Tersedia</h3>
        <p class="total-buku">
          <?php
          $stok = mysqli_query($koneksi, "SELECT SUM(jumlah_stok) AS total FROM buku");
          $total = mysqli_fetch_assoc($stok);
          echo intval($total['total']) . " buku";
          ?>
        </p>
      </div>
    </div>
  </section>
</main>

<?php include 'template/footer.php'; ?>