<?php
$host = "localhost";
$user = "root"; 
$pass = "12345";     // <-- Password lu udah gua masukin di sini
$db   = "absensi";

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Kalau password/database salah lagi, baris di bawah ini bakal ngasih tau eror detailnya
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>