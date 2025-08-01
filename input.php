<?php
session_start();
include "koneksi.php";

// Cek jika belum login, redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Usaha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* General body and font styling */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f0f2f5; display: flex; flex-direction: column; height: 100vh; }
        .container { display: flex; flex: 1; }
        /* Sidebar (Left Navbar) styling */
        .sidebar { width: 250px; background-color: #fff; padding: 20px 0; box-shadow: 2px 0 5px rgba(0,0,0,0.1); display: flex; flex-direction: column; }
        .logo-section { padding: 0 20px 20px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
        .logo-section h3 { font-size: 18px; font-weight: 600; color: #4468a3; margin-bottom: 5px; }
        .logo-section p { font-size: 12px; color: #666; margin: 2px 0; }
        .nav { list-style: none; padding: 0; margin: 0; }
        .nav li { margin-bottom: 5px; }
        .nav a { display: flex; align-items: center; padding: 15px 20px; text-decoration: none; color: #333; transition: background-color 0.3s; font-size: 14px; }
        .nav a:hover, .nav a.active { background-color: #e6f0ff; color: #4468a3; font-weight: 600; }
        .nav a i { margin-right: 15px; width: 20px; }
        /* Main content and header */
        .main { flex: 1; display: flex; flex-direction: column; }
        .header { background-color: #fff; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: flex-end; align-items: center; }
        .profile { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 10px; width: 200px; background-color: #f8f9fa; border-radius: 8px; }
        .profile-img { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; border: 2px solid #ddd; }
        .profile .name { font-size: 16px; font-weight: 600; color: #333; margin: 0; }
        .profile .role, .profile .address { font-size: 12px; color: #666; margin: 0; }
        .btn-logout { background-color: #4468a3; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 12px; text-decoration: none; margin-top: 10px; }
        .btn-logout:hover { background-color: #314d79; }
        /* Dashboard content */
        .dashboard { flex: 1; padding: 20px; overflow-y: auto; }
        .dashboard h2 { font-size: 24px; font-weight: 600; color: #333; margin-bottom: 20px; }
        /* Form styling */
        .form-box { background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-box label { display: block; font-size: 14px; font-weight: 600; color: #555; margin-bottom: 5px; }
        .form-box input[type="text"], .form-box textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        .form-box textarea { resize: vertical; min-height: 80px; }
        .btn-submit { background-color: #4468a3; color: #fff; border: none; padding: 12px 25px; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: 600; margin-top: 20px; float: right; }
        .btn-submit:hover { background-color: #314d79; }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo-section">
                <h3>APLIKASI DATABASE USAHA</h3>
                <p>Bandung - Jawa Barat</p>
                <p>Bank Nagari Cabang Bandung</p>
                <p>Jl. Buah Batu No. 240, Cijagra</p>
            </div>
            <ul class="nav">
                <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="input.php" class="active"><i class="fas fa-plus"></i> Input Data</a></li>
                <li><a href="data_usaha.php"><i class="fas fa-database"></i> Data Usaha</a></li>
                <li><a href="laporan.php"><i class="fas fa-chart-bar"></i> Laporan</a></li>
                <li><a href="pengaturan.php"><i class="fas fa-cog"></i> Pengaturan</a></li>
            </ul>
        </aside>

        <main class="main">
            <header class="header">
                <div class="profile">
                    <p class="name"><?php echo htmlspecialchars($_SESSION['nama']); ?></p>
                    <p class="role">Admin</p>
                    <a href="logout.php" class="btn-logout">Logout</a>
                </div>
            </header>

            <section class="dashboard">
                <h2>Form Input Usaha Diaspora</h2>
                <form action="proses_input.php" method="post" class="form-box">
                    <div class="form-grid">
                        <div><label>ID Pegawai:</label><input type="text" name="id_pegawai" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>" readonly></div>
                        <div><label>Tanggal Input:</label><input type="text" name="tanggal_input" value="<?php echo date('Y-m-d'); ?>" readonly></div>
                        <div><label>Nama Owner:</label><input type="text" name="nama_owner" required></div>
                        <div><label>Alamat Owner:</label><input type="text" name="alamat_owner" required></div>
                        <div><label>Asal Owner:</label><input type="text" name="asal_owner" required></div>
                        <div><label>No HP:</label><input type="text" name="handphone" required></div>
                        <div><label>Foto Owner (URL):</label><input type="text" name="foto_owner"></div>
                        <div><label>Nama Usaha:</label><input type="text" name="nama_usaha" required></div>
                        <div><label>Alamat Usaha:</label><textarea name="alamat_usaha" required></textarea></div>
                        <div><label>Sektor Usaha:</label><input type="text" name="sektor_usaha" required></div>
                    </div>
                    <button type="submit" class="btn-submit">Simpan</button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>