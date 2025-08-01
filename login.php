<?php
session_start();
include "koneksi.php";

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verifikasi password yang di-hash
        if (password_verify($password, $user['password'])) {
            // Login berhasil, set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['username'] = $user['username'];
            
            header("Location: index.php");
            exit();
        } else {
            $error = "Username atau password salah.";
        }
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
    <title>Login Aplikasi Usaha</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 400px; text-align: center; }
        .login-container h2 { color: #4468a3; margin-bottom: 20px; }
        .login-container form { display: flex; flex-direction: column; }
        .login-container label { text-align: left; margin-bottom: 5px; color: #555; font-weight: bold; }
        .login-container input[type="text"], .login-container input[type="password"] { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .login-container button { background-color: #4468a3; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s; }
        .login-container button:hover { background-color: #314d79; }
        .login-container p { margin-top: 15px; }
        .login-container a { color: #4468a3; text-decoration: none; }
        .login-container a:hover { text-decoration: underline; }
        .error-message { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Aplikasi Usaha</h2>
        <?php if (!empty($error)) { echo '<p class="error-message">' . $error . '</p>'; } ?>
        <form action="login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>