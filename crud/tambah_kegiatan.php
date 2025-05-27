<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambarName = '';

    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = __DIR__ . '/kegiatan/uploads/'; // direktori penyimpanan gambar
        $gambarName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetPath = $uploadDir . $gambarName;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath);
    }

    $stmt = $conn->prepare("INSERT INTO kegiatan (judul, deskripsi, gambar) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $judul, $deskripsi, $gambarName);
    $stmt->execute();

    header("Location: ../admin.php#manage-kegiatan");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tambah Kegiatan</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h2>Tambah Kegiatan</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Judul</label>
      <input type="text" name="judul" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
      <label>Gambar</label>
      <input type="file" name="gambar" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="../admin.php#manage-kegiatan" class="btn btn-secondary">Kembali</a>
  </form>
</body>
</html>
