<?php
session_start();
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


// Proteksi: hanya admin
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    echo "<script>alert('Hanya admin yang boleh mengakses!'); window.location='index.php';</script>";
    exit();
}

// Ambil semua pesanan
$pesanan = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_panel.php">Admin Panel</a>
            <a href="logout.php" class="btn btn-light text-dark">Logout</a>
        </div>
    </nav>

    <div class="container my-5">
        <h3>Daftar Pesanan</h3>

        <?php if (mysqli_num_rows($pesanan) === 0): ?>
            <div class="alert alert-warning mt-4">Belum ada pesanan.</div>
        <?php else: ?>
            <table class="table table-bordered mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($pesanan)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['alamat']) ?></td>
                            <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                            <td>Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><a href="admin_detail_pesanan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Lihat</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>