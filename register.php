<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Kopi KPR</title>
    <style>
        
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            background-color: #26190e; 
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(213, 189, 175, 0.05) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(64, 99, 70, 0.1) 0%, transparent 50%),
                linear-gradient(45deg, rgba(213, 189, 175, 0.02) 25%, transparent 25%, transparent 75%, rgba(213, 189, 175, 0.02) 75%);
            background-size: cover, cover, 60px 60px;
            background-attachment: fixed;
            display: flex; 
            flex-direction: column;
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            padding: 40px 20px;
            box-sizing: border-box;
        }

       
        .brand-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .coffee-icon {
            width: 46px;
            height: 42px;
            border: 3px solid #d5bdaf;
            border-radius: 4px 4px 20px 20px;
            position: relative;
            display: inline-block;
            margin-bottom: 10px;
        }
        .coffee-icon::after {
            content: "";
            position: absolute;
            top: 5px; right: -10px;
            width: 6px; height: 16px;
            border: 3px solid #d5bdaf;
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .brand-title {
            color: #f6f3ed;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 3px;
            margin: 0;
            text-transform: uppercase;
        }

       
        .card { 
            background: #3e2a1a; 
            padding: 60px 60px 50px 60px; 
            border-radius: 28px; 
            box-shadow: 0 25px 55px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(213, 189, 175, 0.15); 
            width: 520px;        
            min-height: 780px;   /* KUNCI: Ukuran disamakan persis dengan halaman login */
            box-sizing: border-box;
            border: 2px solid #d5bdaf; 
            
            /* Pembagian posisi vertikal menggunakan Flexbox */
            display: flex;
            flex-direction: column;
        }


        h2 { 
            margin-top: 0; 
            color: #f6f3ed; 
            text-align: center; 
            font-size: 36px; 
            font-weight: 800; 
            letter-spacing: 2px;
            margin-bottom: 0;
        }


        form {
            margin-top: auto;    /* Mengunci form tepat di tengah vertikal card */
            margin-bottom: auto; /* Menggantung seimbang di tengah */
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .group { 
            margin-bottom: 35px; 
        }

        .group label { 
            display: block; 
            margin-bottom: 14px; 
            color: #d5bdaf; 
            font-weight: 600; 
            font-size: 15px; 
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .group input { 
            width: 100%; 
            padding: 20px 22px; 
            box-sizing: border-box; 
            border: 1.5px solid rgba(213, 189, 175, 0.3); 
            border-radius: 14px; 
            background-color: #2b1d12; 
            font-size: 17px; 
            color: #f6f3ed;
            transition: all 0.3s ease;
        }

        .group input:focus { 
            border-color: #f6f3ed; 
            background-color: #1f140c;
            outline: none; 
            box-shadow: 0 0 14px rgba(246, 243, 237, 0.15);
        }

        button { 
            width: 100%; 
            padding: 20px; 
            background: #406346; /* Hijau estetik senada */
            color: #f6f3ed; 
            border: none; 
            cursor: pointer; 
            font-weight: 700; 
            border-radius: 14px; 
            font-size: 18px; 
            letter-spacing: 2px; 
            text-transform: uppercase;
            transition: all 0.2s ease;
            margin-top: 20px;
            box-shadow: 0 8px 25px rgba(64, 99, 70, 0.25);
        }

        button:hover { 
            background: #2e4a34; 
            transform: translateY(-2px); 
        }

        button:active {
            transform: translateY(0);
        }

        p { 
            text-align: center; 
            font-size: 15px; 
            margin-top: 0; 
            margin-bottom: 10px; 
            color: rgba(213, 189, 175, 0.6); 
        }

        p a { 
            color: #f6f3ed; 
            font-weight: bold; 
            text-decoration: none !important; /* Menghilangkan underline */
            border-bottom: none !important;   
            padding-bottom: 3px;
            transition: color 0.2s ease;
        }

        p a:hover { 
            color: #eab308; 
        }
    </style>
</head>
<body>

<div class="brand-container">
    <div class="coffee-icon"></div>
    <p class="brand-title">Kopi Padu Rasa</p>
</div>

<div class="card">
    <h2>Daftar Akun</h2>
    
    <form action="proses_register.php" method="POST">
        <div class="group">
            <label>Username</label>
            <input type="text" name="username" required autocomplete="off">
        </div>
        <div class="group">
            <label>Password</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Daftar</button>
    </form>
    
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>

</body>
</html>