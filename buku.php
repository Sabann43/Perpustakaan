<?php
include 'koneksi.php';

// Proses tambah buku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    if (!empty($_POST['judul']) && !empty($_POST['penulis']) && is_numeric($_POST['stok'])) {
        $judul = $_POST['judul'];
        $penulis = $_POST['penulis'];
        $stok = intval($_POST['stok']);

        $koneksi->query("INSERT INTO buku (judul, penulis, stok) VALUES ('$judul', '$penulis', $stok)");
        header("Location: buku.php");
        exit;
    }
}

// Proses hapus buku
if (isset($_GET['hapus'])) {
    $id_buku = intval($_GET['hapus']);
    $koneksi->query("DELETE FROM buku WHERE id_buku = $id_buku");
    header("Location: buku.php");
    exit;
}

$buku = $koneksi->query("SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
            padding: 40px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 500px;
            margin-bottom: 40px;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            box-sizing: border-box;
        }
        button {
            background: #2563eb;
            color: #fff;
            font-weight: bold;
            border: none;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #1d4ed8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #2563eb;
            color: white;
            text-align: left;
        }
        .aksi a {
            color: #dc2626;
            text-decoration: none;
            font-weight: bold;
        }
        .aksi a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <form method="post">
        <label>Judul Buku</label>
        <input type="text" name="judul" required>

        <label>Penulis</label>
        <input type="text" name="penulis" required>

        <label>Stok</label>
        <input type="number" name="stok" required min="0">

        <button type="submit" name="simpan">Simpan</button>
    </form>

    <h2>Data Buku</h2>
    <table>
        <tr>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $buku->fetch_assoc()) : ?>
        <tr>
            <td><?= htmlspecialchars($row['judul']) ?></td>
            <td><?= isset($row['penulis']) ? htmlspecialchars($row['penulis']) : '-' ?></td>
            <td><?= $row['stok'] ?></td>
            <td class="aksi"><a href="buku.php?hapus=<?= $row['id_buku'] ?>" onclick="return confirm('Yakin ingin menghapus buku ini?');">Hapus</a></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <div style="text-align:center; margin-top:20px;">
        <a href="index.php" style="background:#2563eb; color:white; padding:10px 20px; border-radius:6px; text-decoration:none; font-weight:bold;">Kembali ke Menu Utama</a>
    </div>

</body>
</html>
