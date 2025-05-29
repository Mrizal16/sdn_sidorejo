<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard SD Negeri Sidorejo</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <header class="bg-primary text-white py-3 mb-4 shadow-sm">
    <div class="container d-flex align-items-center gap-3">
      <img src="image/WhatsApp_Image_2025-05-25_at_05.01.58_ead229b6-removebg-preview.png" alt="Logo SD" class="logo rounded-circle" />
      <div>
        <h1 class="h3 mb-0 fw-bold" style="font-family: 'Fredoka', sans-serif;">SD Negeri Sidorejo</h1>
        <small class="fst-italic">Mendidik Generasi Emas Masa Depan</small>
      </div>
    </div>
  </header>

  <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm mb-4">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#beranda">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Kami</a></li>
          <li class="nav-item"><a class="nav-link" href="#guru">Guru & Staf</a></li>
          <li class="nav-item"><a class="nav-link" href="#prestasi">Prestasi</a></li>
          <li class="nav-item"><a class="nav-link" href="#kegiatan">Kegiatan</a></li>
          <li class="nav-item"><a class="nav-link" href="#galeri">Galeri Sekolah</a></li>
          <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
          <!-- <a href="login.php" class="btn btn-success">Login</a> -->
        </ul>
        <a href="login.php" class="btn btn-success ms-3">Login</a>
      </div>
    </div>
  </nav>

  <main class="container mb-5">

    <!-- Beranda -->
    <section id="beranda" class="mb-5">
      <h2 class="mb-3">Selamat Datang di SD Negeri Sidorejo</h2>
      <p class="lead">SD Negeri Sidorejo adalah sekolah dasar negeri yang berkomitmen memberikan pendidikan terbaik bagi anak-anak agar tumbuh cerdas, kreatif, dan berakhlak mulia.</p>
      <img src="image/2.png" alt="Anak-anak belajar" class="img-fluid rounded shadow-sm mb-4" />

      <h3>Informasi Sekolah</h3>
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        <div class="col">
          <div class="card h-100 shadow-sm border-0 rounded-4">
            <div class="card-body">
              <h5 class="card-title mb-3 text-primary">Informasi Umum</h5>
              <ul class="list-unstyled mb-0">
                <li><strong>NPSN:</strong> 20506534</li>
                <li><strong>Naungan:</strong> Kementerian Pendidikan dan Kebudayaan</li>
                <li><strong>Tanggal Berdiri:</strong> 1 April 1976</li>
                <li><strong>No. SK Pendirian:</strong> 800/17/413.101/1976</li>
                <li><strong>Tanggal Operasional:</strong> 17 November 2015</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card h-100 shadow-sm border-0 rounded-4">
            <div class="card-body">
              <h5 class="card-title mb-3 text-primary">Status & Legalitas</h5>
              <ul class="list-unstyled mb-0">
                <li><strong>No. SK Operasional:</strong> 421.2/4117/413.101/2015</li>
                <li><strong>Jenjang Pendidikan:</strong> SD</li>
                <li><strong>Status Sekolah:</strong> Negeri</li>
                <li><strong>Akreditasi:</strong> A (8 Desember 2021)</li>
                <li><strong>Sertifikasi:</strong> Belum Bersertifikat</li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col">
          <div class="card h-100 shadow-sm border-0 rounded-4">
            <div class="card-body">
              <h5 class="card-title mb-3 text-primary">Kontak & Kepala Sekolah</h5>
              <ul class="list-unstyled mb-0">
                <li><strong>Alamat:</strong> Jl. Kadet Soewoko No. 107A, Sidorejo</li>
                <li><strong>Email:</strong> sdn.srejo@gmail.com</li>
                <li><strong>Kepala Sekolah:</strong> Mudjiati</li>
                <li><strong>Operator:</strong> Arifal Nur Hidayat</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

    </section>

    <!-- Tentang Kami -->
    <section id="tentang" class="mb-5">
      <h2>Tentang Kami</h2>
      <div class="bg-light p-4 rounded shadow-sm">
        <p><strong>Visi:</strong> Menjadi sekolah dasar unggulan yang mencetak generasi berprestasi dan berkarakter.</p>
        <p><strong>Misi:</strong></p>
        <ul>
          <li>Menyelenggarakan pembelajaran yang berkualitas dan menyenangkan.</li>
          <li>Membina karakter dan moral siswa dengan nilai-nilai luhur.</li>
          <li>Mendorong kreativitas dan potensi setiap siswa.</li>
        </ul>
      </div>
    </section>

    <!-- Guru & Staf -->
    <section id="guru" class="mb-5">
      <h2>Guru & Staf</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php
          $conn = new mysqli("localhost", "root", "", "sd_sidorejo");
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM guru ORDER BY id DESC LIMIT 3");
          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $foto = $row['foto'] ? "crud/uploads/" . htmlspecialchars($row['foto']) : "image/default.png";
                  echo '
                  <div class="col">
                    <div class="card h-100 shadow-sm text-center">
                      <img src="' . $foto . '" class="card-img-top img-fluid" style="object-fit: cover; height: 300px;" alt="Foto Guru">
                      <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['nama']) . '</h5>
                        <p class="card-text text-muted">' . htmlspecialchars($row['jabatan']) . '</p>
                      </div>
                    </div>
                  </div>';
              }
          } else {
              echo '<p class="text-muted">Belum ada data guru yang ditambahkan.</p>';
          }
          $conn->close();
        ?>
      </div>
      <div class="mt-3 text-end">
        <a href="semua_guru.php" class="btn btn-outline-primary">Lihat Semua Guru</a>
      </div>
    </section>

    <!-- Prestasi -->
    <section id="prestasi" class="mb-5">
      <h2>Prestasi</h2>
      <div class="row row-cols-1 row-cols-md-2 g-4"> <!-- 2 kolom agar gambar besar -->
        <?php
          $conn = new mysqli("localhost", "root", "", "sd_sidorejo");
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM prestasi ORDER BY tanggal DESC LIMIT 2");

          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $gambarPath = (!empty($row['gambar']) && file_exists(__DIR__ . '/crud/prestasi/uploads/' . $row['gambar']))
                      ? 'crud/prestasi/uploads/' . htmlspecialchars($row['gambar'])
                      : 'image/default.png';

                  echo '
                  <div class="col">
                    <div class="card h-100 shadow-sm">
                      <img src="' . $gambarPath . '" class="card-img-top img-fluid" style="height: 300px; object-fit: cover;" alt="Gambar Prestasi">
                      <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row['nama']) . '</h5>
                        <p class="card-text small text-muted">' . date("d M Y", strtotime($row['tanggal'])) . '</p>
                        <p class="card-text">' . nl2br(htmlspecialchars($row['deskripsi'])) . '</p>
                      </div>
                    </div>
                  </div>';
              }
          } else {
              echo '<p class="text-muted">Belum ada data prestasi yang ditambahkan.</p>';
          }

          $conn->close();
        ?>
      </div>
      <div class="mt-3 text-end">
        <a href="semua_prestasi.php" class="btn btn-outline-primary">Lihat Semua Prestasi</a>
      </div>
    </section>

    <!-- Kegiatan -->
    <section id="kegiatan" class="mb-5">
      <h2>Kegiatan Sekolah</h2>
      <ul class="list-group list-group-flush shadow-sm rounded">
        <?php
          $conn = new mysqli("localhost", "root", "", "sd_sidorejo");
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM kegiatan ORDER BY id DESC LIMIT 3");
          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $gambarPath = (!empty($row['gambar']) && file_exists(__DIR__ . '/crud/kegiatan/uploads/' . $row['gambar']))
                      ? 'crud/kegiatan/uploads/' . htmlspecialchars($row['gambar'])
                      : 'image/default.png'; // fallback default image

                  echo '
                  <li class="list-group-item">
                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                      <img src="' . $gambarPath . '" alt="Gambar Kegiatan" class="img-thumbnail me-md-3 mb-3 mb-md-0" style="width: 150px; height: 100px; object-fit: cover;">
                      <div>
                        <h5 class="mb-1">' . htmlspecialchars($row['judul']) . '</h5>
                        <p class="mb-0">' . nl2br(htmlspecialchars($row['deskripsi'])) . '</p>
                      </div>
                    </div>
                  </li>';
              }
          } else {
              echo '<li class="list-group-item text-muted">Belum ada kegiatan yang ditambahkan.</li>';
          }

          $conn->close();
        ?>
      </ul>
      <div class="mt-3 text-end">
        <a href="semua_kegiatan.php" class="btn btn-outline-primary">Lihat Semua Kegiatan</a>
      </div>
    </section>

    <!-- Galeri -->
    <section id="galeri" class="mb-5">
      <h2>Galeri Sekolah</h2>
      <div class="row g-3">
        <?php
          $conn = new mysqli("localhost", "root", "", "sd_sidorejo");
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM galeri ORDER BY id DESC LIMIT 6");

          if ($result && $result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $gambarPath = (!empty($row['gambar']) && file_exists(__DIR__ . '/crud/galeri/uploads/' . $row['gambar']))
                      ? 'crud/galeri/uploads/' . htmlspecialchars($row['gambar'])
                      : 'image/default.png'; // fallback image jika tidak ditemukan

                  echo '
                  <div class="col-6 col-md-4">
                    <div class="card shadow-sm">
                      <img src="' . $gambarPath . '" class="card-img-top img-fluid" style="height: 200px; object-fit: cover;" alt="Galeri Sekolah">
                      <div class="card-body p-2">
                        <p class="card-text text-center fw-semibold small">' . htmlspecialchars($row['judul']) . '</p>
                      </div>
                    </div>
                  </div>';
              }
          } else {
              echo '<p class="text-muted">Belum ada foto di galeri.</p>';
          }

          $conn->close();
        ?>
      </div>
      <div class="mt-3 text-end">
        <a href="semua_galeri.php" class="btn btn-outline-primary">Lihat Semua Galeri</a>
      </div>
    </section>


    <!-- Kontak -->
    <section id="kontak" class="mb-5">
      <h2>Kontak Kami</h2>
      <div class="row">
        <div class="col-md-6 mb-3">
          <p><strong>Alamat:</strong> Jl. Kadet Soewoko, Bakalan, Sidorejo, Kec. Deket, Kabupaten Lamongan, Jawa Timur 62291</p>
          <p><strong>Email:</strong> sdn.srejo@gmail.com</p>
        </div>
        <div class="col-md-6">
          <div class="ratio ratio-16x9 rounded shadow-sm">
            <iframe 
              src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15831.046606358936!2d112.7153664!3d-7.2679424!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e77f0a718060eaf%3A0xc5285b89ffaabcab!2sSDN%20Sidorejo%20-%20DEKET!5e0!3m2!1sid!2sid!4v1748343299103!5m2!1sid!2sid" 
              width="100%" 
              height="450" 
              style="border:0;" 
              allowfullscreen="" 
              loading="lazy" 
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>

          </div>
        </div>
      </div>
    </section>

  </main>

  <footer class="bg-primary text-white py-4 text-center mt-auto">
    <p class="mb-0">SD Negeri Sidorejo <?= date('Y'); ?></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="script.js"></script>
</body>
</html>
