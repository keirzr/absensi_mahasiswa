<?php
session_start();

$error = "";

// Cek apakah tombol login diklik
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    require_once 'config.php'; 

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek ke tabel mahasiswa
    $query = "SELECT * FROM mahasiswa WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['login'] = true;
        $_SESSION['nama']  = $row['nama'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Absensi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { max-width: 400px; margin-top: 100px; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="card shadow">
        <div class="card-header bg-dark text-white text-center py-3">
            <h4>Absensi Kamera</h4>
        </div>
        <div class="card-body p-4">
            <?php if(!empty($error)): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>
            
            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" name="login" class="btn btn-dark w-100">Login</button>
                
                <div class="text-center mt-3">
                    <a href="register.php" class="small text-decoration-none text-muted">Belum punya akun? Daftar disini</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>