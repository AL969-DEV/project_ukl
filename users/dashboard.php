<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

include '../includes/config.php';

$id_account = $_SESSION['id_account'] ?? 0;
$nama_user = $_SESSION['nama_lengkap'] ?? 'Calon Nasabah';
$saldo_poin = 0;
$level = 'Calon Nasabah';
$hari_ini = date('l, d F Y');

// Get rewards catalog (to show as teaser)
$query_catalog = "SELECT * FROM voucher_reward LIMIT 4";
$catalog_result = mysqli_query($conn, $query_catalog);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/navbar_user.css">
    <link rel="stylesheet" href="../css/dashboard_user.css">
    <link rel="stylesheet" href="../css/landing_page.css">
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<section class="landing-hero">
    <div class="container">
        <h1>Selamat Datang di SolusiSampah!</h1>
        <p>SolusiSampah adalah platform digital untuk membantu Anda mengelola sampah dengan baik. Anda dapat menyetorkan sampah anorganik seperti plastik, kertas, logam, dan kaca, lalu mendapatkan poin yang bisa ditukarkan dengan berbagai hadiah menarik.</p>
        
        <div class="akun-box">
            <h3>Detail Akun Anda</h3>
            <p><strong>Nama Lengkap:</strong> <?php echo htmlspecialchars($nama_user); ?></p>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username'] ?? '-'); ?></p>
            <p><strong>ID Akun:</strong> <?php echo htmlspecialchars($id_account); ?></p>
            <p><strong>Status Akun:</strong> <span style="color: red; font-weight: bold;">Belum Aktif (Calon Nasabah)</span></p>
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container">

        <h2 class="section-title">Cara Kerja SolusiSampah</h2>
        <div class="cara-daftar-list">
            <p style="margin-bottom: 10px; font-weight: bold;">Untuk bisa mulai menyetorkan sampah dan mengumpulkan poin, silakan ikuti langkah berikut:</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="width: 30px; vertical-align: top; font-weight: bold; color: #2d9e5c;">1.</td>
                    <td style="padding-bottom: 10px;"><strong>Bawa Akun Anda ke Petugas:</strong> Temui petugas Bank Sampah terdekat dan tunjukkan nama atau ID akun Anda di atas.</td>
                </tr>
                <tr>
                    <td style="width: 30px; vertical-align: top; font-weight: bold; color: #2d9e5c;">2.</td>
                    <td style="padding-bottom: 10px;"><strong>Petugas Melakukan Aktivasi:</strong> Petugas akan mengaktifkan akun Anda menjadi status <em>Nasabah Aktif</em>.</td>
                </tr>
                <tr>
                    <td style="width: 30px; vertical-align: top; font-weight: bold; color: #2d9e5c;">3.</td>
                    <td style="padding-bottom: 10px;"><strong>Setor Sampah & Dapatkan Poin:</strong> Setelah aktif, Anda bisa menyetorkan sampah anorganik ke petugas dan klaim poin setoran melalui scan QR code.</td>
                </tr>
            </table>
            
            <div class="info-pendaftaran">
                <strong>Pemberitahuan:</strong> Selama akun Anda belum diaktifkan oleh petugas, menu Tukar Poin dan Riwayat Setoran belum bisa digunakan. Silakan hubungi petugas Bank Sampah terdekat terlebih dahulu.
            </div>
        </div>

        <h2 class="section-title">Katalog Hadiah</h2>
        <section class="katalog-section" style="margin-bottom: 24px;">
            <div class="katalog-header">
                <h2 class="katalog-title" style="margin-top: 0;">Daftar Hadiah yang Bisa Ditukarkan</h2>
                <a href="#" onclick="showUnregisteredAlert(); return false;" class="link-green">Lihat Semua →</a>
            </div>

            <div class="katalog-grid">
                <?php if($catalog_result && mysqli_num_rows($catalog_result) > 0): ?>
                    <?php while($cat = mysqli_fetch_assoc($catalog_result)): ?>
                    <div class="hadiah-card">
                        <div class="hadiah-img-wrap">
                            <?php if(!empty($cat['gambar_voucher'])): ?>
                                <img src="../<?php echo htmlspecialchars($cat['gambar_voucher']); ?>" style="width:100%; height:100%; object-fit:cover; border-radius:8px 8px 0 0;" alt="Hadiah">
                            <?php else: ?>
                                <div class="hadiah-img-placeholder" style="background-color: #E5E7EB; border-radius: 8px 8px 0 0; display: flex; align-items: center; justify-content: center; height: 100%;">
                                    <span style="color: #9CA3AF;">No Image</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="hadiah-body">
                            <p class="hadiah-name"><?php echo htmlspecialchars($cat['nama_voucher']); ?></p>
                            <p class="hadiah-desc"><?php echo htmlspecialchars($cat['deskripsi'] ?? ''); ?></p>
                            <p class="hadiah-poin">Harga: <strong><?php echo number_format($cat['biaya_poin'] ?? 0, 0, ',', '.'); ?> poin</strong></p>
                            <button type="button" onclick="showUnregisteredAlert()" class="btn-tukar" style="display:block; width:100%; text-align:center; text-decoration:none; border:none; cursor:pointer; font-family:inherit; font-size:inherit;">Tukar Sekarang</button>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Belum ada hadiah di katalog.</p>
                <?php endif; ?>
            </div>
        </section>

    </div>
</main>

<?php include '../includes/footer_user.php'; ?>

<script>
function showUnregisteredAlert() {
    alert("Silakan daftar menjadi nasabah ke petugas terdekat terlebih dahulu.");
}

// Intercept all links that aren't the dashboard or logout, to prevent navigation
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        const href = link.getAttribute('href');
        // Only block relative links to other pages, but allow dashboard and logout
        if (href && !href.includes('dashboard.php') && !href.includes('logout.php') && href !== '#' && !href.startsWith('javascript:') && !href.startsWith('http')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showUnregisteredAlert();
            });
        }
    });
});
</script>

</body>
</html>
