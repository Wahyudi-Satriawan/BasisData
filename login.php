<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_admin = mysqli_real_escape_string($koneksi, $_POST['id_admin']);
  $password = mysqli_real_escape_string($koneksi, $_POST['password']);

  $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id_admin = '$id_admin' AND password = '$password'");
  $admin = mysqli_fetch_assoc($query);

  if ($admin) {
    $_SESSION['admin'] = $admin['id_admin'];
    header('Location: index.php');
    exit;
  } else {
    $error = "Username atau password salah.";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header style="text-align:center; background-color:#343a40; color:#fff; padding:20px;">
  <h1>Perpustakaan Klasik</h1>
</header>
<main>
  <h2>Login Admin</h2>
  <?php if (isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
  <form method="POST" action="">
    <label for="id_admin">Masukkan ID:</label>
    <input type="text" id="id_admin" name="id_admin" required>

    <label for="password">Password:</label>
    <input type="text" id="password" name="password" required>

    <input type="submit" value="Login">
  </form>
</main>
<?php include 'template/footer.php'; ?>