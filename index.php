<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Kopi Padu Rasa - KPR</title>
    <style>
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background-color: #f5f2eb; 
            color: #2b2b2a; 
        }
        header { 
            background-color: #b0b0a1; 
            color: #f5f2eb; 
            padding: 40px 20px; 
            text-align: center; 
        }
        header h1 { margin: 0; font-size: 32px; letter-spacing: 2px; }
        header p { margin: 10px 0 0 0; color: #d2e7d6; font-style: italic; }
        
        nav { 
            background: #3e3e3c; 
            padding: 15px; 
            text-align: center; 
        }
        nav a { 
            color: #f5f2eb; 
            margin: 0 20px; 
            text-decoration: none; 
            font-weight: bold; 
            letter-spacing: 1px;
        }
        nav a:hover { color: #d2e7d6; }

        .hero { 
            text-align: center; 
            padding: 50px 20px; 
        }
        .hero h2 { font-size: 45px; color: #2b2b2a; }
        
        /* Grid Menu Ala Brosur */
        .menu-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            max-width: 900px;
            margin: 30px auto;
            flex-wrap: wrap;
        }
        .menu-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            width: 250px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-top: 5px solid #2b2b2a;
        }
        .menu-card.green { border-top-color: #90b796; background-color: #f0f7f1; }
        .menu-card h3 { margin-top: 0; border-bottom: 2px dashed #ccc; padding-bottom: 5px; }
        .menu-card ul { list-style: none; padding: 0; text-align: left; }
        .menu-card li { margin-bottom: 8px; display: flex; justify-content: space-between; font-size: 14px; }

        footer { 
            background: #2b2b2a; 
            color: #f5f2eb; 
            text-align: center; 
            padding: 15px; 
            margin-top: 200px;
            font-size: 14px; 
        }
    </style>
</head>
<body>

<header>
    <h1> KOPI PADU RASA</h1>
    <p>Paduan Rasa yang Pas di Setiap Seduhan</p>
</header>

<nav>
    <a href="index.php">BERANDA</a>
    <a href="login.php">MASUK APLIKASI</a>
    <a href="register.php">DAFTAR KASIR</a>
</nav>

<div class="hero">
    <h2>Daftar Menu Favorit KPR</h2>
    
    <div class="menu-grid">
        <div class="menu-card">
            <h3> KOPI SUSU</h3>
            <ul>
                <li><span>Kopi Padu Rasa KPR</span> <span>13K</span></li>
                <li><span>Kopi Padu Krimi KPK</span> <span>13K</span></li>
                <li><span>Padu Karamel</span> <span>15K</span></li>
                <li><span>Padu Pandan</span> <span>15K</span></li>
                <li><span>Padu Kelapa</span> <span>15K</span></li>
            </ul>
        </div>
        
        <div class="menu-card green">
            <h3> BUKAN KOPI</h3>
            <ul>
                <li><span>Padu Matcha</span> <span>15K</span></li>
                <li><span>Padu Coklat</span> <span>13K</span></li>
                <li><span>Teh Padu Aren TPA</span> <span>13K</span></li>
            </ul>
        </div>

        <div class="menu-card" style="background-color: #2b2b2a; color: white;">
            <h3> SI HITAM</h3>
            <ul>
                <li><span>Padu Kano</span> <span>13K</span></li>
                <li><span>Beri Kano</span> <span>15K</span></li>
            </ul>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2026 Kopi Padu Rasa (KPR) System. Semua Hak Cipta Dilindungi.</p>
</footer>

</body>
</html>