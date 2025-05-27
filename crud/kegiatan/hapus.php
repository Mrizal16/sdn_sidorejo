<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil nama file gambar agar bisa dihapus juga
    $result = $conn->query("SELECT gambar FROM kegiatan WHERE id = $id");
    if ($result && $row = $result->fetch_assoc()) {
        if (!empty($row['gambar'])) {
            $filePath = __DIR__ . '/uploads/' . $row['gambar'];
            if (file_exists($filePath)) {
                unlink($filePath); // hapus file gambar
            }
        }
    }

    // Hapus data kegiatan dari database
    $stmt = $conn->prepare("DELETE FROM kegiatan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: ../../admin.php#manage-kegiatan");
exit;
