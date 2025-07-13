<?php
session_start();

// Koneksi ke database
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


// Cek koneksi
if (mysqli_connect_errno()) {
    die("Gagal koneksi ke database: " . mysqli_connect_error());
}

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Cek user di database
$query = "SELECT * FROM users WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($user = mysqli_fetch_assoc($result)) {
    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;

        // Redirect berdasarkan username
        if ($user['username'] === 'admin') {
            header("Location: admin_panel.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        echo "<script>alert('Password salah!'); window.location='login.php';</script>";
    }
} else {
    echo "<script>alert('Username tidak ditemukan!'); window.location='login.php';</script>";
}
