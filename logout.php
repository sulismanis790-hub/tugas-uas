<?php
session_start();

// Hapus semua data session
$_SESSION = [];
session_unset();
session_destroy();

// Memunculkan alert via JavaScript lalu mengarahkan ke index.php
echo "<script>
        alert('Anda telah berhasil keluar dari sistem kasir KPR.');
        window.location.href = 'index.php';
      </script>";
exit;
?>