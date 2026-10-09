<?php
$host = "localhost";
$user = "root"; // Sesuaikan jika ada username lain
$pass = ""; // Jika pakai password di MySQL, isi di sini
$dbname = "sekolah"; // Ganti dengan nama database kamu

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
