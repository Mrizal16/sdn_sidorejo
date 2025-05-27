<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $conn->real_escape_string(trim($_POST['nama']));
    $jabatan = $conn->real_escape_string(trim($_POST['jabatan']));

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['foto']['tmp_name'];
        $filename = basename($_FILES['foto']['name']);
        $filename = str_replace(' ', '_', $filename);
        $filename = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $filename);

        $upload_dir = __DIR__ . "/uploads/";

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $new_filename = time() . "_" . $filename;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($tmp_name, $target_file)) {
            $foto = $new_filename;
        } else {
            $error = "Gagal mengupload foto.";
        }
    }

    if (!$error) {
        $stmt = $conn->prepare("INSERT INTO guru (nama, jabatan, foto) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $jabatan, $foto);
        if ($stmt->execute()) {
            header("Location: ../admin.php#manage-guru");
            exit;
        } else {
            $error = "Gagal menyimpan data: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tambah Guru - Admin SD Negeri Sidorejo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
  <div class="container mt-5">
    <h2>Tambah Guru / Staf</h2>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" novalidate>
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" required />
      </div>
      <div class="mb-3">
        <label for="jabatan" class="form-label">Jabatan</label>
        <input type="text" class="form-control" id="jabatan" name="jabatan" required />
      </div>
      <div class="mb-3">
        <label for="foto" class="form-label">Foto (opsional)</label>
        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" />
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
      <a href="../admin.php#manage-guru" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</body>
</html>
