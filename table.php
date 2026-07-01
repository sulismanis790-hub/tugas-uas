<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
include 'koneksi.php';

$user_id = $_SESSION['user_id'];

// 1. QUERY AMBIL DATA TRANSAKSI
$result = mysqli_query($conn, "SELECT * FROM pesanan_kopi WHERE user_id = $user_id ORDER BY id_pesanan DESC");

// 2. FITUR BARU: QUERY HITUNG STATISTIK TOTAL PENDAPATAN & CUP TERJUAL
$stats_omzet = mysqli_query($conn, "SELECT SUM(total_harga) as total_omzet FROM pesanan_kopi WHERE user_id = $user_id");
$data_omzet = mysqli_fetch_assoc($stats_omzet);
$total_omzet = $data_omzet['total_omzet'] ?? 0;

$stats_qty = mysqli_query($conn, "SELECT SUM(jumlah) as total_qty FROM pesanan_kopi WHERE user_id = $user_id");
$data_qty = mysqli_fetch_assoc($stats_qty);
$total_qty = $data_qty['total_qty'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - KPR</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; padding: 40px; background: #f6f3ed; color: #2b2b2a; }
        .header-dash { display: flex; justify-content: space-between; background: #2b2b2a; color: white; padding: 20px 30px; border-radius: 12px; align-items: center; }
        .header-dash h2 { margin: 0; font-size: 20px; }
        .header-dash a { color: white; text-decoration: none; background: #ef4444; padding: 8px 16px; border-radius: 6px; font-weight: bold; font-size: 14px; }
        
        /* FITUR BARU: Grid Card Statistik */
        .stats-grid { display: flex; gap: 20px; margin-top: 25px; }
        .card-stat { background: white; padding: 20px; border-radius: 12px; flex: 1; box-shadow: 0 4px 15px rgba(0,0,0,0.02); border-top: 4px solid #406346; }
        .card-stat p { margin: 0; color: #8c8a85; font-size: 14px; font-weight: 600; }
        .card-stat h3 { margin: 5px 0 0 0; font-size: 24px; color: #2b2b2a; font-weight: 800; }

        .btn-add { display: inline-block; background: #406346; color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: bold; margin: 25px 0; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        th, td { padding: 14px; text-align: left; border-bottom: 1px solid #e4e2dd; }
        th { background: #e4e2dd; color: #2b2b2a; font-weight: bold; }
        .action { text-decoration: none; padding: 6px 12px; color: white; border-radius: 6px; font-size: 13px; font-weight: bold; margin-right: 5px; cursor: pointer; }
        .edit { background: #eab308; }
        .delete { background: #ef4444; }
        .print { background: #3b82f6; border: none; }

        /* ========================================================
           FITUR BARU: CSS KHUSUS PRINT STRUK STRIP (CETAK THERMAL)
           ======================================================== */
        @media print {
            body * { visibility: hidden; background: white; }
            .struk-print-area, .struk-print-area * { visibility: visible; }
            .struk-print-area { 
                position: absolute; left: 0; top: 0; width: 58mm; 
                font-family: 'Courier New', Courier, monospace; font-size: 12px; color: black; line-height: 1.2;
            }
            .struk-header { text-align: center; margin-bottom: 10px; }
            .struk-divider { border-bottom: 1px dashed black; margin: 5px 0; }
            .struk-row { display: flex; justify-content: space-between; }
        }
    </style>
</head>
<body>

<div class="header-dash">
    <h2>DASHBOARD KASIR: <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
    <a href="logout.php" class="logout" onclick="return confirm('Apakah Anda yakin ingin Logout')">Keluar (Logout)</a>
</div>

<div class="stats-grid">
    <div class="card-stat">
        <p>TOTAL PENDAPATAN (OMZET)</p>
        <h3>Rp <?php echo number_format($total_omzet, 0, ',', '.'); ?></h3>
    </div>
    <div class="card-stat" style="border-top-color: #2b2b2a;">
        <p>TOTAL PRODUK TERJUAL</p>
        <h3><?php echo number_format($total_qty, 0, ',', '.'); ?> Cup</h3>
    </div>
</div>

<a href="form.php" class="btn-add">+ INPUT PESANAN BARU</a>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Menu Kopi</th>
            <th>Ukuran/Jenis</th>
            <th>Harga Satuan</th>
            <th>Qty</th>
            <th>Total Bayar</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
            <td><?php echo $row['menu_kopi']; ?></td>
            <td><?php echo $row['ukuran_cup']; ?></td>
            <td>Rp <?php echo number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
            <td><?php echo $row['jumlah']; ?>x</td>
            <td style="font-weight: bold;">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
            <td>
                <button class="action print" onclick="cetakStruk('<?php echo htmlspecialchars($row['nama_pelanggan']); ?>', '<?php echo $row['menu_kopi']; ?>', '<?php echo $row['ukuran_cup']; ?>', <?php echo $row['harga_satuan']; ?>, <?php echo $row['jumlah']; ?>, <?php echo $row['total_harga']; ?>)">Struk</button>
                <a href="edit_booking.php?id=<?php echo $row['id_pesanan']; ?>" class="action edit">Edit</a>
                <a href="hapus_booking.php?id=<?php echo $row['id_pesanan']; ?>" class="action delete" onclick="return confirm('Hapus pesanan?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="printContainer"></div>

<script>
function cetakStruk(pelanggan, menu, ukuran, harga, qty, total) {
    let container = document.getElementById('printContainer');
    let waktuSekarang = new Date().toLocaleString('id-ID');
    
    container.innerHTML = `
        <div class="struk-print-area">
            <div class="struk-header">
                <strong>KOPI PADU RASA</strong><br>
                Paduan Rasa yang Pas<br>
                
            </div>
            <div>
                Waktu : ${waktuSekarang}<br>
                Kasir : Pelanggan Atas Nama<br>
                Nama  : ${pelanggan}<br>
            </div>
            <div class="struk-divider"></div>
            <div>
                <strong>${menu}</strong><br>
                ${qty} x Rp ${harga.toLocaleString('id-ID')}
                <div class="struk-row">
                    <span>(${ukuran})</span>
                    <span>Rp ${total.toLocaleString('id-ID')}</span>
                </div>
            </div>
            <div class="struk-divider"></div>
            <div class="struk-row" style="font-weight:bold;">
                <span>TOTAL BELANJA</span>
                <span>Rp ${total.toLocaleString('id-ID')}</span>
            </div>
            <div class="struk-divider"></div>
            <div class="struk-header" style="margin-top:10px;">
                Terima Kasih!<br>
                Selamat Menikmati Seduhan KPR
            </div>
        </div>
    `;
    window.print(); // Membuka dialog cetak browser secara otomatis
}
</script>

</body>
</html>