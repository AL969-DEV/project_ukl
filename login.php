<?php
session_start();
include 'includes/config.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query_acc  = "SELECT * FROM accounts WHERE username = '$username'";
    $result_acc = mysqli_query($conn, $query_acc);

    if (mysqli_num_rows($result_acc) === 1) {
        $row = mysqli_fetch_assoc($result_acc);

        if (password_verify($password, $row['password'])) {
            
            $_SESSION['id_account'] = $row['id_account'];
            $_SESSION['role']       = $row['role'];
            $_SESSION['username']   = $row['username'];

            if ($row['role'] === 'admin') {
                $_SESSION['nama_lengkap'] = "Administrator";
                header("Location: admin/dashboard.php");
                exit();

            } else if ($row['role'] === 'nasabah') {
                $id_acc = $row['id_account'];
                $query_profile = "SELECT nama_lengkap FROM nasabah WHERE id_account = '$id_acc'";
                $result_profile = mysqli_query($conn, $query_profile);
                
                if ($profile = mysqli_fetch_assoc($result_profile)) {
                    $_SESSION['nama_lengkap'] = $profile['nama_lengkap'];
                } else {
                    $_SESSION['nama_lengkap'] = "Nasabah Baru";
                }
                
                header("Location: nasabah/dashboard.php");
                exit();

            } else { // Jika role === 'user'
                $_SESSION['nama_lengkap'] = "Calon Nasabah";
                header("Location: users/dashboard.php");
                exit();
            }

        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak terdaftar!'); window.location='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="css/login.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
    />
  </head>
  <body>
    <div class="login">
      <div class="background"></div>
      <section class="logo-area">
        <div class="splash-screen-parent">
          <div class="splash-screen">
            <div class="graphic-area">
              <div class="illustration-area">
                <div class="illustration-area-child"></div>
                <img
                  class="image-14-icon"
                  alt="Logo"
                  src="assets/logo.svg"
                />
              </div>
              <div class="title-area-wrapper">
                <div class="title-area">
                  <div class="slogan-area">
                    <h3 class="solusisampah">
                      <span>Solusi</span>
                      <span class="sampah">Sampah</span>
                    </h3>
                  </div>
                  <div class="bank-sampah-digital">Bank Sampah Digital</div>
                  <?php if(isset($error)) echo "<p style='color: red; text-align: center; margin-bottom: 10px;'>$error</p>"; ?>
                </div>
              </div>
            </div>
            <div class="navigation-panel">
              <button class="tab-container">
                <div class="masuk">Masuk</div>
              </button>
              <button class="tab-container2" onclick="window.location.href='register.php'">
                <div class="daftar">Daftar</div>
              </button>
            </div>
            <div class="selamat-datang-parent">
              <h3 class="selamat-datang">Selamat Datang!</h3>
              <div class="belum-punya-akun-container">
                <span>Belum punya akun? </span>
                <span class="sampah" style="cursor: pointer;" onclick="window.location.href='register.php'">Daftar sekarang</span>
              </div>
            </div>
          </div>
          <form class="login-form" method="POST">
            <div class="frame-parent">
              <div class="email-atau-username-parent">
                <b class="email-atau-username">Email atau Username</b>
                <input class="username-field" name="username" type="text" required />
              </div>
              <div class="kata-sandi-parent">
                <b class="email-atau-username">Kata Sandi</b>
                <div style="position: relative; width: 100%;">
                  <input class="username-field" name="password" id="passwordField" type="password" style="padding-right: 45px;" required />
                  <img
                    class="image-16-icon"
                    alt="Toggle Password"
                    src="assets/mata.png"
                    style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); width: 23px; cursor: pointer; z-index: 10;"
                    onclick="const p = document.getElementById('passwordField'); p.type = p.type === 'password' ? 'text' : 'password';"
                  />
                </div>
                <div class="lupa-kata-sandi-wrapper">
                  <div class="lupa-kata-sandi">Lupa kata sandi?</div>
                </div>
              </div>
            </div>
            <button class="submit-button" name="login" type="submit">
              <b class="masuk2">Masuk</b>
            </button>
            <div class="frame-group">
              <div class="frame-wrapper">
                <div class="frame-container">
                  <div class="dividers-wrapper">
                    <div class="dividers"></div>
                  </div>
                  <div class="atau-lanjutkan-dengan">atau lanjutkan dengan</div>
                  <div class="dividers-wrapper">
                    <div class="dividers"></div>
                  </div>
                </div>
              </div>
              <button class="google-login-button" type="submit">
                <img
                  class="image-17-icon"
                  alt=""
                  src="./public/image-17@2x.png"
                />

                <div class="masuk-dengan-google">Masuk dengan Google</div>
              </button>
            </div>
          </form>
        </div>
      </section>
      <div class="image-18"></div>
    </div>
  </body>
</html>
