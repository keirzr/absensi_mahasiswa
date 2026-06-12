<?php
include 'config.php';

if (isset($_POST['simpan'])) {
    $npm = $_POST['npm'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO mahasiswa (npm, nama, username, password) VALUES ('$npm', '$nama', '$username', '$password')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: dashboard.php?page=mahasiswa&status=sukses");
    } else {
        header("Location: dashboard.php?page=mahasiswa&status=gagal");
    }
}
?>