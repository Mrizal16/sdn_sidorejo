<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

// Pastikan kolom kategori ada di database (jalankan sekali saja)
$conn->query("ALTER TABLE prestasi ADD COLUMN IF NOT EXISTS kategori VARCHAR(100) NOT NULL DEFAULT 'Umum'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori'] ?? 'Umum';  // Ambil kategori dari form
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

    $stmt = $conn->prepare("INSERT INTO prestasi (nama, deskripsi, tanggal, gambar, kategori) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama, $deskripsi, $tanggal, $gambarName, $kategori);
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
      <label>Kategori</label>
      <input type="text" name="kategori" class="form-control" placeholder="Misal: Olahraga, Akademik, Seni" required>
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
