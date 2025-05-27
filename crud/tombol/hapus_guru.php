<?php

$conn = new mysqli("localhost", "root", "", "sd_sidorejo");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID guru tidak ditemukan.");
}

$id = intval($_GET['id']);

$sql = "SELECT foto FROM guru WHERE id = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $guru = $result->fetch_assoc();

    if (!empty($guru['foto']) && $guru['foto'] !== 'default.png') {
        $fotoPath = dirname(__DIR__) . '/uploads/' . $guru['foto'];

        if (file_exists($fotoPath)) {
            unlink($fotoPath);
        }
    }

    $deleteSql = "DELETE FROM guru WHERE id = $id";
    if ($conn->query($deleteSql) === TRUE) {
        header("Location: ../../admin.php#manage-guru");
        exit;
    } else {
        echo "Error saat menghapus data: " . $conn->error;
    }
} else {
    echo "Data guru tidak ditemukan.";
}

$conn->close();
?>
