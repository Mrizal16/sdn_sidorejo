<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sd_sidorejo";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
