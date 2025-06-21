<?php
include 'koneksi.php';
session_start();

// Proses peminjaman
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pinjam'])) {
    $id_anggota = intval($_POST['id_anggota']);
    $id_buku = intval($_POST['id_buku']);
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    // Simpan data peminjaman dan kurangi stok buku
    $koneksi->query("INSERT INTO peminjaman (id_anggota, id_buku, tanggal_pinjam, tanggal_kembali, status) 
                 VALUES ($id_anggota, $id_buku, '$tanggal_pinjam', '$tanggal_kembali', 'Dipinjam')");

    header("Location: peminjaman.php");
    exit;
}

// Proses pengembalian buku
if (isset($_GET['kembalikan']) && isset($_GET['buku'])) {
    $id_peminjaman = intval($_GET['kembalikan']);
    $id_buku = intval($_GET['buku']);

    $koneksi->query("UPDATE peminjaman SET status = 'Dikembalikan' WHERE id_peminjaman = $id_peminjaman");
    $koneksi->query("UPDATE buku SET stok = stok + 1 WHERE id_buku = $id_buku");

    header("Location: peminjaman.php");
    exit;
}

// Proses hapus peminjaman
if (isset($_GET['hapus']) && isset($_GET['buku'])) {
    $id_peminjaman = intval($_GET['hapus']);
    $id_buku = intval($_GET['buku']);

    $koneksi->query("DELETE FROM peminjaman WHERE id_peminjaman = $id_peminjaman");

    header("Location: peminjaman.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman Buku</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            padding: 40px;
        }
        h2 {
            color: #333;
            border-left: 6px solid #0f172a;
            padding-left: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 18px;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background: #2563eb;
            color: white;
            text-align: left;
        }
        tr:hover {
            background-color: #fefce8;
        }
        form {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 600px;
            margin-bottom: 40px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
        }
        button {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #1d4ed8;
        }
        .aksi a {
            color: #dc2626;
            text-decoration: none;
            font-weight: bold;
        }
        .aksi a:hover {
            text-decoration: underline;
        }
        .kembali {
            text-align: center;
            margin-top: 30px;
        }
        .kembali a {
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Form Peminjaman</h2>
<form method="post">
    <label>Anggota</label>
    <select name="id_anggota" required>
        <?php
        $a = $koneksi->query("SELECT * FROM anggota");
        while ($row = $a->fetch_assoc()) {
            echo "<option value='{$row['id_anggota']}'>{$row['nama']}</option>";
        }
        ?>
    </select>

    <label>Buku</label>
    <select name="id_buku" required>
        <?php
        $b = $koneksi->query("SELECT * FROM buku WHERE stok > 0");
        while ($row = $b->fetch_assoc()) {
            echo "<option value='{$row['id_buku']}'>{$row['judul']}</option>";
        }
        ?>
    </select>

    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" required>

    <label>Tanggal Kembali</label>
    <input type="date" name="tanggal_kembali" required>

    <button type="submit" name="pinjam">Pinjam</button>
</form>

<h2>Data Peminjaman</h2>
<table>
    <tr>
        <th>Anggota</th>
        <th>Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Tanggal Kembali</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = $koneksi->query("SELECT p.*, a.nama, b.judul 
                             FROM peminjaman p
                             JOIN anggota a ON p.id_anggota = a.id_anggota
                             JOIN buku b ON p.id_buku = b.id_buku
                             ORDER BY p.id_peminjaman DESC");

    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nama']}</td>
                    <td>{$row['judul']}</td>
                    <td>{$row['tanggal_pinjam']}</td>
                    <td>{$row['tanggal_kembali']}</td>
                    <td>";

            if ($row['status'] === 'Dipinjam') {
                echo "<a href='peminjaman.php?kembalikan={$row['id_peminjaman']}&buku={$row['id_buku']}'
                         onclick=\"return confirm('Yakin ingin mengembalikan buku ini?');\">Kembalikan</a>";
            } else {
                echo "<span style='color: green;'>Dikembalikan</span>";
            }

            echo "</td>
                    <td class='aksi'>
                        <a href='peminjaman.php?hapus={$row['id_peminjaman']}&buku={$row['id_buku']}'
                           onclick=\"return confirm('Yakin ingin menghapus peminjaman ini?');\">Hapus</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align:center;'>Belum ada peminjaman.</td></tr>";
    }
    ?>
</table>

<div class="kembali">
    <a href="index.php">Kembali ke Menu Utama</a>
</div>

</body>
</html>
