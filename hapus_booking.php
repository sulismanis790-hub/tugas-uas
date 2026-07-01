<?php
session_start();
if (!isset($_SESSION['login'])) { exit; }
include 'koneksi.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Mengamankan proses hapus agar pengguna hanya dapat menghapus datanya sendiri
$query = "DELETE FROM pesanan_kopi WHERE id_pesanan = $id AND user_id = $user_id";

if (mysqli_query($conn, $query)) {
    header("Location: table.php");
} else {
    echo "Gagal menghapus data pesanan: " . mysqli_error($conn);
}
?>