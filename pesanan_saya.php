<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");

// Harus login
if (!isset($_SESSION['user'])) {
    echo "<script>alert('Login dulu ya!'); window.location='login.php';</script>";
    exit();
}

$username = $_SESSION['user']['username'];
$pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE username='$username' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Toko Online Kita</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container my-5">
        <h3>Riwayat Pesanan</h3>

        <?php if (mysqli_num_rows($pesanan) === 0): ?>
            <div class="alert alert-warning mt-3">Belum ada pesanan.</div>
        <?php else: ?>
            <table class="table table-bordered mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($pesanan)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td><span class="badge <?= $row['status'] == 'Selesai' ? 'bg-success' : 'bg-warning' ?>"><?= $row['status'] ?></span></td>
                            <td><a href="pesanan_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>