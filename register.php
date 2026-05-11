<?php
include 'includes/config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $query = "INSERT INTO accounts (username, password, role) VALUES ('$username', '$password', 'nasabah')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Akun berhasil dibuat! Silakan hubungi Admin untuk aktivasi profil.'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="initial-scale=1, width=device-width" />

    <link rel="stylesheet" href="css/register.css" />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap"
    />
  </head>
  <body>
    <div class="register">
      <div class="register-child"></div>
      <div class="register-item"></div>
      <img class="image-16-icon" alt="" src="./public/image-16@2x.png" />

      <section class="register-inner">
        <form class="frame-parent" method="POST">
          <div class="frame-group">
            <div class="rectangle-parent">
              <div class="frame-child"></div>
              <img
                class="image-14-icon"
                alt="Logo"
                src="assets/logo.svg"
              />
            </div>
            <div class="frame-wrapper">
              <div class="frame-container">
                <div class="solusisampah-wrapper">
                  <h3 class="solusisampah">
                    <span class="solusi">Solusi</span>
                    <span class="sampah">Sampah</span>
                  </h3>
                </div>
                <div class="bank-sampah-digital">Bank Sampah Digital</div>
              </div>
            </div>
          </div>
          <div class="frame-div">
            <div class="frame-parent2">
              <button class="masuk-wrapper" type="button" onclick="window.location.href='login.php'">
                <div class="masuk">Masuk</div>
              </button>
              <button class="daftar-wrapper" type="button">
                <div class="daftar">Daftar</div>
              </button>
            </div>
          </div>
          <div class="buat-akun-baru-parent">
            <h3 class="buat-akun-baru">Buat Akun Baru</h3>
            <div class="sudah-punya-akun-container">
              <span class="solusi">Sudah punya akun? </span>
              <span class="sampah" style="cursor: pointer;" onclick="window.location.href='login.php'">Masuk di sini</span>
            </div>
          </div>
          <div class="nama-lengkap-parent">
            <b class="nama-lengkap">Nama Lengkap</b>
            <input class="frame-item" name="nama_lengkap" type="text" />
          </div>
          <div class="nama-lengkap-parent">
            <b class="nama-lengkap">Alamat Email</b>
            <input class="frame-item" name="email" type="email" required />
          </div>
          <div class="nama-lengkap-parent">
            <b class="nama-lengkap">Username</b>
            <input class="frame-item" name="username" type="text" required />
          </div>
          <div class="nomor-hp-parent">
            <b class="nama-lengkap">Nomor HP</b>
            <input class="frame-item" name="no_hp" type="text" />
          </div>
          <div class="frame-parent3">
            <div class="frame-parent4">
              <div class="kata-sandi-parent">
                <b class="nama-lengkap">Kata Sandi</b>
              </div>
              <div class="rectangle-group">
                <div class="rectangle-div"></div>
                <div class="min-8-karakter-parent">
                  <input
                    class="min-8-karakter"
                    placeholder="Min. 8 karakter"
                    type="password"
                    name="password"
                  />

                </div>
              </div>
            </div>
            <div class="rectangle-container">
              <div class="frame-child2"></div>
              <div class="frame-child2"></div>
              <div class="frame-child2"></div>
              <div class="frame-child2"></div>
            </div>
          </div>
          <div class="ulangi-kata-sandi-parent">
            <b class="nama-lengkap">Ulangi Kata Sandi</b>
            <div class="rectangle-parent2">
              <div class="rectangle-div"></div>
              <input
                class="ulangi-kata-sandi2"
                placeholder="Ulangi kata sandi"
                type="password"
                name="confirm_password"
              />
            </div>
          </div>
          <div class="frame-parent5">
            <button class="buat-akun-sekarang-wrapper" type="submit" name="register">
              <b class="buat-akun-sekarang">Buat Akun Sekarang</b>
            </button>
            <div class="dengan-mendaftar-anda-menyetu-wrapper">
              <div class="dengan-mendaftar-anda-container">
                <span class="solusi">Dengan mendaftar. Anda menyetujui </span>
                <span class="syaratketentuan">Syarat&Ketentuan</span>
                <span class="solusi"> dan </span>
                <span class="syaratketentuan"
                  >Kebijakan<br />Privasi kami.</span
                >
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
  </body>
</html>
