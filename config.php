<?php
$host = "localhost";
$user = "root";
$password = ""; // Kosongkan jika tidak ada password
$database = "healthy_bites";

$conn = new mysqli($host, $user, $password, $database);

// if ($conn->connect_error) {
//     die("Koneksi gagal: " . $conn->connect_error);
// } else {
//     echo "Koneksi berhasil!";
// }
// ?>
