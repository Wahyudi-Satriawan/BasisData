<?php
session_start();
if (isset($_SESSION['admin'])) header('Location: index.php');

include 'koneksi.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
  $pw = mysqli_real_escape_string($koneksi, $_POST['password']);
  $q  = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin='$id' AND password='$pw'");
  if ($a = mysqli_fetch_assoc($q)) {
    $_SESSION['admin'] = $a['id_admin'];
    header('Location: index.php');
    exit;
  }
  else $error = "Username atau password salah.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width"><title>Login</title><link rel="stylesheet" href="style.css"></head>
<body>
<header><h1>Perpustakaan Klasik</h1></header>
<main>
  <h2>Login Admin</h2>
  <?php if (isset($_GET['logout'])) echo '<div class="notif">Berhasil logout.</div>'; ?>
  <?php if ($error) echo '<div class="notif" style="background-color:#ffe0e0;color:#800;">'.$error.'</div>'; ?>
  <form method="POST">
    <label>ID Admin:</label>
    <input type="text" name="id_admin" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <input type="submit" value="Login">
  </form>
</main>
<footer>&copy; <?= date('Y') ?></footer>
</body>
</html>