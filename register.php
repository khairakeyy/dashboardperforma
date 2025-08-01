<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);
    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']); // GANTI dari 'nama' jadi 'nama_lengkap'

    $sql = "INSERT INTO users (username, password, role, nama_lengkap)
            VALUES ('$username', '$password', '$role', '$nama_lengkap')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: login.php");
    } else {
        echo "Gagal register: " . mysqli_error($koneksi);
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .register-container { background-color: #fff; padding: 40px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); width: 400px; text-align: center; }
        .register-container h2 { color: #4468a3; margin-bottom: 20px; }
        .register-container form { display: flex; flex-direction: column; }
        .register-container label { text-align: left; margin-bottom: 5px; color: #555; font-weight: bold; }
        .register-container input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .register-container button { background-color: #4468a3; color: #fff; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s; }
        .register-container button:hover { background-color: #314d79; }
        .register-container p { margin-top: 15px; }
        .register-container a { color: #4468a3; text-decoration: none; }
        .register-container a:hover { text-decoration: underline; }
        .success-message { color: green; margin-bottom: 15px; }
        .error-message { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registrasi Akun Baru</h2>
        <?php if (!empty($error)) { echo '<p class="error-message">' . $error . '</p>'; } ?>
        <?php if (!empty($success)) { echo '<p class="success-message">' . $success . '</p>'; } ?>
        <form action="register.php" method="POST">
            <label for="nama">Nama Lengkap:</label>
            <input type="text" id="nama" name="nama" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>