<?php
// Mencegah munculnya Notice session_start() jika session sudah aktif otomatis di server
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Proteksi halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pesanan - Kopi KPR</title>
    <style>
        /* Gaya dasar agar tampilan bersih dan minimalis sesuai gambar kamu */
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f1ea;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            box-sizing: border-box;
        }

        .form-container {
            background: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 500px;
            border-left: 5px solid #3e2a1a;
            box-sizing: border-box;
        }

        h2 {
            color: #3e2a1a;
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            margin-top: 0;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f9f9f9;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
        }

        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none;
            border-color: #3e2a1a;
            background-color: #fff;
        }

        .tambahan-box {
            background-color: #f1f6f2;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #dbebd7;
            margin-bottom: 20px;
        }

        .tambahan-box label {
            color: #406346;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #2b2b2b;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #111111;
        }

        /* Styling tombol kembali di bawah halaman */
        .back-link {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
        }

        .back-link a {
            color: #888;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #3e2a1a;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>KOPI PADU RASA</h2>
    
    <form action="simpan_booking.php" method="POST">
        <div class="form-group">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" placeholder="Masukkan nama pembeli..." required autocomplete="off">
        </div>

        <div class="form-group">
            <label>Pilih Varian Menu</label>
            <select name="menu_kopi" id="menu_kopi" required onchange="updateHarga()">
                <option value="" disabled selected>-- Pilih Menu --</option>
                <optgroup label="KOPI SUSU">
                    <option value="Kopi Padu Rasa KPR" data-harga="13000">Kopi Padu Rasa KPR - Rp 13.000</option>
                    <option value="Kopi Padu Krimi KPK" data-harga="13000">Kopi Padu Krimi KPK - Rp 13.000</option>
                    <option value="Padu Karamel" data-harga="15000">Padu Karamel - Rp 15.000</option>
                    <option value="Padu Pandan" data-harga="15000">Padu Pandan - Rp 15.000</option>
                    <option value="Padu Kelapa" data-harga="15000">Padu Kelapa - Rp 15.000</option>
                </optgroup>
                
                <optgroup label="BUKAN KOPI">
                    <option value="Padu Matcha" data-harga="15000">Padu Matcha - Rp 15.000</option>
                    <option value="Padu Coklat" data-harga="13000">Padu Coklat - Rp 13.000</option>
                    <option value="Teh Padu Aren TPA" data-harga="13000">Teh Padu Aren TPA - Rp 13.000</option>
                </optgroup>
                
                <optgroup label="SI HITAM">
                    <option value="Padu Kano" data-harga="13000">Padu Kano - Rp 13.000</option>
                    <option value="Beri Kano" data-harga="15000">Beri Kano - Rp 15.000</option>
                </optgroup>
                
                <optgroup label="VERSI PANAS">
                    <option value="Hot Kopi Padu Rasa" data-harga="13000">Hot Kopi Padu Rasa - Rp 13.000</option>
                    <option value="Hot Kopi Padu Krimi" data-harga="13000">Hot Kopi Padu Krimi - Rp 13.000</option>
                    <option value="Hot Padu Kano" data-harga="13000">Hot Padu Kano - Rp 13.000</option>
                    <option value="Hot Padu Matcha" data-harga="15000">Hot Padu Matcha - Rp 15.000</option>
                    <option value="Hot Padu Coklat" data-harga="13000">Hot Padu Coklat - Rp 13.000</option>
                    <option value="Hot Teh Padu Aren" data-harga="13000">Hot Teh Padu Aren - Rp 13.000</option>
                </optgroup>
                
                <optgroup label="VERSI 1 LITER">
                    <option value="KPR 1L" data-harga="60000">KPR 1L - Rp 60.000</option>
                    <option value="KPK 1L" data-harga="60000">KPK 1L - Rp 60.000</option>
                    <option value="Padu Matcha 1L" data-harga="70000">Padu Matcha 1L - Rp 70.000</option>
                    <option value="Padu Coklat 1L" data-harga="60000">Padu Coklat 1L - Rp 60.000</option>
                </optgroup>
            </select>
        </div>

        <input type="hidden" name="harga_satuan" id="harga_satuan" value="0">

        <div class="form-group">
            <label>Ukuran Cup / Jenis</label>
            <select name="ukuran_cup" required>
                <option value="Regular Cup (Normal Ice)">Regular Cup (Normal Ice)</option>
                <option value="Large Cup">Large Cup</option>
            </select>
        </div>

        <div class="tambahan-box">
            <div class="form-group" style="margin-bottom: 0;">
                <label>TAMBAHAN (+++)</label>
                <select name="tambahan">
                    <option value="Tidak Ada Tambahan">Tidak Ada Tambahan</option>
                    <option value="Ekstra Shot (+Rp 2.000)">Ekstra Shot (+Rp 2.000)</option>
                    <option value="Oat Milk (+Rp 3.000)">Oat Milk (+Rp 3.000)</option>
                    <option value="Salted Cream (+Rp 3.000)">Salted Cream (+Rp 3.000)</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label>Metode Pembayaran</label>
            <select name="metode_pembayaran" required>
                <option value="Tunai (Cash)">Tunai (Cash)</option>
                <option value="QRIS / Digital">QRIS / Digital</option>
            </select>
        </div>

        <div class="form-group">
            <label>Jumlah Pesanan</label>
            <input type="number" name="jumlah" value="1" min="1" required>
        </div>

        <div class="form-group">
            <label>Catatan Tambahan (Kustomisasi Rasa)</label>
            <textarea name="catatan" rows="3" placeholder="Contoh: Less sugar, extra ice..."></textarea>
        </div>

        <button type="submit">SIMPAN PESANAN</button>
    </form>

    <div class="back-link">
        <a href="dashboard.php">← Kembali ke halaman utama</a>
    </div>
</div>

<script>
// Fungsi otomatis untuk mendeteksi nominal harga dari menu yang dipilih
function updateHarga() {
    var selectMenu = document.getElementById("menu_kopi");
    var selectedOption = selectMenu.options[selectMenu.selectedIndex];
    var harga = selectedOption.getAttribute("data-harga");
    
    // Set nilai ke input hidden harga_satuan
    document.getElementById("harga_satuan").value = harga ? harga : 0;
}
</script>

</body>
</html>