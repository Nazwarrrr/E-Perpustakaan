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
<body>
<!-- floating emoji books (visual-only, behind the form) -->
<div id="floating-books-root" aria-hidden="true"></div>
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
<script>
// Generate many floating book emojis for visual background (non-interactive)
(function(){
    const root = document.getElementById('floating-books-root');
    if(!root) return;
    const emojis = ['📚','📖','📘','📕','📗'];
    const count = 20; // number of floating emojis
    const vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
    for (let i=0;i<count;i++){
        const el = document.createElement('div');
        el.className = 'floating-book';
        // choose emoji
        el.textContent = emojis[Math.floor(Math.random()*emojis.length)];
        // random size
        const size = 18 + Math.floor(Math.random()*36); // 18..54px
        el.style.fontSize = size + 'px';
        // random horizontal start position
        const left = Math.random() * (vw - 40);
        el.style.left = left + 'px';
        // random animation duration & delay
        const dur = 10 + Math.random()*16; // 10..26s
        const delay = Math.random()*6; // 0..6s
        // set CSS variable for horizontal drift and inline animation to ensure it runs
        const drift = (Math.random()*160) - 80; // -80..80px for horizontal movement
        el.style.setProperty('--drift', drift + 'px');
        // ensure element is fixed and positioned at bottom start
        el.style.position = 'fixed';
        el.style.bottom = '-80px';
        // include animation name so it actually animates
        el.style.animation = `floatUp ${dur}s cubic-bezier(.2,.9,.2,1) ${-Math.random()*dur}s infinite`;
        // slight horizontal drift using transform translateX
        // ensure behind form
        el.style.zIndex = 0;
        root.appendChild(el);
    }
    // Reposition on resize
    window.addEventListener('resize', ()=>{
        const newVw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);
        root.querySelectorAll('.floating-book').forEach((el)=>{
            const left = Math.random() * (newVw - 40);
            el.style.left = left + 'px';
        });
    });
})();
</script>
</body>
</html>
