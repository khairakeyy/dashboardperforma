<?php
session_start();
include "koneksi.php";

// Cek jika belum login, redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil semua data usaha dari database
$query = "SELECT * FROM usaha_diaspora ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Usaha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* CSS umum */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f0f2f5; display: flex; }
        .container { display: flex; width: 100%; }
        /* Sidebar */
        .sidebar { width: 250px; background-color: #fff; padding: 20px 0; box-shadow: 2px 0 5px rgba(0,0,0,0.1); }
        .logo-section { padding: 0 20px 20px; border-bottom: 1px solid #eee; margin-bottom: 20px; }
        .logo-section h3 { font-size: 18px; font-weight: 600; color: #4468a3; margin-bottom: 5px; }
        .logo-section p { font-size: 12px; color: #666; margin: 2px 0; }
        .nav { list-style: none; padding: 0; margin: 0; }
        .nav li { margin-bottom: 5px; }
        .nav a { display: flex; align-items: center; padding: 15px 20px; text-decoration: none; color: #333; transition: background-color 0.3s; font-size: 14px; }
        .nav a:hover, .nav a.active { background-color: #e6f0ff; color: #4468a3; font-weight: 600; }
        .nav a i { margin-right: 15px; width: 20px; }
        /* Main content */
        .main { flex: 1; display: flex; flex-direction: column; }
        .header { background-color: #fff; padding: 10px 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); display: flex; justify-content: flex-end; align-items: center; }
        .profile { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 10px; width: 200px; background-color: #f8f9fa; border-radius: 8px; }
        .profile .name { font-size: 16px; font-weight: 600; color: #333; margin: 0; }
        .profile .role, .profile .address { font-size: 12px; color: #666; margin: 0; }
        .btn-logout { background-color: #4468a3; color: #fff; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-size: 12px; text-decoration: none; margin-top: 10px; }
        .btn-logout:hover { background-color: #314d79; }
        .content { flex: 1; padding: 20px; }
        .content h2 { font-size: 24px; font-weight: 600; color: #333; margin-bottom: 20px; }
        /* Tabel */
        .data-table { width: 100%; border-collapse: collapse; background-color: #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-radius: 8px; overflow: hidden; }
        .data-table th, .data-table td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; }
        .data-table th { background-color: #f2f2f2; color: #4468a3; font-weight: 600; }
        .data-table tr:hover { background-color: #f5f5f5; }
        .data-table tbody tr:last-child td { border-bottom: none; }
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
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="input_usaha.php"><i class="fas fa-plus"></i> Input Data</a></li>
                <li><a href="data_usaha.php" class="active"><i class="fas fa-database"></i> Data Usaha</a></li>
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

            <div class="content">
                <h2>Data Usaha Diaspora</h2>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pegawai</th>
                            <th>Nama Owner</th>
                            <th>Nama Usaha</th>
                            <th>Sektor</th>
                            <th>Alamat Usaha</th>
                            <th>Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_owner']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_usaha']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['sektor_usaha']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['alamat_usaha']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['tanggal_input']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>Belum ada data usaha.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>