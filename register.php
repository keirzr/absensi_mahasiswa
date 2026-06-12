<?php
include 'config.php';
$pesan = "";

if (isset($_POST['register'])) {
    $npm = mysqli_real_escape_string($koneksi, $_POST['npm']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek apakah NPM atau Username sudah terdaftar
    $cek = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE npm='$npm' OR username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "<div class='alert alert-danger'>NPM atau Username sudah terdaftar!</div>";
    } else {
        // Insert ke database
        $query = "INSERT INTO mahasiswa (npm, nama, username, password) VALUES ('$npm', '$nama', '$username', '$password')";
        if (mysqli_query($koneksi, $query)) {
            $pesan = "<div class='alert alert-success'>Pendaftaran berhasil! Silakan <a href='index.php'>Login disini</a></div>";
        } else {
            $pesan = "<div class='alert alert-danger'>Gagal mendaftar, coba lagi.</div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body { background-color: #f8f9fa; } .register-container { max-width: 400px; margin-top: 60px; }</style>
</head>
<body>
<div class="container register-container">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center py-3">
            <h4>Form Pendaftaran</h4>
        </div>
        <div class="card-body p-4">
            <?= $pesan; ?>
            <form action="" method="POST">
                <div class="mb-3"><label class="form-label">NPM</label><input type="text" name="npm" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Nama Lengkap</label><input type="text" name="nama" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Username</label><input type="text" name="username" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" name="password" class="form-control" required></div>
                <button type="submit" name="register" class="btn btn-dark w-100">Daftar Sekarang</button>
                <div class="text-center mt-3"><a href="index.php" class="small text-decoration-none">Sudah punya akun? Login</a></div>
            </form>
        </div>
    </div>
</div>
</body>
</html>