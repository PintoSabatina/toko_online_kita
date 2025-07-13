<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online Kita</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            object-fit: cover;
            height: 200px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Toko Online Kita</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="semua_produk.php">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kontak</a></li>
                </ul>
                <div class="d-flex gap-2">
                    <a href="keranjang.php" class="btn btn-outline-light">🛒 Keranjang</a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="pesanan_saya.php" class="btn btn-outline-light">🧾 Pesanan Saya</a>
                        <a href="logout.php" class="btn btn-light text-dark">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-light text-dark">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Produk -->
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Produk Terbaru</h2>
            <a href="semua_produk.php" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
        </div>

        <div class="row">
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id DESC LIMIT 6");
            while ($produk = mysqli_fetch_assoc($query)):
            ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($produk['gambar']) ?>" class="card-img-top" alt="Gambar Produk">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produk['nama_produk']) ?></h5>
                            <p class="card-text text-truncate"><?= htmlspecialchars($produk['deskripsi']) ?></p>
                            <p class="text-primary fw-bold">Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
                            <a href="detail_produk.php?id=<?= $produk['id'] ?>" class="btn btn-outline-primary w-100">Beli Sekarang</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; <?= date('Y') ?> Toko Online Kita. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>