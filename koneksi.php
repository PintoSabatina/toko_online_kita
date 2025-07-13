<?php

$host = "localhost"; // Biasanya localhost untuk pengembangan lokal
$user = "root";      // Default user XAMPP/WAMP
$password = "";      // Default password XAMPP/WAMP (kosong)
$database = "e_commerce"; // Nama database yang sudah Anda buat

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Opsional: Atur encoding agar karakter khusus tampil dengan benar
mysqli_set_charset($koneksi, "utf8");
