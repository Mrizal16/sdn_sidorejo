<?php
$conn = new mysqli("localhost", "root", "", "sd_sidorejo");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$guruList = [];
$sql = "SELECT id, nama, jabatan, foto FROM guru ORDER BY nama ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $guruList[] = $row;
    }
}

$kegiatanList = [];
$sql = "SELECT id, judul, deskripsi, gambar, tanggal FROM kegiatan ORDER BY tanggal DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kegiatanList[] = $row;
    }
}

$prestasiList = [];
$sql = "SELECT id, nama, deskripsi, gambar, tanggal FROM prestasi ORDER BY tanggal DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $prestasiList[] = $row;
    }
}

$galeriList = [];
$sql = "SELECT id, judul, gambar, tanggal FROM galeri ORDER BY tanggal DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $galeriList[] = $row;
    }
}

$baseUrl = '/sdn_sidorejo'; // Ganti dengan URL dasar aplikasi Anda
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Dashboard - SD Negeri Sidorejo</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Fredoka', sans-serif;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header, footer {
      flex-shrink: 0;
    }
    main {
      flex-grow: 1;
    }
    .logo {
      width: 50px;
      height: 50px;
      object-fit: cover;
    }
    .foto-guru {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
      border: 2px solid #0d6efd;
    }
  </style>
</head>
<body>

  <header class="bg-primary text-white py-3 mb-4 shadow-sm">
    <div class="container d-flex align-items-center gap-3">
      <img src="image/WhatsApp_Image_2025-05-25_at_05.01.58_ead229b6-removebg-preview.png" alt="Logo SD" class="logo rounded-circle" />
      <div>
        <h1 class="h3 mb-0 fw-bold">Admin Dashboard</h1>
        <small class="fst-italic">Kelola Data SD Negeri Sidorejo</small>
      </div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Dashboard Admin</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="index.php#dashboard">Dashboard User</a></li>
          <li class="nav-item"><a class="nav-link" href="#manage-guru">Guru & Staf</a></li>
          <li class="nav-item"><a class="nav-link" href="#manage-kegiatan">Kegiatan</a></li>
          <li class="nav-item"><a class="nav-link" href="#manage-prestasi">Prestasi</a></li>
          <li class="nav-item"><a class="nav-link" href="#manage-galeri">Galeri</a></li>
        </ul>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </nav>

  <main class="container mb-5">

    <!-- Dashboard overview -->
    <section id="dashboard" class="mb-5">
      <h2>Ringkasan Statistik</h2>
      <div class="row row-cols-1 row-cols-md-4 g-3">
        <div class="col">
          <div class="card shadow-sm text-center p-3">
            <h3><?= count($guruList) ?></h3>
            <p>Jumlah Guru & Staf</p>
          </div>
        </div>
        <div class="col">
          <div class="card shadow-sm text-center p-3">
            <h3><?= count($kegiatanList) ?></h3>
            <p>Kegiatan Terjadwal</p>
          </div>
        </div>
        <div class="col">
          <div class="card shadow-sm text-center p-3">
            <h3><?= count($prestasiList) ?></h3>
            <p>Prestasi</p>
          </div>
        </div>
        <div class="col">
          <div class="card shadow-sm text-center p-3">
            <h3><?= count($galeriList) ?></h3>
            <p>Foto di Galeri</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Manage Guru & Staf -->
    <section id="manage-guru" class="mb-5">
      <h2>Kelola Guru & Staf</h2>
      <a href="crud/tambah_guru.php" class="btn btn-primary mb-3">Tambah Guru/Staf</a>
      <table class="table table-striped shadow-sm rounded align-middle">
        <thead>
          <tr>
            <th>Foto</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($guruList) > 0): ?>
            <?php foreach ($guruList as $guru): ?>
              <tr>
                <td>
                  <?php 
                    $fotoPath = __DIR__ . '/crud/uploads/' . $guru['foto'];
                    if (!empty($guru['foto']) && file_exists($fotoPath)) {
                      $fotoUrl = $baseUrl . '/crud/uploads/' . rawurlencode($guru['foto']);
                    } else {
                      $fotoUrl = $baseUrl . '/crud/uploads/default.png';
                    }
                  ?>
                  <img src="<?= htmlspecialchars($fotoUrl) ?>" alt="<?= htmlspecialchars($guru['nama']) ?>" class="foto-guru" />
                </td>
                <td><?= htmlspecialchars($guru['nama']) ?></td>
                <td><?= htmlspecialchars($guru['jabatan']) ?></td>
                <td>
                  <a href="crud/tombol/edit_guru.php?id=<?= $guru['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="crud/tombol/hapus_guru.php?id=<?= $guru['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus guru ini?')">Hapus</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center">Belum ada data guru/staf.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </section>

    <!-- Kelola kegiatan lain -->
    <section id="manage-kegiatan" class="mb-5">
      <h2>Kelola Kegiatan</h2>
      <a href="crud/tambah_kegiatan.php" class="btn btn-primary mb-3">Tambah Kegiatan</a>

      <?php if (count($kegiatanList) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 g-3">
          <?php foreach ($kegiatanList as $kegiatan): ?>
            <?php 
              $gambarPath = __DIR__ . '/crud/kegiatan/uploads/' . $kegiatan['gambar'];
              if (!empty($kegiatan['gambar']) && file_exists($gambarPath)) {
                  $gambarUrl = $baseUrl . '/crud/kegiatan/uploads/' . rawurlencode($kegiatan['gambar']);
              } else {
                  $gambarUrl = $baseUrl . '/crud/kegiatan/uploads/default_kegiatan.jpg';
              }
            ?>
            <div class="col">
              <div class="card h-100 shadow-sm">
                <img src="<?= htmlspecialchars($gambarUrl) ?>" class="card-img-top" alt="<?= htmlspecialchars($kegiatan['judul']) ?>" style="object-fit: cover; height: 200px;" />
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($kegiatan['judul']) ?></h5>
                  <small class="text-muted"><?= htmlspecialchars(date('d M Y', strtotime($kegiatan['tanggal']))) ?></small>
                  <p class="card-text mt-2"><?= nl2br(htmlspecialchars($kegiatan['deskripsi'])) ?></p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                  <a href="crud/kegiatan/edit.php?id=<?= $kegiatan['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="crud/kegiatan/hapus.php?id=<?= $kegiatan['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kegiatan ini?')">Hapus</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted">Belum ada kegiatan yang tercatat.</p>
      <?php endif; ?>
    </section>
    
    <!-- Kelola prestasi -->
    <section id="manage-prestasi" class="mb-5">
      <h2>Kelola Prestasi Sekolah</h2>
      <a href="crud/tambah_prestasi.php" class="btn btn-primary mb-3">Tambah Prestasi</a>

      <?php if (count($prestasiList) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 g-3">
          <?php foreach ($prestasiList as $prestasi): ?>
            <?php 
              $gambarPath = __DIR__ . '/crud/prestasi/uploads/' . $prestasi['gambar'];
              if (!empty($prestasi['gambar']) && file_exists($gambarPath)) {
                  $gambarUrl = $baseUrl . '/crud/prestasi/uploads/' . rawurlencode($prestasi['gambar']);
              } else {
                  $gambarUrl = $baseUrl . '/crud/prestasi/uploads/default_prestasi.jpg';
              }
            ?>
            <div class="col">
              <div class="card h-100 shadow-sm">
                <img src="<?= htmlspecialchars($gambarUrl) ?>" class="card-img-top" alt="<?= htmlspecialchars($prestasi['nama']) ?>" style="object-fit: cover; height: 200px;" />
                <div class="card-body">
                  <h5 class="card-title"><?= htmlspecialchars($prestasi['nama']) ?></h5>
                  <small class="text-muted"><?= htmlspecialchars(date('d M Y', strtotime($prestasi['tanggal']))) ?></small>
                  <p class="card-text mt-2"><?= nl2br(htmlspecialchars($prestasi['deskripsi'])) ?></p>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                  <a href="crud/prestasi/edit.php?id=<?= $prestasi['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="crud/prestasi/hapus.php?id=<?= $prestasi['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus prestasi ini?')">Hapus</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted">Belum ada prestasi yang tercatat.</p>
      <?php endif; ?>
    </section>

    <section id="manage-galeri" class="mb-5">
      <h2>Kelola Galeri Foto</h2>
      <a href="crud/tambah_galeri.php" class="btn btn-primary mb-3">Tambah Foto</a>

      <?php if (count($galeriList) > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-3">
          <?php foreach ($galeriList as $foto): ?>
            <?php 
              $gambarPath = __DIR__ . '/crud/galeri/uploads/' . $foto['gambar'];
              if (!empty($foto['gambar']) && file_exists($gambarPath)) {
                  $gambarUrl = $baseUrl . '/crud/galeri/uploads/' . rawurlencode($foto['gambar']);
              } else {
                  $gambarUrl = $baseUrl . '/crud/galeri/uploads/default.jpg';
              }
            ?>
            <div class="col">
              <div class="card h-100 shadow-sm">
                <img src="<?= htmlspecialchars($gambarUrl) ?>" class="card-img-top" alt="<?= htmlspecialchars($foto['judul']) ?>" style="object-fit: cover; height: 200px;" />
                <div class="card-body text-center">
                  <h5 class="card-title"><?= htmlspecialchars($foto['judul']) ?></h5>
                  <small class="text-muted"><?= htmlspecialchars(date('d M Y', strtotime($foto['tanggal']))) ?></small>
                </div>
                <div class="card-footer bg-white d-flex justify-content-end gap-2">
                  <a href="crud/galeri/edit.php?id=<?= $foto['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                  <a href="crud/galeri/hapus.php?id=<?= $foto['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus foto ini?')">Hapus</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-muted">Belum ada foto di galeri.</p>
      <?php endif; ?>
    </section>

  </main>

  <footer class="bg-primary text-white py-4 text-center mt-auto">
    <p class="mb-0">SD Negeri Sidorejo <?= date('Y'); ?></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
