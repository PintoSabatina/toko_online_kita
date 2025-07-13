<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambah produk ke keranjang
if (isset($_GET['id']) && $_GET['aksi'] === 'tambah') {
    $id = intval($_GET['id']);

    // Ambil data produk dari database
    $produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
    if ($data = mysqli_fetch_assoc($produk)) {
        // Cek apakah produk sudah ada di keranjang
        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $id) {
                $item['jumlah'] += 1;
                $found = true;
                break;
            }
        }
        unset($item); // reference lepas

        // Jika belum ada, tambahkan
        if (!$found) {
            $_SESSION['cart'][] = [
                'id' => $data['id'],
                'nama' => $data['nama_produk'],
                'harga' => $data['harga'],
                'jumlah' => 1
            ];
        }
    }

    header("Location: keranjang.php");
    exit();
}

// Hapus item dari keranjang
if (isset($_GET['hapus'])) {
    $hapus_id = intval($_GET['hapus']);
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($hapus_id) {
        return $item['id'] != $hapus_id;
    });

    header("Location: keranjang.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Toko Online Kita</a>
            <div class="d-flex gap-2">
                <a href="index.php" class="btn btn-outline-light">⬅ Kembali</a>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="logout.php" class="btn btn-light text-dark">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-light text-dark">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>


    <div class="container my-5">
        <h3 class="mb-4">Keranjang Belanja</h3>

        <?php if (empty($_SESSION['cart'])): ?>
            <div class="alert alert-warning">Keranjang masih kosong.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $item):
                        $total = $item['harga'] * $item['jumlah'];
                        $grand_total += $total;
                    ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                            <td><?= $item['jumlah'] ?></td>
                            <td>Rp<?= number_format($total, 0, ',', '.') ?></td>
                            <td>
                                <a href="keranjang.php?hapus=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="table-secondary">
                        <td colspan="3" class="text-end fw-bold">Total</td>
                        <td colspan="2" class="fw-bold">Rp<?= number_format($grand_total, 0, ',', '.') ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-end">
                <a href="checkout.php" class="btn btn-success">Checkout</a>
            </div>
        <?php endif; ?>
    </div>

</body>

</html>