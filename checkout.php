<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


// Redirect jika belum login
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Silakan login untuk checkout!'); window.location='login.php';</script>";
    exit();
}

// Redirect jika keranjang kosong
if (empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang kosong!'); window.location='keranjang.php';</script>";
    exit();
}

// Proses simpan pesanan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['user']['username'];
    $alamat = htmlspecialchars($_POST['alamat']);
    $metode = htmlspecialchars($_POST['metode']);
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['harga'] * $item['jumlah'];
    }

    // Simpan ke tabel pesanan
    mysqli_query($koneksi, "INSERT INTO pesanan (username, alamat, metode_pembayaran, total) 
        VALUES ('$username', '$alamat', '$metode', $total)");
    $id_pesanan = mysqli_insert_id($koneksi);

    // Simpan item ke pesanan_item
    foreach ($_SESSION['cart'] as $item) {
        $nama = mysqli_real_escape_string($koneksi, $item['nama']);
        $harga = $item['harga'];
        $jumlah = $item['jumlah'];
        mysqli_query($koneksi, "INSERT INTO pesanan_item (id_pesanan, nama_produk, harga, jumlah)
            VALUES ($id_pesanan, '$nama', $harga, $jumlah)");
    }

    // Kosongkan keranjang
    unset($_SESSION['cart']);

    header("Location: thankyou.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Toko Online Kita</a>
            <div class="d-flex gap-2">
                <a href="keranjang.php" class="btn btn-outline-light">⬅ Kembali</a>
                <a href="logout.php" class="btn btn-light text-dark">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Checkout Form -->
    <div class="container my-5">
        <h3 class="mb-4">Checkout</h3>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Alamat Pengiriman</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <option value="COD">Bayar di Tempat (COD)</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Selesaikan Pesanan</button>
        </form>
    </div>

</body>

</html>