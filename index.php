<?php include 'template/header.php'; include 'koneksi.php'; ?>
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
    <!-- Kotak Buku Paling Sering Dipinjam -->
    <div class="stat-box center-text">
      <h3>📌 Buku Paling Sering Dipinjam</h3>
      <ul style="list-style: none; padding: 0;">
        <?php
          $s = mysqli_query($koneksi, "
            SELECT b.judul, COUNT(*) AS t
            FROM riwayat_peminjaman r
            JOIN buku b ON r.kode_buku = b.kode_buku
            GROUP BY b.kode_buku ORDER BY t DESC LIMIT 3
          ");
          while ($r = mysqli_fetch_assoc($s)) {
            echo "<li style='margin: 6px 0; font-weight: bold;'>"
              . htmlspecialchars($r['judul']) . " ({$r['t']}x)</li>";
          }
        ?>
      </ul>
    </div>

    <!-- Kotak Total Stok Buku -->
    <div class="stat-box center-text">
      <h3>📚 Jumlah Total Buku Tersedia</h3>
      <p style="font-size: 24px; margin-top: 10px;">
        <?php
          $stok = mysqli_query($koneksi, "SELECT SUM(jumlah_stok) AS total FROM buku");
          $total = mysqli_fetch_assoc($stok);
          echo $total['total'] ?? 0;
        ?> buku
      </p>
    </div>
  </div>
</section>

<?php include 'template/footer.php'; ?>