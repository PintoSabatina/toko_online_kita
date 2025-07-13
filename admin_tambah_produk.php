<?php
session_start();

// Hanya admin yang bisa akses
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama_produk']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $harga = intval($_POST['harga']);

    // Proses upload gambar
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "uploads/" . basename($gambar);

    if (move_uploaded_file($tmp, $folder)) {
        $query = "INSERT INTO produk (nama_produk, deskripsi, harga, gambar) 
                  VALUES ('$nama', '$deskripsi', $harga, '$folder')";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            echo "<script>alert('Produk berhasil ditambahkan!'); window.location='admin_panel.php';</script>";
        } else {
            $error = "Gagal menyimpan produk ke database.";
        }
    } else {
        $error = "Upload gambar gagal.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h3 class="mb-4">Tambah Produk Baru</h3>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            <a href="admin_panel.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</body>

</html>