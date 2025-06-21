<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "perpustakaan";

// Membuat koneksi
$koneksi = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($koneksi->connect_error) {
    // Menampilkan pesan kesalahan jika gagal konek ke database
    die("❌ Koneksi database gagal: " . $koneksi->connect_error);
}

// Jika ingin menampilkan pesan sukses saat pengembangan
// echo "✅ Koneksi berhasil";
?>
