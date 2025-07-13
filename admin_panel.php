<?php
session_start();

// Hanya izinkan login sebagai admin
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// lanjut load produk
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");

$produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Produk</h3>
            <div class="d-flex gap-2">
                <a href="admin_pesanan.php" class="btn btn-primary">📦 Lihat Pesanan</a>
                <a href="admin_tambah_produk.php" class="btn btn-success">+ Tambah Produk</a>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($produk)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><img src="<?= $row['gambar'] ?>" width="80" alt="Gambar Produk"></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td>
                            <a href="admin_edit_produk.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin_hapus_produk.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>