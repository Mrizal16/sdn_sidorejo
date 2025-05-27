<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $gambarName = '';

    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = __DIR__ . '/prestasi/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $gambarName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetPath = $uploadDir . $gambarName;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath);
    }

    $stmt = $conn->prepare("INSERT INTO prestasi (nama, deskripsi, tanggal, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $deskripsi, $tanggal, $gambarName);
    $stmt->execute();

    header("Location: ../admin.php#manage-prestasi");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tambah Prestasi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h2>Tambah Prestasi</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama Prestasi</label>
      <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
    </div>
    <div class="mb-3">
      <label>Tanggal Prestasi</label>
      <input type="date" name="tanggal" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Gambar</label>
      <input type="file" name="gambar" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="../admin.php#manage-prestasi" class="btn btn-secondary">Kembali</a>
  </form>
</body>
</html>
