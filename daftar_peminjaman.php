<?php
include 'koneksi.php';

$result = mysqli_query($koneksi, "SELECT * FROM peminjaman");

echo "<h2>Daftar Peminjaman Aktif</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>NIM</th><th>Kode Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Aksi</th></tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['nim']}</td>
        <td>{$row['kode_buku']}</td>
        <td>{$row['tanggal_pinjam']}</td>
        <td>{$row['tanggal_kembali']}</td>
        <td><a href='proses_pengembalian.php?id={$row['id_peminjaman']}'>Kembalikan</a></td>
    </tr>";
}
echo "</table>";
?>
