<?php
session_start();
$koneksi = mysqli_connect("localhost", "root", "", "e_commerce");


// Cek login dan hanya admin yang bisa akses
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    echo "<script>alert('Akses hanya untuk admin!'); window.location='index.php';</script>";
    exit();
}

$id = $_GET['id'] ?? 0;

// Ambil data pesanan
$pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id = $id");
$data = mysqli_fetch_assoc($pesanan);

if (!$data) {
    echo "<script>alert('Pesanan tidak ditemukan!'); window.location='admin_pesanan.php';</script>";
    exit();
}

// Update status jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $status_baru = $_POST['status'];
    mysqli_query($koneksi, "UPDATE pesanan SET status='$status_baru' WHERE id = $id");
    header("Location: admin_detail_pesanan.php?id=$id");
    exit();
}

// Ambil item pesanan
$item = mysqli_query($koneksi, "SELECT * FROM pesanan_item WHERE id_pesanan = $id");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan #<?= $id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h4>Detail Pesanan #<?= $id ?></h4>
        <p><strong>Nama:</strong> <?= htmlspecialchars($data['username']) ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
        <p><strong>Metode:</strong> <?= htmlspecialchars($data['metode_pembayaran']) ?></p>
        <p><strong>Tanggal:</strong> <?= $data['tanggal'] ?></p>

        <!-- Form ubah status -->
        <form method="post" class="mb-4">
            <label class="form-label"><strong>Status Pesanan:</strong></label>
            <div class="d-flex align-items-center gap-3">
                <select name="status" class="form-select w-auto">
                    <option value="Menunggu" <?= $data['status'] == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                    <option value="Selesai" <?= $data['status'] == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                </select>
                <button type="submit" class="btn btn-primary">Update Status</button>
            </div>
        </form>

        <h5 class="mt-4">Produk:</h5>
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
                <?php
                $total = 0;
                while ($i = mysqli_fetch_assoc($item)):
                    $sub = $i['harga'] * $i['jumlah'];
                    $total += $sub;
                ?>
                    <tr>
                        <td><?= htmlspecialchars($i['nama_produk']) ?></td>
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

        <a href="admin_pesanan.php" class="btn btn-secondary">⬅ Kembali</a>
    </div>

</body>

</html>