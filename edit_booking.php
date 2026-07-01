<?php
session_start();
if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pesanan - KPR Estetik</title>
    <style>
        /* Menggunakan font modern dan warna latar belakang hangat khas coffee shop */
        body { 
            font-family: 'Plus Jakarta Sans', 'Segoe UI', Arial, sans-serif; 
            background: #f6f3ed; 
            padding: 60px 20px; 
            color: #2b2b2a;
            margin: 0;
        }

        /* Box form dibuat lebih lebar (max-width: 550px) dan memiliki efek floating yang halus */
        .form-box { 
            background: #ffffff; 
            padding: 40px; 
            border-radius: 16px; 
            max-width: 550px; 
            margin: 0 auto; 
            box-shadow: 0 10px 30px rgba(43, 43, 42, 0.05); 
            border-left: 10px solid #2b2b2a;
            box-sizing: border-box;
        }

        /* Desain Judul Utama */
        h3 { 
            margin-top: 0; 
            color: #2b2b2a; 
            font-size: 26px; 
            font-weight: 800;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f6f3ed; 
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        /* Layout Grup Input */
        .group { margin-bottom: 22px; }
        .group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: 600; 
            font-size: 14px; 
            color: #4a4a48;
        }

        /* Desain Elemen Input, Select, dan Textarea Modern */
        .group input, .group select, .group textarea { 
            width: 100%; 
            padding: 12px 16px; 
            box-sizing: border-box; 
            border: 1.5px solid #e4e2dd; 
            border-radius: 8px; 
            background-color: #faf9f6;
            font-size: 15px;
            color: #2b2b2a;
            transition: all 0.3s ease;
        }

        /* Efek Interaktif Fokus */
        .group input:focus, .group select:focus, .group textarea:focus {
            border-color: #2b2b2a;
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(43, 43, 42, 0.05);
            outline: none;
        }

        /* Box Desain Khusus untuk Bagian Tambahan (Aksen Hijau Pastel Estetik) */
        .tambahan-box {
            background-color: #f1f7f2;
            padding: 20px;
            border-radius: 10px;
            border: 1.5px solid #d2e7d6;
            margin-bottom: 25px;
        }
        .tambahan-box label {
            font-weight: 700; 
            font-size: 13px; 
            display: block; 
            margin-bottom: 8px;
            color: #406346;
            letter-spacing: 0.5px;
        }
        .tambahan-box select {
            width: 100%; 
            padding: 12px; 
            border: 1.5px solid #c3dec8; 
            border-radius: 8px;
            background-color: #ffffff;
            font-size: 14px;
        }

        /* Tombol Simpan yang Tegas & Bold */
        button { 
            background: #2b2b2a; 
            color: #f6f3ed; 
            padding: 16px; 
            border: none; 
            width: 100%; 
            cursor: pointer; 
            font-weight: 700; 
            border-radius: 8px; 
            font-size: 16px; 
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: background 0.2s ease;
        }
        button:hover { 
            background: #444442; 
        }

        /* Link Kembali */
        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #8c8a85; 
            text-decoration: none; 
            font-size: 14px; 
            transition: color 0.2s ease;
        }
        .back-link:hover {
            color: #2b2b2a;
        }
    </style>
</head>
<body>

<div class="form-box">
    <h3>KOPI PADU RASA</h3>
    <form action="simpan_booking.php" method="POST" id="kopiForm">
        
        <div class="group">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" placeholder="Masukkan nama pembeli..." required autocomplete="off">
        </div>
        
        <div class="group">
            <label>Pilih Varian Menu</label>
            <select name="menu_kopi" id="menu_kopi">
                <optgroup label="--- # KOPI SUSU ---">
                    <option value="Kopi Padu Rasa KPR" data-harga="13000">Kopi Padu Rasa KPR - Rp 13.000</option>
                    <option value="Kopi Padu Krimi KPK" data-harga="13000">Kopi Padu Krimi KPK - Rp 13.000</option>
                    <option value="Padu Karamel" data-harga="15000">Padu Karamel - Rp 15.000</option>
                    <option value="Padu Pandan" data-harga="15000">Padu Pandan - Rp 15.000</option>
                    <option value="Padu Kelapa" data-harga="15000">Padu Kelapa - Rp 15.000</option>
                </optgroup>
                <optgroup label="--- # BUKAN KOPI ---">
                    <option value="Padu Matcha" data-harga="15000">Padu Matcha - Rp 15.000</option>
                    <option value="Padu Coklat" data-harga="13000">Padu Coklat - Rp 13.000</option>
                    <option value="Teh Padu Aren TPA" data-harga="13000">Teh Padu Aren TPA - Rp 13.000</option>
                </optgroup>
                <optgroup label="--- # SI HITAM ---">
                    <option value="Padu Kano" data-harga="13000">Padu Kano - Rp 13.000</option>
                    <option value="Beri Kano" data-harga="15000">Beri Kano - Rp 15.000</option>
                </optgroup>
                <optgroup label="--- # VERSI 1 LITER ---">
                    <option value="KPR 1L" data-harga="60000">KPR 1L - Rp 60.000</option>
                    <option value="KPK 1L" data-harga="60000">KPK 1L - Rp 60.000</option>
                    <option value="Padu Matcha 1L" data-harga="70000">Padu Matcha 1L - Rp 70.000</option>
                    <option value="Padu Coklat 1L" data-harga="60000">Padu Coklat 1L - Rp 60.000</option>
                </optgroup>
            </select>
        </div>
        
        <div class="group">
            <label>Ukuran Cup / Jenis</label>
            <select name="ukuran_cup" id="ukuran_cup">
                <option value="Regular">Regular Cup (Normal)</option>
                <option value="Hot Version">Hot Version (Versi Panas)</option>
                <option value="1 Liter Bottle">1 Liter Bottle (Khusus Menu 1L)</option>
            </select>
        </div>

        <div class="tambahan-box">
            <label>TAMBAHAN (+++)</label>
            <select name="tambahan" id="tambahan">
                <option value="Tanpa Tambahan" data-add="0">Tidak Ada Tambahan</option>
                <option value="Ekstra Shot" data-add="2000">Ekstra Shot (+Rp 2.000)</option>
                <option value="Oat Milk" data-add="3000">Oat Milk (+Rp 3.000)</option>
                <option value="Salted Cream" data-add="3000">Salted Cream (+Rp 3.000)</option>
            </select>
        </div>
        
        <div class="group">
            <label>Jumlah Pesanan</label>
            <input type="number" name="jumlah" id="jumlah" value="1" min="1" required>
        </div>
        
        <div class="group">
            <label>Catatan Tambahan</label>
            <textarea name="catatan" rows="3" placeholder="Contoh: Less sugar, extra ice..."></textarea>
        </div>
        
        <input type="hidden" name="harga_satuan" id="harga_satuan">
        <button type="submit">SIMPAN PESANAN</button>
    </form>
    <a href="table.php" class="back-link">&larr; Kembali ke Tabel Pesanan</a>
</div>

<script>
document.getElementById('kopiForm').addEventListener('submit', function(e) {
    let menu = document.getElementById('menu_kopi');
    let tambahan = document.getElementById('tambahan');
    let jumlah = document.getElementById('jumlah').value;

    if(jumlah <= 0) {
        alert("Jumlah pesanan minimal 1 cup!");
        e.preventDefault();
        return;
    }

    let hargaDasar = parseInt(menu.options[menu.selectedIndex].getAttribute('data-harga'));
    let hargaTambahan = parseInt(tambahan.options[tambahan.selectedIndex].getAttribute('data-add'));
    
    // Total harga satuan dihitung dari kombinasi Menu Dasar + Tambahan Topping
    document.getElementById('harga_satuan').value = hargaDasar + hargaTambahan;
});
</script>

</body>
</html>