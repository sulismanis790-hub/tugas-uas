<?php
session_start();
if (!isset($_SESSION['login'])) { exit; }
include 'koneksi.php';

$id_pesanan     = $_POST['id_pesanan'];
$user_id        = $_SESSION['user_id'];
$nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
$menu_kopi      = $_POST['menu_kopi'];
$ukuran_cup     = $_POST['ukuran_cup'];
$harga_satuan   = $_POST['harga_satuan'];
$jumlah         = $_POST['jumlah'];
$total_harga    = $harga_satuan * $jumlah;
$catatan        = mysqli_real_escape_string($conn, $_POST['catatan']);

$query = "UPDATE pesanan_kopi SET 
          nama_pelanggan='$nama_pelanggan', menu_kopi='$menu_kopi', ukuran_cup='$ukuran_cup', 
          harga_satuan=$harga_satuan, jumlah=$jumlah, total_harga=$total_harga, catatan='$catatan' 
          WHERE id_pesanan=$id_pesanan AND user_id=$user_id";

if (mysqli_query($conn, $query)) {
    header("Location: table.php");
} else {
    echo "Gagal memperbarui pesanan: " . mysqli_error($conn);
}
?>