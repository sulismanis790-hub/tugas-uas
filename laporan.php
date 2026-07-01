<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

// Mengatur filter tanggal default (awal bulan ini sampai hari ini)
$tgl_mulai = $_GET['tgl_mulai'] ?? date('Y-m-01');
$tgl_selesai = $_GET['tgl_selesai'] ?? date('Y-m-d');

// Ambil data transaksi berdasarkan filter tanggal
$query = "SELECT * FROM pesanan_kopi WHERE user_id = $user_id AND DATE(waktu_pesan) BETWEEN '$tgl_mulai' AND '$tgl_selesai' ORDER BY id_pesanan ASC";
$result = mysqli_query($conn, $query);

// Hitung total omzet dalam rentang tanggal tersebut
$query_total = mysqli_query($conn, "SELECT SUM(total_harga) as total_periode, SUM(jumlah) as qty_periode FROM pesanan_kopi WHERE user_id = $user_id AND DATE(waktu_pesan) BETWEEN '$tgl_mulai' AND '$tgl_selesai'");
$data_total = mysqli_fetch_assoc($query_total);
$total_periode = $data_total['total_periode'] ?? 0;
$qty_periode = $data_total['qty_periode'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - KPR</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f6f3ed; margin: 0; padding: 0; color: #2b2b2a; display: flex; }
        .sidebar { width: 250px; background: #2b2b2a; height: 100vh; position: fixed; color: white; padding-top: 20px; }
        .sidebar h2 { text-align: center; font-size: 20px; letter-spacing: 1px; margin-bottom: 30px; color: #f6f3ed; }
        .sidebar a { display: block; color: #cbd5e1; padding: 15px 25px; text-decoration: none; font-weight: 600; font-size: 15px; border-left: 4px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background: #3e3e3c; color: #f6f3ed; border-left-color: #406346; }
        .sidebar .logout { margin-top: 50px; color: #f87171; }
        
        .main-content { margin-left: 250px; padding: 40px; width: calc(100% - 250px); box-sizing: border-box; }
        h1 { margin: 0 0 5px 0; font-size: 28px; font-weight: 800; }
        
        /* Box Form Filter */
        .filter-box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 25px; }
        .filter-form { display: flex; gap: 15px; align-items: flex-end; }
        .filter-form .group { display: flex; flex-direction: column; }
        .filter-form label { font-size: 13px; font-weight: bold; margin-bottom: 6px; color: #4a4a48; }
        .filter-form input { padding: 10px; border: 1.5px solid #e4e2dd; border-radius: 6px; background-color: #faf9f6; font-size: 14px; }
        .btn-submit { background: #406346; color: white; padding: 11px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; }
        .btn-print { background: #2b2b2a; color: white; padding: 11px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; font-size: 14px; text-decoration: none; text-align: center; }
        
        /* Desain Tabel Laporan */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-top: 15px; }
        th, td { padding: 14px; text-align: left; border-bottom: 1px solid #e4e2dd; }
        th { background: #e4e2dd; color: #2b2b2a; font-weight: bold; }
        .total-row { background: #f1f7f2; font-weight: bold; font-size: 16px; }

        /* Aturan Cetak (Print Halaman) */
        @media print {
            .sidebar, .filter-box, .btn-submit, .btn-print { display: none !important; }
            .main-content { margin-left: 0 !important; width: 100% !important; padding: 0 !important; }
            body { background: white; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2> KOPI PADU RASA</h2>
    <a href="dashboard.php">Dashboard</a>
    <a href="form.php">Input Pesanan</a>
    <a href="table.php">Daftar Transaksi</a>
    <a href="laporan.php" class="active">Laporan Penjualan</a>
    <a href="logout.php" class="logout" onclick="return confirm('Apakah Anda yakin ingin Logout')">Keluar (Logout)</a>
</div>

<div class="main-content">
    <h1>Laporan Keuangan & Penjualan</h1>
    <p style="margin: 0 0 25px 0; color: #8c8a85;">Rekap Omzet Omzet Penjualan KPR</p>

    <div class="filter-box">
        <form method="GET" class="filter-form">
            <div class="group">
                <label>Tanggal Mulai</label>
                <input type="date" name="tgl_mulai" value="<?php echo $tgl_mulai; ?>">
            </div>
            <div class="group">
                <label>Tanggal Selesai</label>
                <input type="date" name="tgl_selesai" value="<?php echo $tgl_selesai; ?>">
            </div>
            <button type="submit" class="btn-submit">Filter Laporan</button>
            <a href="#" onclick="window.print()" class="btn-print">Cetak Laporan (PDF)</a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Varian Menu Kopi</th>
                <th>Ukuran Cup</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Subtotal Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; if(mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo date('d-m-Y H:i', strtotime($row['waktu_pesan'])); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                    <td><?php echo $row['menu_kopi']; ?></td>
                    <td><?php echo $row['ukuran_cup']; ?></td>
                    <td>Rp <?php echo number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['jumlah']; ?>x</td>
                    <td style="font-weight: 500;">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">TOTAL KESELURUHAN PERIODE:</td>
                    <td><?php echo $qty_periode; ?> Cup</td>
                    <td style="color: #406346;">Rp <?php echo number_format($total_periode, 0, ',', '.'); ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center; color: #8c8a85; padding: 30px;">Tidak ada transaksi pada periode tanggal ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>