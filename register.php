<?php
include 'includes/config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password_raw = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi kata sandi cocok
    if ($password_raw !== $confirm_password) {
        echo "<script>alert('Konfirmasi kata sandi tidak cocok!'); window.history.back();</script>";
        exit;
    }
    
    $password = password_hash($password_raw, PASSWORD_DEFAULT);
    
    mysqli_begin_transaction($conn);
    try {
        // Cek apakah username sudah ada
        $check_query = "SELECT id_account FROM accounts WHERE username = '$username'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Username sudah terdaftar! Silakan gunakan username lain.'); window.history.back();</script>";
            exit;
        }

        // Simpan ke tabel accounts
        $query_acc = "INSERT INTO accounts (username, password, role) VALUES ('$username', '$password', 'user')";
        mysqli_query($conn, $query_acc);
        
        $id_account = mysqli_insert_id($conn);
        
        // Simpan ke tabel nasabah
        $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
        $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
        
        $query_nas = "INSERT INTO nasabah (id_account, nama_lengkap, no_telp, alamat, total_poin) 
                      VALUES ('$id_account', '$nama_lengkap', '$no_hp', '', 0)";
        mysqli_query($conn, $query_nas);
        
        mysqli_commit($conn);
        
        echo "<script>alert('Akun berhasil dibuat! Silakan login untuk melanjutkan.'); window.location.href='index.php';</script>";
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "<script>alert('Gagal membuat akun: " . mysqli_real_escape_string($conn, $e->getMessage()) . "'); window.history.back();</script>";
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
              <button class="masuk-wrapper" type="button" onclick="window.location.href='index.php'">
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
              <span class="sampah" style="cursor: pointer;" onclick="window.location.href='index.php'">Masuk di sini</span>
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
                    placeholder="Kata sandi"
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
