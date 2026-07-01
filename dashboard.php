<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

$user_id = $_SESSION['user_id'];
$hari_ini = date('Y-m-d');

// 1. Hitung Pendapatan Hari Ini
$query_omzet_hari_ini = mysqli_query($conn, "SELECT SUM(total_harga) as omzet FROM pesanan_kopi WHERE user_id = $user_id AND DATE(waktu_pesan) = '$hari_ini'");
$data_omzet_hari_ini = mysqli_fetch_assoc($query_omzet_hari_ini);
$omzet_hari_ini = $data_omzet_hari_ini['omzet'] ?? 0;

// 2. Hitung Total Pendapatan Keseluruhan
$query_total_omzet = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM pesanan_kopi WHERE user_id = $user_id");
$data_total_omzet = mysqli_fetch_assoc($query_total_omzet);
$total_omzet = $data_total_omzet['total'] ?? 0;

// 3. Hitung Total Cup Terjual Keseluruhan
$query_total_cup = mysqli_query($conn, "SELECT SUM(jumlah) as qty FROM pesanan_kopi WHERE user_id = $user_id");
$data_total_cup = mysqli_fetch_assoc($query_total_cup);
$total_cup = $data_total_cup['qty'] ?? 0;

// 4. Ambil Menu Terlaris
$query_terlaris = mysqli_query($conn, "SELECT menu_kopi, SUM(jumlah) as total_terjual FROM pesanan_kopi WHERE user_id = $user_id GROUP BY menu_kopi ORDER BY total_terjual DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kopi Padu Rasa</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f6f3ed; margin: 0; padding: 0; color: #2b2b2a; display: flex; }
        
        /* Sidebar Navigasi */
        .sidebar { width: 250px; background: #2b2b2a; height: 100vh; position: fixed; color: white; padding-top: 20px; }
        .sidebar h2 { text-align: center; font-size: 20px; letter-spacing: 1px; margin-bottom: 30px; color: #f6f3ed; }
        .sidebar a { display: block; color: #cbd5e1; padding: 15px 25px; text-decoration: none; font-weight: 600; font-size: 15px; border-left: 4px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background: #3e3e3c; color: #f6f3ed; border-left-color: #406346; }
        .sidebar .logout { margin-top: 50px; color: #f87171; }
        
        /* Konten Utama */
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); box-sizing: border-box; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 28px; font-weight: 800; }
        
        /* Grid Kartu Laporan Ringkas */
        .grid-stats { display: flex; gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 25px; border-radius: 14px; flex: 1; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border-top: 5px solid #406346; }
        .card p { margin: 0; color: #8c8a85; font-size: 13px; font-weight: bold; text-transform: uppercase; }
        .card h3 { margin: 10px 0 0 0; font-size: 26px; font-weight: 800; }

        /* Row Layout untuk Detail */
        .row-dashboard { display: flex; gap: 20px; }
        .panel { background: white; padding: 25px; border-radius: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); flex: 1; }
        .panel h4 { margin-top: 0; margin-bottom: 15px; font-size: 18px; border-bottom: 2px solid #f6f3ed; padding-bottom: 10px; }
        
        .list-item { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed #e4e2dd; font-size: 15px; }
        .list-item:last-child { border-bottom: none; }
        .badge { background: #e1f5fe; color: #0288d1; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .btn-order { display: inline-block; background: #2b2b2a; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; transition: 0.2s; }
        .btn-order:hover { background: #444442; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2> KOPI PADU RASA</h2>
    <a href="dashboard.php" class="active">Dashboard</a>
    <a href="form.php">Input Pesanan</a>
    <a href="table.php">Daftar Transaksi</a>
    <a href="laporan.php">Laporan Penjualan</a>
    <a href="logout.php" class="logout" onclick="return confirm('Apakah Anda yakin ingin Logout')">Keluar (Logout)</a>
</div>

<div class="main-content">
    <div class="header">
        <div>
            <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p style="margin: 5px 0 0 0; color: #8c8a85;">Sistem Penjualan Outlet KPR</p>
        </div>
        <a href="form.php" class="btn-order">+ INPUT ORDER BARU</a>
    </div>

    <div class="grid-stats">
        <div class="card" style="border-top-color: #eab308;">
            <p>Pendapatan Hari Ini</p>
            <h3>Rp <?php echo number_format($omzet_hari_ini, 0, ',', '.'); ?></h3>
        </div>
        <div class="card">
            <p>Total Omzet Keseluruhan</p>
            <h3>Rp <?php echo number_format($total_omzet, 0, ',', '.'); ?></h3>
        </div>
        <div class="card" style="border-top-color: #2b2b2a;">
            <p>Total Produk Terjual</p>
            <h3><?php echo number_format($total_cup, 0, ',', '.'); ?> Cup</h3>
        </div>
    </div>

    <div class="row-dashboard">
        <div class="panel">
            <h4> Varian Menu </h4>
            <?php if(mysqli_num_rows($query_terlaris) > 0): ?>
                <?php $rank = 1; while($row = mysqli_fetch_assoc($query_terlaris)): ?>
                    <div class="list-item">
                        <span><strong><?php echo $rank++; ?>.</strong> <?php echo $row['menu_kopi']; ?></span>
                        <span class="badge"><?php echo $row['total_terjual']; ?> Cup Terjual</span>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p style="color: #8c8a85; font-size: 14px;">Belum ada data transaksi.</p>
            <?php endif; ?>
        </div>

        <div class="panel">
            <h4> Informasi Operasional</h4>
            <div class="list-item">
                <span>Tanggal Hari Ini</span>
                <span><strong><?php echo date('d M Y'); ?></strong></span>
            </div>
            <div class="list-item">
                <span>Status Koneksi Database</span>
                <span style="color: green; font-weight: bold;">● Terhubung Aktif</span>
            </div>
        </div>
    </div>
</div>

</body>
</html>