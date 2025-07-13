<?php
session_start();

// Proteksi: hanya admin
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Koneksi ke database
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


$id = $_GET['id'] ?? 0;

// Cek produk dulu untuk ambil path gambar
$produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
$data = mysqli_fetch_assoc($produk);

if (!$data) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='admin_panel.php';</script>";
    exit();
}

// Hapus file gambar dari folder jika ada (optional)
if (file_exists($data['gambar'])) {
    unlink($data['gambar']);
}

// Hapus produk dari database
$hapus = mysqli_query($koneksi, "DELETE FROM produk WHERE id = $id");

if ($hapus) {
    echo "<script>alert('Produk berhasil dihapus!'); window.location='admin_panel.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus produk.'); window.location='admin_panel.php';</script>";
}
