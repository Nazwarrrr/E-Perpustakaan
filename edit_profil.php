<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config/koneksi.php';

$nama = $_SESSION['nama'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'siswa';
$email = strtolower($nama) . '@mail.com';

if (isset($_POST['save'])) {
    $new_nama = $_POST['nama'];
    $new_email = $_POST['email'];
    // Simulasi update profil (dummy, tidak update database)
    $_SESSION['nama'] = $new_nama;
    $email = $new_email;
    $success = 'Profil berhasil diperbarui!';
}
if (isset($_POST['change_pw'])) {
    $old_pw = $_POST['old_pw'];
    $new_pw = $_POST['new_pw'];
    $confirm_pw = $_POST['confirm_pw'];
    // Simulasi ganti password (dummy, tidak update database)
    if ($new_pw === $confirm_pw && strlen($new_pw) >= 4) {
        $success = 'Password berhasil diganti!';
    } else {
        $error = 'Password baru dan konfirmasi tidak cocok atau terlalu pendek.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="profile-container">
    <div class="profile-avatar"><span>👤</span></div>
    <div class="profile-name">Edit Profil <span class="profile-role">(<?= ucfirst($role); ?>)</span></div>
    <?php if (isset($success)) echo '<div class="login-error">'.$success.'</div>'; ?>
    <?php if (isset($error)) echo '<div class="login-error">'.$error.'</div>'; ?>
    <form method="post" style="margin-bottom:24px;">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= $nama; ?>" required>
        <label>Email</label>
        <input type="email" name="email" value="<?= $email; ?>" required>
        <button type="submit" name="save">Simpan Perubahan</button>
    </form>
    <form method="post">
        <label>Password Lama</label>
        <input type="password" name="old_pw" required>
        <label>Password Baru</label>
        <input type="password" name="new_pw" required>
        <label>Konfirmasi Password Baru</label>
        <input type="password" name="confirm_pw" required>
        <button type="submit" name="change_pw">Ganti Password</button>
    </form>
    <a href="profil.php" class="profile-back">Kembali ke Profil</a>
</div>
</body>
</html>
