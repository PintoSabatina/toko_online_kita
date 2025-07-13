<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Terima Kasih</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Toko Online Kita</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </nav>

    <div class="container text-center my-5">
        <h1 class="mb-4">🎉 Terima Kasih!</h1>
        <p class="lead">Pesanan kamu telah berhasil diproses.</p>
        <a href="index.php" class="btn btn-primary mt-3">Kembali ke Beranda</a>
    </div>

</body>

</html>