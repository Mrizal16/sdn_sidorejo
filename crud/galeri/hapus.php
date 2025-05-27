<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("SELECT gambar FROM galeri WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $foto = $result->fetch_assoc();

    if ($foto) {
        $uploadDir = __DIR__ . '/uploads/';
        $gambarPath = $uploadDir . $foto['gambar'];
        if (!empty($foto['gambar']) && file_exists($gambarPath)) {
            unlink($gambarPath);
        }

        $stmtDel = $conn->prepare("DELETE FROM galeri WHERE id = ?");
        $stmtDel->bind_param("i", $id);
        $stmtDel->execute();
    }
}

header("Location: ../../admin.php#manage-galeri");
exit;
