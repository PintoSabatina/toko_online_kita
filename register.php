<?php
session_start();

// Koneksi ke database
$koneksi = mysqli_connect("sql210.infinityfree.com", "if0_39457801", "XBeH5slqxq", "if0_39457801_tokobaju_db");

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi'];

    if (empty($username) || empty($password) || empty($konfirmasi)) {
        $error = "Semua field wajib diisi.";
    } elseif ($password !== $konfirmasi) {
        $error = "Password dan konfirmasi tidak sama.";
    } else {
        // Cek username sudah ada atau belum
        $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($koneksi, "INSERT INTO users (username, password) VALUES ('$username', '$hash')");

            if ($insert) {
                echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
                exit();
            } else {
                $error = "Registrasi gagal. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register - Toko Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4>Registrasi Akun</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="konfirmasi" class="form-label">Konfirmasi Kata Sandi</label>
                                <input type="password" name="konfirmasi" class="form-control" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success w-100">Daftar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Sudah punya akun? <a href="login.php">Login</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>