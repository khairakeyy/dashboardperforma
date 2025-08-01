<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $query = "DELETE FROM usaha_diaspora WHERE id = $id";

  if (mysqli_query($conn, $query)) {
    header("Location: data_usaha.php?status=deleted");
    exit();
  } else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "ID tidak ditemukan.";
}
