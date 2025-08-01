<?php
include 'koneksi.php';
session_start();

// Cek login
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

// Ambil ID dari URL
if (!isset($_GET['id'])) {
  echo "ID tidak ditemukan!";
  exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM usaha_diaspora WHERE id = $id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
  echo "Data tidak ditemukan!";
  exit();
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Data Usaha</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .form-container {
      padding: 2rem;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      margin-top: 2rem;
    }
    input, textarea {
      padding: 10px;
      margin-bottom: 15px;
      width: 100%;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    button {
      padding: 10px 20px;
      background-color: #4e8ef7;
      border: none;
      color: white;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="sidebar">
    <ul>
      <li><a href="index.php">🏠 Dashboard</a></li>
      <li><a href="input.php">📝 Input Data</a></li>
      <li><a href="data_usaha.php">📋 Data Usaha</a></li>
      <li><a href="laporan.php">📊 Laporan</a></li>
      <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
  </div>
  <div class="main">
    <div class="form-container">
      <h2>Edit Data Usaha</h2>
      <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= $data['id']; ?>">

        <label>Nama Owner:</label>
        <input type="text" name="nama_owner" value="<?= $data['nama_owner']; ?>" required>

        <label>Alamat Owner:</label>
        <input type="text" name="alamat_owner" value="<?= $data['alamat_owner']; ?>" required>

        <label>Asal Owner:</label>
        <input type="text" name="asal_owner" value="<?= $data['asal_owner']; ?>" required>

        <label>No HP:</label>
        <input type="text" name="hp" value="<?= $data['hp']; ?>" required>

        <label>Nama Usaha:</label>
        <input type="text" name="nama_usaha" value="<?= $data['nama_usaha']; ?>" required>

        <label>Alamat Usaha:</label>
        <textarea name="alamat_usaha" required><?= $data['alamat_usaha']; ?></textarea>

        <label>Sektor Usaha:</label>
        <input type="text" name="sektor" value="<?= $data['sektor']; ?>" required>

        <button type="submit">Simpan Perubahan</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
