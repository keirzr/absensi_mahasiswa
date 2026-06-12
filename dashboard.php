<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}
include 'config.php';

// Ambil data real-time untuk Dashboard statistik
$total_mhs = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mahasiswa"));
$total_hadir = 1; // Contoh data hadir

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Ambil data mahasiswa yang sedang login harian untuk keperluan edit profil
$username_now = $_SESSION['nama'];
$user_logged = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nama='$username_now'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; overflow-x: hidden; }
        .sidebar { height: 100vh; background-color: #008080; color: #ffffff; position: fixed; box-shadow: 2px 0 5px rgba(0,0,0,0.05); }
        .sidebar h5 { font-weight: 700; letter-spacing: 0.5px; }
        .sidebar a { color: #e0f2f1; text-decoration: none; padding: 14px 24px; display: flex; align-items: center; font-weight: 500; transition: all 0.3s; }
        .sidebar a i { color: #000000 !important; width: 25px; font-size: 1.1rem; }
        .sidebar a:hover, .sidebar a.active { background-color: #006666; color: #ffffff; }
        .main-content { margin-left: 16.666667%; padding: 40px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02); }
        .card-header { border-top-left-radius: 10px !important; border-top-right-radius: 10px !important; font-weight: 600; }
        #reader { width: 100%; max-width: 500px; margin: auto; background: white; border-radius: 8px; }
        .card-icon-black { color: #000000 !important; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <div class="p-4 text-center border-bottom border-light border-opacity-10">
                <h5 class="mb-0 text-white">Absensi Mahasiswa</h5>
            </div>
            <div class="py-3">
                <a href="dashboard.php?page=dashboard" class="<?= $page == 'dashboard' ? 'active' : '' ?>">
                    <i class="fa-solid fa-chart-pie me-2"></i> Dashboard
                </a>
                <a href="dashboard.php?page=mahasiswa" class="<?= $page == 'mahasiswa' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-group me-2"></i> Mahasiswa
                </a>
                <a href="dashboard.php?page=search" class="<?= $page == 'search' ? 'active' : '' ?>">
                    <i class="fa-solid fa-magnifying-glass me-2"></i> Cari Mahasiswa
                </a>
                <a href="dashboard.php?page=scan" class="<?= $page == 'scan' ? 'active' : '' ?>">
                    <i class="fa-solid fa-qrcode me-2"></i> Scan Barcode
                </a>
                <a href="dashboard.php?page=edit_profil" class="<?= $page == 'edit_profil' ? 'active' : '' ?>">
                    <i class="fa-solid fa-user-gear me-2"></i> Edit Profil
                </a>
                <hr class="mx-3 text-white opacity-20">
                <a href="logout.php" class="text-white bg-danger bg-opacity-20">
                    <i class="fa-solid fa-power-off me-2 text-danger"></i> Keluar
                </a>
            </div>
        </div>

        <div class="col-md-10 main-content">
            
            <?php if ($page == 'dashboard'): ?>
                <div class="mb-4">
                    <h2 class="fw-bold text-dark">Selamat Datang, <?= $_SESSION['nama']; ?></h2>
                    <p class="text-muted">Fakultas Informatika dan Komputer - Presensi Absensi</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card bg-white p-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold mb-1"><?= $total_mhs; ?></h2>
                                    <p class="text-muted mb-0 small fw-medium">Total Mahasiswa Terdaftar</p>
                                </div>
                                <i class="fa-solid fa-graduation-cap fa-2x card-icon-black"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-white p-3">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fw-bold mb-1"><?= $total_hadir; ?></h2>
                                    <p class="text-muted mb-0 small fw-medium">Hadir Hari Ini</p>
                                </div>
                                <i class="fa-solid fa-clipboard-user fa-2x card-icon-black"></i>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif ($page == 'mahasiswa'): ?>
                <div class="card col-md-6 shadow-sm">
                    <div class="card-header bg-white border-bottom p-3">
                        <h5 class="mb-0 text-dark fw-bold">Tambah Data Mahasiswa</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                            <div class="alert alert-success border-0 py-2">Data berhasil disimpan!</div>
                        <?php endif; ?>
                        <form action="tambah_mahasiswa.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">NPM</label>
                                <input type="text" name="npm" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-dark w-100 mt-2">Simpan Data</button>
                        </form>
                    </div>
                </div>

            <?php elseif ($page == 'search'): ?>
                <div class="card shadow-sm mb-4 col-md-8">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">Pencarian Mahasiswa</h5>
                        <form action="" method="GET" class="row g-2">
                            <input type="hidden" name="page" value="search">
                            <div class="col-md-9">
                                <input type="text" name="keyword" class="form-control" placeholder="Cari nama atau NPM..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-dark w-100">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php 
                if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
                    $keyword = mysqli_real_escape_string($koneksi, $_GET['keyword']);
                    $search_query = "SELECT * FROM mahasiswa WHERE nama LIKE '%$keyword%' OR npm LIKE '%$keyword%'";
                    $search_result = mysqli_query($koneksi, $search_query);
                    
                    echo '<div class="card shadow-sm col-md-8"><div class="card-body p-0">';
                    if (mysqli_num_rows($search_result) > 0) {
                        echo '<table class="table table-hover mb-0 align-middle">
                                <thead class="table-light"><tr><th class="px-4 py-3">NPM</th><th class="py-3">Nama</th><th class="py-3">Username</th></tr></thead><tbody>';
                        while($mhs = mysqli_fetch_assoc($search_result)) {
                            echo "<tr>
                                    <td class='px-4 py-3 fw-semibold'>{$mhs['npm']}</td>
                                    <td>{$mhs['nama']}</td>
                                    <td>{$mhs['username']}</td>
                                  </tr>";
                        }
                        echo '</tbody></table>';
                    } else {
                        echo '<div class="p-4 text-danger small fw-medium">Data mahasiswa tidak ditemukan.</div>';
                    }
                    echo '</div></div>';
                }
                ?>

            <?php elseif ($page == 'edit_profil'): ?>
                <div class="card col-md-6 shadow-sm">
                    <div class="card-header bg-white border-bottom p-3">
                        <h5 class="mb-0 text-dark fw-bold">Pengaturan Profil Saya</h5>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
                            <div class="alert alert-success border-0 py-2">Profil Anda berhasil diperbarui!</div>
                        <?php endif; ?>
                        <form action="edit_mahasiswa.php" method="POST">
                            <input type="hidden" name="id" value="<?= $user_logged['id']; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">NPM</label>
                                <input type="text" name="npm" class="form-control" value="<?= $user_logged['npm']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= $user_logged['nama']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Username Server</label>
                                <input type="text" name="username" class="form-control" value="<?= $user_logged['username']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-semibold text-muted">Kata Sandi / Password</label>
                                <input type="text" name="password" class="form-control" value="<?= $user_logged['password']; ?>" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-dark w-100 mt-2">Update Profil Saya</button>
                        </form>
                    </div>
                </div>

            <?php elseif ($page == 'scan'): ?>
                <div class="card shadow-sm col-md-8 text-center">
                    <div class="card-header bg-white border-bottom p-3">
                        <h5 class="mb-0 text-dark fw-bold">Scanner Kamera</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small">Arahkan kode QR mahasiswa ke arah kamera laptop atau smartphone Anda.</p>
                        <div id="reader" class="border rounded p-2 mb-3"></div>
                        <div id="result" class="alert alert-success d-none border-0"></div>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php if ($page == 'scan'): ?>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            const resultDiv = document.getElementById('result');
            resultDiv.classList.remove('d-none');
            resultDiv.innerHTML = `<strong>QR Terdeteksi:</strong> ${decodedText} <br> <span class="small">Presensi berhasil dicatat.</span>`;
        }

        function onScanFailure(error) {}

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", { fps: 10, qrbox: 250 }
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
<?php endif; ?>

</body>
</html>