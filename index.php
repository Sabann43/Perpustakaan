<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>🏫 Perpustakaan Ceria</title>
    <style>
        body {
            margin: 0;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            background-color: #e0f2fe; /* biru muda cerah */
            text-align: center;
            color: #333;
        }

        h1 {
            margin-top: 40px;
            font-size: 40px;
        }

        .menu-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 60px;
            gap: 30px;
        }

        .menu-card {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
            padding: 30px 20px;
            width: 230px;
            text-decoration: none;
            color: #444;
            transition: transform 0.3s ease;
        }

        .menu-card:hover {
            transform: scale(1.05);
            background-color: #dbeafe; /* biru lembut saat hover */
        }

        .menu-card span {
            font-size: 48px;
            display: block;
            margin-bottom: 15px;
        }

        footer {
            margin-top: 60px;
            padding: 20px;
            color: #555;
        }

        @media (max-width: 600px) {
            .menu-card {
                width: 80%;
            }
        }
    </style>
</head>
<body>

    <h1>📚 Sistem Perpustakaan Sederhana</h1>
    <p style="font-size: 18px; margin-top: -10px;">Selamat datang! Pilih menu di bawah ini ⬇️</p>

    <div class="menu-container">
        <a href="anggota.php" class="menu-card">
            <span>😪</span>
            <strong>Manajemen Anggota</strong>
        </a>

        <a href="buku.php" class="menu-card">
            <span>📘</span>
            <strong>Manajemen Buku</strong>
        </a>

        <a href="peminjaman.php" class="menu-card">
            <span>🙄</span>
            <strong>Transaksi Peminjaman</strong>
        </a>
    </div>

    <footer>
        💡 Dibuat dengan semangat dan penuh senyuman 😄<br>
        &copy; <?= date('Y') ?> - Sistem Perpustakaan Sederhana
    </footer>

</body>
</html>
