<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
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
    <link rel="stylesheet" href="../css/footer_user.css">
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<section class="hero-section">
    <div class="hero-inner">
        <div class="hero-left">
            <p class="hero-greeting">Halo, <?php echo htmlspecialchars(explode(' ', $nama_user)[0]); ?>! Selamat datang.</p>
            <h1 class="hero-poin">
                Poin Kamu: <span class="hero-poin-value">0</span>
            </h1>
            <div class="hero-meta">
                <span class="hero-meta-badge"><?php echo $level; ?></span>
                <span class="hero-meta-sep">•</span>
                <span><?php echo $hari_ini; ?></span>
            </div>
        </div>
        <div class="hero-right">
            <button class="btn-scan-qr" onclick="showUnregisteredAlert()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <rect x="7" y="7" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="13" y="7" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="7" y="13" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                    <rect x="13" y="13" width="4" height="4" rx="0.5" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                Scan QR Code
            </button>
            <p class="hero-scan-sub">Klaim poin setoran dengan scan QR</p>
        </div>
    </div>
</section>

<main class="main-content">
    <div class="container">
        <div class="content-grid">

            <!-- ── LEFT COLUMN ── -->
            <div class="col-left">

                <!-- Riwayat Setoran Terbaru -->
                <div class="card riwayat-card">
                    <div class="card-header">
                        <h2 class="card-title">Riwayat Setoran Terbaru</h2>
                        <a href="#" onclick="showUnregisteredAlert(); return false;" class="link-arrow">
                            Lihat semua riwayat
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>

                    <div class="table-wrap">
                        <table class="riwayat-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>TANGGAL</th>
                                    <th>JENIS SAMPAH</th>
                                    <th>BERAT</th>
                                    <th>POIN DITERIMA</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 20px;">Belum ada riwayat setoran.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <!-- ── RIGHT COLUMN ── -->
            <div class="col-right">

                <!-- Jumlah Penukaran Voucher -->
                <div class="card stat-card">
                    <p class="stat-card-label">JUMLAH PENUKARAN VOUCHER</p>
                    <div class="voucher-big-num">0</div>
                    <p class="voucher-sub-label">Penukaran berhasil</p>
                    <div class="voucher-list">
                        <div class="voucher-item"><span class="voucher-name">Belum ada penukaran</span></div>
                    </div>
                </div>

            </div>

        </div>


        <!-- ── KATALOG PENUKARAN HADIAH ── -->
        <section class="katalog-section">
            <div class="katalog-header">
                <h2 class="katalog-title">Katalog Penukaran Hadiah</h2>
                <a href="#" onclick="showUnregisteredAlert(); return false;" class="link-green">Lihat semua hadiah →</a>
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
