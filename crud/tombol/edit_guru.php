<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID guru tidak ditemukan.");
}

$id = intval($_GET['id']);
$error = '';
$success = '';

$sql = "SELECT * FROM guru WHERE id = $id";
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    die("Guru tidak ditemukan.");
}

$guru = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $jabatan = $conn->real_escape_string($_POST['jabatan']);

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = basename($_FILES['foto']['name']);
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

        if (!in_array($fileType, $allowedTypes)) {
            $error = "Format foto harus JPG atau PNG.";
        } else {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid('guru_', true) . '.' . $ext;
            $uploadDir = __DIR__ . '/uploads/';
            $destPath = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $destPath)) {
                $error = "Gagal mengupload foto.";
            } else {
                if (!empty($guru['foto']) && $guru['foto'] !== 'default.png') {
                    $oldFotoPath = $uploadDir . $guru['foto'];
                    if (file_exists($oldFotoPath)) {
                        unlink($oldFotoPath);
                    }
                }
                $guru['foto'] = $newFileName;
            }
        }
    }

    if (empty($error)) {
        $fotoForSql = isset($guru['foto']) ? $conn->real_escape_string($guru['foto']) : 'default.png';

        $updateSql = "UPDATE guru SET nama='$nama', jabatan='$jabatan', foto='$fotoForSql' WHERE id=$id";
        if ($conn->query($updateSql) === TRUE) {
            header("Location: ../../admin.php#manage-guru");
            exit;
        } else {
            $error = "Gagal memperbarui data: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Guru - SD Negeri Sidorejo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container py-5">
    <h2>Edit Data Guru</h2>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" id="nama" name="nama" class="form-control" required value="<?= htmlspecialchars($guru['nama']) ?>">
      </div>
      <div class="mb-3">
        <label for="jabatan" class="form-label">Jabatan</label>
        <input type="text" id="jabatan" name="jabatan" class="form-control" required value="<?= htmlspecialchars($guru['jabatan']) ?>">
      </div>
      <div class="mb-3">
        <label for="foto" class="form-label">Foto (kosongkan jika tidak ingin mengganti)</label><br>
        <?php
          $fotoUrl = '/web-sd/crud/uploads/' . ($guru['foto'] ?: 'default.png');
        ?>
        <img src="<?= htmlspecialchars($fotoUrl) ?>" alt="Foto Guru" style="width:80px; height:80px; object-fit:cover; border-radius:50%; border:1px solid #ccc;"><br><br>
        <input type="file" id="foto" name="foto" accept="image/png, image/jpeg" class="form-control" />
      </div>
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="../../admin.php#manage-guru" class="btn btn-secondary">Batal</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
