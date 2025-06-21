<?php
include 'koneksi.php';

// Proses tambah anggota
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_hp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';

    $stmt = $koneksi->prepare("INSERT INTO anggota (nama, alamat, no_hp) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $alamat, $no_hp);
    $stmt->execute();
    $stmt->close();

    header("Location: anggota.php");
    exit;
}

// Proses hapus anggota
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $koneksi->query("DELETE FROM anggota WHERE id_anggota = $id");
    header("Location: anggota.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Anggota</title>
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

        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #1d4ed8;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 18px;
            border-bottom: 1px solid #e5e7eb;
        }

        th {
            background: #2563eb;
            color: white;
            text-align: left;
        }

        tr:hover {
            background-color: #fefce8;
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

        .kembali a:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

    <h2>Tambah Anggota</h2>
    <form method="post">
        <label>Nama</label>
        <input type="text" name="nama" required>

        <label>Alamat</label>
        <input type="text" name="alamat" required>

        <label>No HP</label>
        <input type="text" name="no_hp" placeholder="08xxx..." required>

        <button type="submit" name="tambah">Simpan</button>
    </form>

    <h2>Data Anggota</h2>
    <table>
        <tr>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No HP</th>
            <th>Aksi</th>
        </tr>
        <?php
        $data = $koneksi->query("SELECT * FROM anggota ORDER BY id_anggota DESC");
        if ($data->num_rows > 0) {
            while ($row = $data->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['nama']}</td>
                        <td>{$row['alamat']}</td>
                        <td>" . htmlspecialchars($row['no_hp'] ?? '-') . "</td>
                        <td class='aksi'><a href='anggota.php?hapus={$row['id_anggota']}' onclick=\"return confirm('Hapus anggota ini?');\">Hapus</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4' style='text-align:center;'>Belum ada data anggota.</td></tr>";
        }
        ?>
    </table>

    <div class="kembali">
        <a href="index.php">Kembali ke Menu Utama</a>
    </div>

</body>
</html>
