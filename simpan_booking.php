<?php
session_start();
if (!isset($_SESSION['login'])) { exit; }
include 'koneksi.php';

$user_id        = $_SESSION['user_id'];
$nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
$menu_kopi      = $_POST['menu_kopi'];
$ukuran_cup     = $_POST['ukuran_cup'];
$harga_satuan   = $_POST['harga_satuan'];
$jumlah         = $_POST['jumlah'];
$total_harga    = $harga_satuan * $jumlah;
$catatan        = mysqli_real_escape_string($conn, $_POST['catatan']);

$query = "INSERT INTO pesanan_kopi (user_id, nama_pelanggan, menu_kopi, ukuran_cup, harga_satuan, jumlah, total_harga, catatan) 
          VALUES ($user_id, '$nama_pelanggan', '$menu_kopi', '$ukuran_cup', $harga_satuan, $jumlah, $total_harga, '$catatan')";

if (mysqli_query($conn, $query)) {
    header("Location: table.php");
} else {
    echo "Gagal menyimpan pesanan: " . mysqli_error($conn);
}
?>