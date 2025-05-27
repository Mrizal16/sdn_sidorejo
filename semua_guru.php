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
          <li class="nav-item"><a class="nav-link" href="index.php#beranda">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#tentang">Tentang Kami</a></li>
          <li class="nav-item"><a class="nav-link" href="#guru">Guru & Staf</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#prestasi">Prestasi</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#kegiatan">Kegiatan</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#galeri">Galeri Sekolah</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#kontak">Kontak</a></li>
        </ul>

      </div>
    </div>
  </nav>

  <main class="container mb-5">
    
    <!-- Guru & Staf -->
    <section id="guru" class="mb-5">
      <h2>Halaman Semua Foto Guru & Staf</h2>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <?php
          $conn = new mysqli("localhost", "root", "", "sd_sidorejo");
          if ($conn->connect_error) {
              die("Koneksi gagal: " . $conn->connect_error);
          }

          $result = $conn->query("SELECT * FROM guru ORDER BY id DESC");
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
    </section>

  </main>

  <footer class="bg-primary text-white py-4 text-center mt-auto">
    <p class="mb-0"><?= date('Y'); ?> SD Negeri Sidorejo</p>
  </footer>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const navLinks = document.querySelectorAll('nav a.nav-link');
      const sections = document.querySelectorAll('main section[id]');
      const navbar = document.querySelector('.navbar');

      const clearActiveLinks = () => {
        navLinks.forEach(link => link.classList.remove('active'));
      };

      const onScroll = () => {
        const scrollPos = window.scrollY + navbar.offsetHeight + 20;

        if (window.scrollY > 60) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }

        sections.forEach(section => {
          const top = section.offsetTop;
          const bottom = top + section.offsetHeight;

          if (scrollPos >= top && scrollPos < bottom) {
            clearActiveLinks();
            const id = section.id;
            const activeLink = document.querySelector(`nav a[href*="#${id}"]`);
            if (activeLink) activeLink.classList.add('active');

            if (!section.classList.contains('visible')) {
              section.classList.add('visible');
            }
          }
        });
      };

      onScroll();
      window.addEventListener('scroll', onScroll);

      navLinks.forEach(link => {
        link.addEventListener('click', e => {
          const href = link.getAttribute('href');
          const currentPage = window.location.pathname.split('/').pop();

          // Cek link untuk scroll ke section di halaman yang sama
          if (
            href.startsWith('#') || 
            (href.includes('#') && href.startsWith(currentPage))
          ) {
            e.preventDefault();
            const targetId = href.includes('#') ? href.split('#')[1] : '';
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
              window.scrollTo({
                top: targetSection.offsetTop - navbar.offsetHeight,
                behavior: 'smooth',
              });
            }
          }
          // Kalau link ke halaman lain, biarkan normal (tanpa preventDefault)
        });
      });

      // Animasi fade-in dengan Intersection Observer
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
              setTimeout(() => {
                entry.target.classList.add('visible');
              }, index * 150);
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.15 }
      );

      sections.forEach(section => observer.observe(section));
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="script.js"></script> -->
</body>
</html>
