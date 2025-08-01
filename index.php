<?php
session_start();
include "koneksi.php";

// Cek jika belum login, redirect ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil data user dari session
$nama_user = $_SESSION['nama'];

// Ambil data statistik dari database
$total_usaha = 0;
$kuliner_count = 0;
$fashion_count = 0;
$lainnya_count = 0;

$query_total = "SELECT COUNT(*) AS total FROM usaha_diaspora";
$result_total = mysqli_query($koneksi, $query_total);
if ($result_total) {
    $data_total = mysqli_fetch_assoc($result_total);
    $total_usaha = $data_total['total'];
}

$query_kuliner = "SELECT COUNT(*) AS total FROM usaha_diaspora WHERE sektor_usaha = 'Kuliner'";
$result_kuliner = mysqli_query($koneksi, $query_kuliner);
if ($result_kuliner) {
    $data_kuliner = mysqli_fetch_assoc($result_kuliner);
    $kuliner_count = $data_kuliner['total'];
}

$query_fashion = "SELECT COUNT(*) AS total FROM usaha_diaspora WHERE sektor_usaha = 'Fashion'";
$result_fashion = mysqli_query($koneksi, $query_fashion);
if ($result_fashion) {
    $data_fashion = mysqli_fetch_assoc($result_fashion);
    $fashion_count = $data_fashion['total'];
}

// Menghitung Sektor Lainnya (Total - Kuliner - Fashion)
$lainnya_count = $total_usaha - ($kuliner_count + $fashion_count);

// Ambil 5 data terbaru untuk section "Data Terbaru"
$query_terbaru = "SELECT * FROM usaha_diaspora ORDER BY id DESC LIMIT 5";
$result_terbaru = mysqli_query($koneksi, $query_terbaru);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Database Usaha</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* CSS dari file dashboard sebelumnya, tempel di sini */
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f0f2f5; display: flex; flex-direction: column; height: 100vh; }
        .header { background-color: #fff; padding: 10px 20px; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center; }
        .header-left { display: flex; flex-direction:column;}
        .header-title { font-size: 30px; font-weight: bold; color: #4468a3; }
        .header-subtitle { font-size: 14px; color: #666; }
        .header-logo { height: 60px; }
        .main-container { display: flex; flex: 1; }
        .sidebar-left { width: 250px; background-color: #fff; padding: 20px 0; box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); }
        .sidebar-left ul { list-style: none; padding: 0; margin: 0; }
        .sidebar-left li { margin-bottom: 5px; }
        .sidebar-left a { display: flex; align-items: center; padding: 15px 20px; text-decoration: none; color: #333; transition: background-color 0.3s; }
        .sidebar-left a:hover, .sidebar-left .active { background-color: #e6f0ff; color: #4468a3; }
        .sidebar-left a .icon { margin-right: 15px; }
        .content { flex: 1; padding: 20px; display: flex; flex-direction: column; gap: 20px; }
        .dashboard-header { font-size: 20px; font-weight: bold; color: #333; margin: 0; }
        .dashboard-cards { display: flex; gap: 20px; }
        .card-stats { flex: 1; display: flex; justify-content: space-between; align-items: flex-end; color: #fff; padding: 20px; border-radius: 12px; height: 120px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); position: relative; overflow: hidden; font-family: Arial, sans-serif; }
        .card-stats h3 { font-size: 16px; margin: 0 0 10px 0; font-weight: 400; }
        .card-stats .value { font-size: 36px; font-weight: 600; margin: 0; }
        .card-stats .icon-card { font-size: 48px; color: rgba(255, 255, 255, 0.3); position: absolute; bottom: 10px; right: 15px; }
        .card-blue-total { background-color: #4468a3; }
        .card-green-kuliner { background-color: #28a745; }
        .card-purple-fashion { background-color: #6f42c1; }
        .card-orange-lainnya { background-color: #fd7e14; }
        .card-dark-lainnya { background-color: #343a40; }
        .card-teal-edukasi { background-color: #20c997; }
        .card-gray-transport { background-color: #6c757d; }
        .card-orange-kerajinan { background-color: #fd7e14; }
        .data-terbaru { margin-top: 0; }
        .data-terbaru-box { background-color: #a2bbe2; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        .sidebar-right { width: 250px; background-color: #fff; padding: 20px; box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1); display: flex; flex-direction: column; align-items: center; }
        .profile-pic-container { width: 150px; height: 150px; border-radius: 50%; overflow: hidden; margin-bottom: 10px; border: 2px solid #ddd; }
        .profile-pic { width: 100%; height: 100%; object-fit: cover; }
        .profile-info { text-align: center; }
        .profile-name { font-size: 18px; font-weight: bold; color: #333; margin-bottom: 5px; }
        .profile-role, .profile-address { font-size: 14px; color: #666; margin-bottom: 5px; }
        .logout-button { background-color: #4468a3; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 16px; margin-top: auto; }
        .logout-button:hover { background-color: #314d79; }
        .data-terbaru-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .data-terbaru-table th, .data-terbaru-table td { text-align: left; padding: 8px; border-bottom: 1px solid #eaeaeaff; }
        .data-terbaru-table th { background-color: #a2bbe2; color: #333; }
        .data-terbaru-table tr:hover { background-color: #f5f5f5; }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <h1 class="header-title">APLIKASI DATABASE USAHA</h1>
            <div class="header-subtitle">
                <p>Bandung - Jawa Barat</p>
                <p>Bank Nagari Cabang Bandung</p>
                <p>Jalan Buah Batu No. 240, Cijagra, Kec. Lengkong, Kota Bandung</p>
            </div>
        </div>
        <div class="header-right">
            <img src="assets/logohitam.png" alt="Bank Nagari Logo" class="header-logo">
            <img src="assets/ollinwarna.png" alt="Ollin Logo" class="header-logo">
        </div>
    </div>

    <div class="main-container">
        <div class="sidebar-left">
            <ul>
                <li><a href="index.php" class="active"><i class="fas fa-home icon"></i> Dashboard</a></li>
                <li><a href="input.php"><i class="fas fa-plus icon"></i> Input Data</a></li>
                <li><a href="data_usaha.php"><i class="fas fa-database icon"></i> Data Usaha</a></li>
                <li><a href="laporan.php"><i class="fas fa-chart-bar icon"></i> Laporan</a></li>
                <li><a href="pengaturan"><i class="fas fa-cog icon"></i> Pengaturan</a></li>
            </ul>
        </div>

        <div class="content">
            <h2 class="dashboard-header">Dashboard</h2>
            
            <div class="dashboard-cards">
                <div class="card-stats card-blue-total">
                    <div>
                        <h3>Total Usaha</h3>
                        <p class="value"><?php echo $total_usaha; ?></p>
                    </div>
                    <i class="fas fa-location-arrow icon-card"></i>
                </div>
                <div class="card-stats card-gray-transport">
                    <div>
                        <h3>Sektor Kuliner</h3>
                        <p class="value"><?php echo $kuliner_count; ?></p>
                    </div>
                    <i class="fas fa-utensils icon-card"></i>
                </div>
                <div class="card-stats card-dark-lainnya">
                    <div>
                        <h3>Sektor Fashion</h3>
                        <p class="value"><?php echo $fashion_count; ?></p>
                    </div>
                    <i class="fas fa-tshirt icon-card"></i>
                </div>
                <div class="card-stats card-orange-kerajinan">
                    <div>
                        <h3>Sektor Lainnya</h3>
                        <p class="value"><?php echo $lainnya_count; ?></p>
                    </div>
                    <i class="fas fa-lock icon-card"></i>
                </div>
            </div>

            <div class="data-terbaru">
                <h2 class="dashboard-header">Data Terbaru</h2>
                <div class="data-terbaru-box">
                    <table class="data-terbaru-table">
                        <thead>
                            <tr>
                                <th>Nama Usaha</th>
                                <th>Nama Owner</th>
                                <th>Sektor</th>
                                <th>Tanggal Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result_terbaru) > 0) : ?>
                                <?php while ($row = mysqli_fetch_assoc($result_terbaru)) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['nama_usaha']); ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_owner']); ?></td>
                                        <td><?php echo htmlspecialchars($row['sektor_usaha']); ?></td>
                                        <td><?php echo htmlspecialchars($row['tanggal_input']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="4">Belum ada data usaha terbaru.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="sidebar-right">
            <div class="profile-pic-container">
                <img src="assets/profile.jpg" alt="Profile Picture" class="profile-pic">
            </div>
            <div class="profile-info">
                <p class="profile-name"><?php echo htmlspecialchars($nama_user); ?></p>
                <p class="profile-role">Admin</p>
                <p class="profile-address">Jl. PGA No. 101</p>
            </div>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
</body>
</html>