<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


$id = $_GET['id'] ?? 0;
$pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id = $id");
$data = mysqli_fetch_assoc($pesanan);

// Cek pemilik
if (!isset($_SESSION['user']) || $data['username'] !== $_SESSION['user']['username']) {
    echo "<script>alert('Tidak bisa akses pesanan ini!'); window.location='pesanan_saya.php';</script>";
    exit();
}

$item = mysqli_query($koneksi, "SELECT * FROM pesanan_item WHERE id_pesanan = $id");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h4>Pesanan #<?= $data['id'] ?></h4>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
        <p><strong>Metode:</strong> <?= $data['metode_pembayaran'] ?></p>
        <p><strong>Status:</strong> <span class="badge <?= $data['status'] == 'Selesai' ? 'bg-success' : 'bg-warning' ?>"><?= $data['status'] ?></span></p>

        <h5 class="mt-4">Daftar Produk</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0;
                while ($i = mysqli_fetch_assoc($item)): $sub = $i['harga'] * $i['jumlah'];
                    $total += $sub; ?>
                    <tr>
                        <td><?= $i['nama_produk'] ?></td>
                        <td>Rp<?= number_format($i['harga'], 0, ',', '.') ?></td>
                        <td><?= $i['jumlah'] ?></td>
                        <td>Rp<?= number_format($sub, 0, ',', '.') ?></td>
                    </tr>
                <?php endwhile; ?>
                <tr class="table-secondary">
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong>Rp<?= number_format($total, 0, ',', '.') ?></strong></td>
                </tr>
            </tbody>
        </table>

        <a href="pesanan_saya.php" class="btn btn-secondary">⬅ Kembali</a>
    </div>
</body>

</html>