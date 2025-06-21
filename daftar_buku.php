<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Daftar Buku</title>
  <style>
    :root {
      --kayu: #5d4037;
      --perkamen: #f5e3c1;
      --teks: #3e2723;
      --krem: #fef8e7;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Georgia', serif;
    }

    body {
      background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                url('img/background-kayu.jpg') no-repeat center center fixed;
      background-size: cover;
      color: var(--teks);
    }

    header {
      background-color: rgba(93, 64, 55, 0.95);
      color: #fff9f0;
      padding: 1.5em;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0,0,0,0.3);
      border-bottom: 4px solid #3e2723;
    }

    nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 10px;
      flex-wrap: wrap;
    }

    nav ul li {
      display: flex;
      align-items: center;
    }

    nav ul li a {
      color: #fff3e0;
      text-decoration: none;
      padding: 6px 12px;
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: bold;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }

    nav ul li a:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    nav ul li img {
      width: 18px;
      height: 18px;
    }

    main {
      max-width: 900px;
      margin: 3em auto;
      background-color: rgba(245, 227, 193, 0.96);
      padding: 2em;
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
      border: 2px solid #d2b48c;
    }

    h2 {
      text-align: center;
      margin-bottom: 1.5em;
      color: var(--teks);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #fffaf3;
    }

    th, td {
      padding: 12px;
      border: 1px solid #c1a97a;
      text-align: left;
    }

    th {
      background-color: #e5d0a2;
      color: #3e2723;
    }

    tr:nth-child(even) {
      background-color: #fef8e7;
    }

    footer {
      background-color: rgba(222, 184, 135, 0.3);
      text-align: center;
      padding: 1em;
      margin-top: 4em;
      font-size: 0.9em;
      color: #4b3621;
      backdrop-filter: blur(2px);
    }
  </style>
</head>
<body>
  <header>
    <h1>Perpustakaan Klasik</h1>
    <nav>
      <ul>
        <li><a href="index.html"><img src="img/icon-home.png" alt="">Beranda</a></li>
        <li><a href="peminjaman.html"><img src="img/icon-loan.png" alt="">Peminjaman</a></li>
        <li><a href="daftar-buku.php"><img src="img/icon-book.png" alt="">Daftar Buku</a></li>
        <li><a href="#"><img src="img/icon-history.png" alt="">Riwayat</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2>Daftar Buku yang Tersedia</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Tahun Terbit</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $result = mysqli_query($koneksi, "SELECT * FROM buku");
        while ($buku = mysqli_fetch_assoc($result)) {
          echo "<tr>";
          echo "<td>{$buku['kode_buku']}</td>";
          echo "<td>{$buku['judul']}</td>";
          echo "<td>{$buku['pengarang']}</td>";
          echo "<td>{$buku['tahun_terbit']}</td>";
          echo "<td>{$buku['status']}</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </main>

  <footer>
    &copy; 2025 Perpustakaan Digital
  </footer>
</body>
</html>
