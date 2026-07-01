<?php
include 'koneksi.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Akun Berhasil Terdaftar! Silakan Login.'); window.location='login.php';</script>";
} else {
    echo "<script>alert('Username sudah terdaftar!'); window.location='register.php';</script>";
}
?>