<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['username'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");


// Ambil ID produk dari URL
$id = $_GET['id'] ?? 0;

// Ambil data produk berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = $id");
$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    die("Produk tidak ditemukan.");
}

// Proses saat form disubmit
if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama_produk']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $harga = intval($_POST['harga']);
    $gambarLama = $_POST['gambar_lama'];

    // Cek apakah ada gambar baru di-upload
    if (!empty($_FILES['gambar']['name'])) {
        $gambarBaru = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = "uploads/" . basename($gambarBaru);

        if (move_uploaded_file($tmp, $folder)) {
            $gambar = $folder;
        } else {
            $error = "Upload gambar gagal.";
        }
    } else {
        $gambar = $gambarLama;
    }

    // Update ke database
    $sql = "UPDATE produk SET 
                nama_produk = '$nama',
                deskripsi = '$deskripsi',
                harga = $harga,
                gambar = '$gambar'
            WHERE id = $id";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Produk berhasil diupdate!'); window.location='admin_panel.php';</script>";
    } else {
        $error = "Gagal update produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container my-5">
        <h3 class="mb-4">Edit Produk</h3>

        <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="gambar_lama" value="<?= $produk['gambar'] ?>">

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($produk['deskripsi']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" value="<?= $produk['harga'] ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Gambar Sekarang</label><br>
                <img src="<?= $produk['gambar'] ?>" width="150">
            </div>

            <div class="mb-3">
                <label class="form-label">Ganti Gambar (opsional)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Update</button>
            <a href="admin_panel.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

</body>

</html>