<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


// Validasi ID produk
$id = $_GET['id'] ?? 0;
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan!'); window.location='index.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produk['nama_produk']) ?> - Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-detail {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Toko Online Kita</a>
            <div class="d-flex gap-2">
                <a href="keranjang.php" class="btn btn-outline-light">🛒 Keranjang</a>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="logout.php" class="btn btn-light text-dark">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-light text-dark">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Detail Produk -->
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= $produk['gambar'] ?>" class="img-fluid img-detail" alt="<?= htmlspecialchars($produk['nama_produk']) ?>">
            </div>
            <div class="col-md-6">
                <h3><?= htmlspecialchars($produk['nama_produk']) ?></h3>
                <p class="text-primary fw-bold fs-4">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
                <p><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>

                <div class="d-flex gap-2 mt-4">
                    <a href="keranjang.php?id=<?= $produk['id'] ?>&aksi=tambah" class="btn btn-warning">+ Tambah ke Keranjang</a>
                    <a href="checkout.php?id=<?= $produk['id'] ?>" class="btn btn-success">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Toko Online Kita. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>