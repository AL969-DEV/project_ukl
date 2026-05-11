<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "solusi_sampah"; // Pastikan database kamu namanya ini

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>