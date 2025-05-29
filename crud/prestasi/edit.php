<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: ../../admin.php#manage-prestasi");
    exit;
}

$query = $conn->prepare("SELECT * FROM prestasi WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $kategori = $_POST['kategori'];
    $gambarName = $data['gambar'];

    if (!empty($_FILES['gambar']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        // Hapus gambar lama jika ada
        if (!empty($gambarName) && file_exists($uploadDir . $gambarName)) {
            unlink($uploadDir . $gambarName);
        }
        $gambarName = time() . '_' . basename($_FILES['gambar']['name']);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambarName);
    }

    $stmt = $conn->prepare("UPDATE prestasi SET nama = ?, deskripsi = ?, tanggal = ?, kategori = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $nama, $deskripsi, $tanggal, $kategori, $gambarName, $id);
    $stmt->execute();

    header("Location: ../../admin.php#manage-prestasi");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Prestasi</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-4">
  <h2>Edit Prestasi</h2>
  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label>Nama Prestasi</label>
      <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Deskripsi</label>
      <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
    </div>
    <div class="mb-3">
      <label>Tanggal</label>
      <input type="date" name="tanggal" class="form-control" value="<?= $data['tanggal'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Kategori</label>
      <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($data['kategori']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Gambar (kosongkan jika tidak ingin mengubah)</label>
      <input type="file" name="gambar" class="form-control">
      <?php if ($data['gambar']): ?>
        <img src="uploads/<?= htmlspecialchars($data['gambar']) ?>" alt="Gambar" class="img-thumbnail mt-2" style="max-height: 150px;">
      <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    <a href="../../admin.php#manage-prestasi" class="btn btn-secondary">Batal</a>
  </form>
</body>
</html>
