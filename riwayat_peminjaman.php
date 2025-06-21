<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include 'koneksi.php';
include 'template/header.php';

$notif = '';

// Proses update status jika dikirim POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_riwayat'], $_POST['status'])) {
    $id_riwayat = mysqli_real_escape_string($koneksi, $_POST['id_riwayat']);
    $new_status = mysqli_real_escape_string($koneksi, $_POST['status']);

    // Ambil status sebelumnya dan kode_buku
    $result = mysqli_query($koneksi, "SELECT status, kode_buku FROM riwayat_peminjaman WHERE id_riwayat = '$id_riwayat'");
    $data = mysqli_fetch_assoc($result);
    $old_status = $data['status'];
    $kode_buku = $data['kode_buku'];

    // Update status
    $update = mysqli_query($koneksi, "
        UPDATE riwayat_peminjaman
        SET status = '$new_status'
        WHERE id_riwayat = '$id_riwayat'
    ");

    // Jika berhasil dan status berubah ke 'Dikembalikan', tambah stok
    if ($update) {
        if ($old_status === 'Dipinjam' && $new_status === 'Dikembalikan') {
            mysqli_query($koneksi, "
                UPDATE buku
                SET jumlah_stok = jumlah_stok + 1
                WHERE kode_buku = '$kode_buku'
            ");
        }
        $notif = "Status berhasil diperbarui.";
    } else {
        $notif = "Gagal mengubah status: " . mysqli_error($koneksi);
    }
}

// Ambil semua data riwayat peminjaman
$riwayat = mysqli_query($koneksi, "
    SELECT r.*, 
           m.nama AS nama_mahasiswa,
           b.judul AS judul_buku
    FROM riwayat_peminjaman r
    LEFT JOIN mahasiswa m ON r.nim = m.nim
    LEFT JOIN buku b ON r.kode_buku = b.kode_buku
    ORDER BY r.tanggal_pinjam DESC
");
?>

<main>
    <h2>📜 Riwayat Peminjaman</h2>

    <?php if ($notif): ?>
        <div class="notif"><?= htmlspecialchars($notif) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ID Admin</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Kode Buku</th>
                <th>Judul Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($riwayat)) : ?>
                <tr>
                    <form method="POST">
                        <td><?= htmlspecialchars($row['id_riwayat']) ?></td>
                        <td><?= htmlspecialchars($row['id_admin']) ?></td>
                        <td><?= htmlspecialchars($row['nim']) ?></td>
                        <td><?= htmlspecialchars($row['nama_mahasiswa'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['kode_buku']) ?></td>
                        <td><?= htmlspecialchars($row['judul_buku'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_kembali']) ?></td>
                        <td style="text-align:center;">
                            <select name="status" required>
                                <option value="Dipinjam" <?= $row['status'] == 'Dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                                <option value="Dikembalikan" <?= $row['status'] == 'Dikembalikan' ? 'selected' : '' ?>>Dikembalikan</option>
                                <option value="Terlambat" <?= $row['status'] == 'Terlambat' ? 'selected' : '' ?>>Terlambat</option>
                            </select>
                            <input type="hidden" name="id_riwayat" value="<?= htmlspecialchars($row['id_riwayat']) ?>">
                            <button type="submit" class="btn" style="margin-top: 5px;">Simpan</button>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include 'template/footer.php'; ?>
