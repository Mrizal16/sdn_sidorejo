<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ../admin.php#manage-galeri");
    exit;
}

// Ambil data foto berdasarkan id
$stmt = $conn->prepare("SELECT * FROM galeri WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$foto = $result->fetch_assoc();

if (!$foto) {
    header("Location: ../../admin.php#manage-galeri");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $gambarName = $foto['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        // Hapus gambar lama jika ada
        if (!empty($gambarName) && file_exists($uploadDir . $gambarName)) {
            unlink($uploadDir . $gambarName);
        }

        $gambarName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetPath = $uploadDir . $gambarName;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath);
    }

    $stmt = $conn->prepare("UPDATE galeri SET judul = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("ssi", $judul, $gambarName, $id);
    $stmt->execute();

    header("Location: ../../admin.php#manage-galeri");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Edit Foto Galeri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">
  <h2>Edit Foto Galeri</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="judul" class="form-label">Judul Foto</label>
      <input type="text" id="judul" name="judul" class="form-control" required value="<?= htmlspecialchars($foto['judul']) ?>">
    </div>
    <div class="mb-3">
      <label for="gambar" class="form-label">Ganti Gambar (kosongkan jika tidak ingin mengubah)</label>
      <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
      <small>Gambar saat ini:</small><br />
      <?php if (!empty($foto['gambar']) && file_exists(__DIR__ . '/uploads/' . $foto['gambar'])): ?>
        <img src="../galeri/uploads/<?= htmlspecialchars($foto['gambar']) ?>" alt="Gambar saat ini" style="max-height: 150px;">
      <?php else: ?>
        <p><em>Tidak ada gambar</em></p>
      <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="../../admin.php#manage-galeri" class="btn btn-secondary">Batal</a>
  </form>
</body>
</html>
