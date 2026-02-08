<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Gunakan prepared statement dan tabel users
    $query = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['login'] = true;
        $_SESSION['nama']  = $data['username'];
        $_SESSION['role']  = $data['role'];
        $_SESSION['id_user'] = $data['id'];
        header("Location: test_buku.php");
        exit;
    } else {
        $error = "Username atau password salah";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="background: #ffffffff;">
<div class="login-container login-animate">
    <div style="text-align:center;margin-bottom:18px;">
        <img src="assets/img/logo.png" alt="Logo" class="login-logo-img" style="width: 120px;height:120px;object-fit:contain;">
    </div>
    <div class="login-title">Login Perpustakaan</div>
    <div class="login-tagline">Selamat datang di E-Perpus! Temukan dan pinjam buku favoritmu dengan mudah.</div>
    <?php if (isset($error)) echo "<div class='login-error'>$error</div>"; ?>
    <form method="post" class="login-form">
        <label>Username</label>
        <input type="text" name="username" required>
        <label>Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
    </form>
</div>
<script>
document.querySelector('.login-container').style.opacity = 0;
setTimeout(() => {
  document.querySelector('.login-container').style.transition = 'opacity 0.8s';
  document.querySelector('.login-container').style.opacity = 1;
}, 200);
</script>
</body>
</html>
