<!DOCTYPE html>
<html>
<head>
    <title>Form Peminjaman</title>
</head>
<body>
    <h2>Form Peminjaman Buku</h2>
    <form method="post" action="proses_peminjaman.php">
        <label>NIM:</label><br>
        <input type="text" name="nim" maxlength="12" required><br><br>

        <label>ID Admin:</label><br>
        <input type="number" name="id_admin" required><br><br>

        <label>Kode Buku:</label><br>
        <input type="text" name="kode_buku" maxlength="5" required><br><br>

        <label>Tanggal Pinjam:</label><br>
        <input type="date" name="tanggal_pinjam" required><br><br>

        <label>Tanggal Kembali:</label><br>
        <input type="date" name="tanggal_kembali" required><br><br>

        <input type="submit" value="Simpan">
    </form>
</body>
</html>
