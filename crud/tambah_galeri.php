<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $gambarName = '';

    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = __DIR__ . '/galeri/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        
        $gambarName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetPath = $uploadDir . $gambarName;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath);
    }

    $stmt = $conn->prepare("INSERT INTO galeri (judul, gambar) VALUES (?, ?)");
    $stmt->bind_param("ss", $judul, $gambarName);
    $stmt->execute();

    header("Location: ../admin.php#manage-galeri");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tambah Foto Galeri</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="container py-4">
  <h2>Tambah Foto Galeri</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="judul" class="form-label">Judul Foto</label>
      <input type="text" id="judul" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="gambar" class="form-label">Upload Gambar</label>
      <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="../admin.php#manage-galeri" class="btn btn-secondary">Batal</a>
  </form>
</body>
</html>
