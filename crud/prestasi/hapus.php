<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

$id = $_GET['id'] ?? null;
if ($id) {
    // Ambil nama file gambar sebelum dihapus
    $query = $conn->prepare("SELECT gambar FROM prestasi WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_assoc();

    // Hapus dari database
    $stmt = $conn->prepare("DELETE FROM prestasi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Hapus file gambar jika ada
    if (!empty($data['gambar'])) {
        $filePath = __DIR__ . '/uploads/' . $data['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

header("Location: ../../admin.php#manage-prestasi");
exit;
?>
