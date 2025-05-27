<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

if (!isset($_GET['id'])) {
    header("Location: ../../admin.php#manage-kegiatan");
    exit;
}

$id = intval($_GET['id']);
$kegiatan = null;

// Ambil data kegiatan berdasarkan id
$stmt = $conn->prepare("SELECT * FROM kegiatan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: ../../admin.php#manage-kegiatan");
    exit;
}
$kegiatan = $result->fetch_assoc();

// Proses update data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambarName = $kegiatan['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        // Hapus file gambar lama jika ada
        if (!empty($gambarName)) {
            $oldPath = __DIR__ . '/uploads/' . $gambarName;
            if (file_exists($oldPath)) unlink($oldPath);
        }
        // Upload file gambar baru
        $uploadDir = __DIR__ . '/uploads/';
        $gambarName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetPath = $uploadDir . $gambarName;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath);
    }

    // Update data ke database
    $updateStmt = $conn->prepare("UPDATE kegiatan SET judul = ?, deskripsi = ?, gambar = ? WHERE id = ?");
    $updateStmt->bind_param("sssi", $judul, $deskripsi, $gambarName, $id);
    $updateStmt->execute();

    header("Location: ../../admin.php#manage-kegiatan");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Edit Kegiatan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">
  <h2>Edit Kegiatan</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Judul</label>
      <input type="text" name="judul" class="form-control" required value="<?= htmlspecialchars($kegiatan['judul']) ?>" />
    </div>
    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($kegiatan['deskripsi']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Gambar</label>
      <br />
      <?php if (!empty($kegiatan['gambar']) && file_exists(__DIR__ . '/uploads/' . $kegiatan['gambar'])): ?>
        <img src="uploads/<?= rawurlencode($kegiatan['gambar']) ?>" alt="Gambar Kegiatan" style="max-width: 200px; margin-bottom: 10px;" />
      <?php else: ?>
        <p><em>Tidak ada gambar</em></p>
      <?php endif; ?>
      <input type="file" name="gambar" class="form-control" />
      <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="../../admin.php#manage-kegiatan" class="btn btn-secondary">Batal</a>
  </form>
</body>
</html>
