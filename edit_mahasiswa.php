<?php
session_start();
include 'config.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query update data berdasarkan ID yang sedang login
    $query = "UPDATE mahasiswa SET npm='$npm', nama='$nama', username='$username', password='$password' WHERE id='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        // Update juga data session-nya biar nama di dashboard langsung berubah
        $_SESSION['nama'] = $nama;
        header("Location: dashboard.php?page=edit_profil&status=sukses");
    } else {
        header("Location: dashboard.php?page=edit_profil&status=gagal");
    }
}
?>