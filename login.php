<?php
session_start();

$host = 'localhost';
$db   = 'sd_sidorejo';
$user = 'root';
$pass = '';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username dan Password harus diisi!";
    } else {
        $stmt = $mysqli->prepare("SELECT id, password FROM admin WHERE BINARY username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                header('Location: admin.php');
                exit;
            } else {
                $error = "Username atau password salah!";
            }
        } else {
            $error = "Username atau password salah!";
        }
        $stmt->close();
    }
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login Admin SD Sidorejo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #74ebd5 0%, #ACB6E5 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 15px;
    }
    .login-card {
      max-width: 900px;
      width: 100%;
      background: #fff;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
      display: flex;
      overflow: hidden;
    }
    .login-card .login-image {
      flex: 1;
      background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=800&q=80') center/cover no-repeat;
      position: relative;
    }
    .login-card .login-image::after {
      content: "";
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.4);
      transition: background-color 0.3s ease;
    }
    .login-card .login-image:hover::after {
      background-color: rgba(0, 0, 0, 0.25);
    }
    .login-card .login-form {
      flex: 1;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .login-card h2 {
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: #333;
      text-align: center;
    }
    .form-floating > input:focus ~ label,
    .form-floating > input:not(:placeholder-shown) ~ label {
      opacity: 1;
      transform: scale(0.85) translateY(-1.2rem);
      color: #74ebd5;
    }
    .form-floating > label {
      color: #666;
      transition: all 0.3s ease;
    }
    .password-toggle {
      position: relative;
    }
    .password-toggle .toggle-icon {
      position: absolute;
      top: 50%;
      right: 1rem;
      transform: translateY(-50%);
      cursor: pointer;
      color: #999;
      user-select: none;
      font-size: 1.2rem;
    }
    .password-toggle .toggle-icon:hover {
      color: #74ebd5;
    }
    .alert {
      font-weight: 600;
      text-align: center;
    }
    .logo-sekolah {
      max-height: 100px;
      margin-bottom: 1rem;
    }
    @media (max-width: 767.98px) {
      .login-card {
        flex-direction: column;
        border-radius: 1rem;
      }
      .login-card .login-image {
        height: 200px;
        border-radius: 1rem 1rem 0 0;
      }
      .login-card .login-form {
        padding: 2rem 1.5rem;
      }
    }
  </style>
</head>
<body>

<div class="login-card shadow-lg" role="main" aria-label="Login Admin SD Sidorejo">
  <div class="login-image" aria-hidden="true"></div>

  <div class="login-form">
    <!-- LOGO SEKOLAH -->
    <div class="text-center">
      <img src="image/logo-sidorejo.png" alt="Logo SD Sidorejo" class="logo-sekolah img-fluid" />
    </div>

    <h2>Login Admin SD Sidorejo</h2>

    <?php if (!empty($error)) : ?>
      <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php" autocomplete="off" id="loginForm" novalidate>
      <div class="form-floating mb-4">
        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required />
        <label for="username">Username</label>
      </div>

      <div class="form-floating mb-4 password-toggle">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
        <label for="password">Password</label>
        <span class="toggle-icon" id="togglePassword" tabindex="0" role="button" aria-label="Tampilkan atau sembunyikan password">&#128065;</span>
      </div>

      <button type="submit" class="btn btn-primary btn-lg w-100">Masuk</button>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', () => {
    const type = passwordInput.getAttribute('type');
    if (type === 'password') {
      passwordInput.setAttribute('type', 'text');
      togglePassword.innerHTML = '&#128068;';
    } else {
      passwordInput.setAttribute('type', 'password');
      togglePassword.innerHTML = '&#128065;';
    }
  });

  togglePassword.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      togglePassword.click();
    }
  });

  const form = document.getElementById('loginForm');
  form.addEventListener('submit', (e) => {
    if (!form.username.value.trim() || !form.password.value.trim()) {
      e.preventDefault();
      alert('Username dan Password harus diisi!');
    }
  });
</script>

</body>
</html>
