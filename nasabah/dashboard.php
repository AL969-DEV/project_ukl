<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'nasabah') {
    header("Location: ../login.php");
    exit;
}

include '../includes/config.php';

$id_account = $_SESSION['id_account'] ?? 0;
$nama_user = $_SESSION['nama_lengkap'] ?? 'Nasabah';

// Fetch nasabah data
$query_nasabah = "SELECT * FROM nasabah WHERE id_account = ?";
$stmt_nasabah = mysqli_prepare($conn, $query_nasabah);
mysqli_stmt_bind_param($stmt_nasabah, "i", $id_account);
mysqli_stmt_execute($stmt_nasabah);
$nasabah_data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_nasabah));

$id_nasabah = $nasabah_data['id_nasabah'] ?? 0;
$_SESSION['id_nasabah'] = $id_nasabah;

$saldo_poin = $nasabah_data['total_poin'] ?? 0;

// Get riwayat setoran
$query_riwayat = "SELECT ts.*, ks.nama_sampah 
                  FROM transaksi_setor ts 
                  LEFT JOIN kategori_sampah ks ON ts.id_kategori = ks.id_kategori
                  WHERE ts.id_profile = ? 
                  ORDER BY ts.tgl_setor DESC LIMIT 5";
$stmt_riwayat = mysqli_prepare($conn, $query_riwayat);
mysqli_stmt_bind_param($stmt_riwayat, "i", $id_nasabah);
mysqli_stmt_execute($stmt_riwayat);
$riwayat_result = mysqli_stmt_get_result($stmt_riwayat);

// Get total sampah disetor bulan ini
$query_total_sampah = "SELECT SUM(berat) as total_berat FROM transaksi_setor WHERE id_profile = ? AND status = 'claimed' AND MONTH(tgl_setor) = MONTH(CURRENT_DATE()) AND YEAR(tgl_setor) = YEAR(CURRENT_DATE())";
$stmt_sampah = mysqli_prepare($conn, $query_total_sampah);
mysqli_stmt_bind_param($stmt_sampah, "i", $id_nasabah);
mysqli_stmt_execute($stmt_sampah);
$sampah_result = mysqli_stmt_get_result($stmt_sampah);
$sampah_row = mysqli_fetch_assoc($sampah_result);
$total_sampah_kg = $sampah_row['total_berat'] ?? 0;

// Get total penukaran
$query_tukar = "SELECT COUNT(*) as total_tukar FROM log_penukaran WHERE id_profile = ?";
$stmt_tukar = mysqli_prepare($conn, $query_tukar);
mysqli_stmt_bind_param($stmt_tukar, "i", $id_nasabah);
mysqli_stmt_execute($stmt_tukar);
$tukar_result = mysqli_stmt_get_result($stmt_tukar);
$tukar_row = mysqli_fetch_assoc($tukar_result);
$total_penukaran = $tukar_row['total_tukar'] ?? 0;

// Level and Peringkat dummy for now, calculate if needed
$level = 'Level Gold';
$hari_ini = date('l, d F Y');

// Get active vouchers
$query_voucher = "SELECT lp.*, vr.nama_voucher FROM log_penukaran lp LEFT JOIN voucher_reward vr ON lp.id_voucher = vr.id_voucher WHERE lp.id_profile = ? ORDER BY lp.tgl_tukar DESC LIMIT 3";
$stmt_voucher = mysqli_prepare($conn, $query_voucher);
mysqli_stmt_bind_param($stmt_voucher, "i", $id_nasabah);
mysqli_stmt_execute($stmt_voucher);
$voucher_result = mysqli_stmt_get_result($stmt_voucher);

// Get rewards catalog
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
    
    <!-- SweetAlert2 & HTML5-QRCode -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <style>
        /* Scanner Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .scanner-container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .scanner-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .scanner-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }
        .btn-close-scanner {
            background: none; border: none; font-size: 20px; cursor: pointer; color: #666;
        }
        #reader {
            width: 100%;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>

<?php include '../includes/navbar_user.php'; ?>

<section class="hero-section">
    <div class="hero-inner">
        <div class="hero-left">
            <p class="hero-greeting">Halo, <?php echo htmlspecialchars(explode(' ', $nama_user)[0]); ?>! Selamat datang kembali.</p>
            <h1 class="hero-poin">
                Poin Kamu: <span class="hero-poin-value"><?php echo number_format($saldo_poin, 0, ',', '.'); ?></span>
            </h1>
            <div class="hero-meta">
                <span class="hero-meta-badge"><?php echo $level; ?></span>
                <span class="hero-meta-sep">•</span>
                <span>NSB-<?php echo str_pad($id_nasabah, 4, '0', STR_PAD_LEFT); ?></span>
                <span class="hero-meta-sep">•</span>
                <span><?php echo $hari_ini; ?></span>
            </div>
        </div>
        <div class="hero-right">
            <button class="btn-scan-qr" onclick="openScanner()">
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
                        <a href="riwayat.php" class="link-arrow">
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
                                <?php if(mysqli_num_rows($riwayat_result) > 0): ?>
                                    <?php while($r = mysqli_fetch_assoc($riwayat_result)): 
                                        $kategori_class = strtolower(explode(' ', $r['nama_sampah'] ?? 'plastik')[0]);
                                        $is_claimed = $r['status'] === 'claimed';
                                    ?>
                                    <tr>
                                        <td class="td-id">#S-<?php echo str_pad($r['id_setor'], 4, '0', STR_PAD_LEFT); ?></td>
                                        <td class="td-date"><?php echo date('d M Y', strtotime($r['tgl_setor'])); ?></td>
                                        <td><span class="badge-jenis <?php echo $kategori_class; ?>"><?php echo htmlspecialchars($r['nama_sampah']); ?></span></td>
                                        <td class="td-berat"><?php echo number_format($r['berat'], 1); ?> Kg</td>
                                        <td class="td-poin">+ <?php echo number_format($r['poin'], 0, ',', '.'); ?></td>
                                        <td><span class="badge-status <?php echo $is_claimed ? 'selesai' : ''; ?>"><?php echo $is_claimed ? '● Selesai' : '○ Pending'; ?></span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada riwayat setoran.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>


            <!-- ── RIGHT COLUMN ── -->
            <div class="col-right">

                <!-- Total Sampah Disetor -->
                <div class="card stat-card">
                    <p class="stat-card-label">TOTAL SAMPAH DISETOR</p>
                    <div class="sampah-big-num">
                        <?php echo number_format($total_sampah_kg, 1, ',', '.'); ?>
                    </div>
                    <p class="sampah-unit-label">Kilogram bulan ini</p>
                    <div class="progress-wrap">
                        <div class="progress-bar">
                            <?php 
                            $target = 50; 
                            $percent = min(100, round(($total_sampah_kg / $target) * 100)); 
                            ?>
                            <div class="progress-fill" style="width: <?php echo $percent; ?>%;"></div>
                        </div>
                        <div class="progress-labels">
                            <span>0 Kg</span>
                            <span><?php echo $percent; ?>% dari target <?php echo $target; ?> kg</span>
                        </div>
                    </div>
                </div>

                <!-- Jumlah Penukaran Voucher -->
                <div class="card stat-card">
                    <p class="stat-card-label">JUMLAH PENUKARAN VOUCHER</p>
                    <div class="voucher-big-num">
                        <?php echo number_format($total_penukaran, 0, ',', '.'); ?>
                    </div>
                    <p class="voucher-sub-label">Penukaran berhasil</p>
                    <div class="voucher-list">
                        <?php if(mysqli_num_rows($voucher_result) > 0): ?>
                            <?php while($v = mysqli_fetch_assoc($voucher_result)): ?>
                            <div class="voucher-item">
                                <span class="voucher-name"><?php echo htmlspecialchars($v['nama_reward']); ?></span>
                                <span class="voucher-badge aktif">Aktif</span>
                            </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="voucher-item"><span class="voucher-name">Belum ada penukaran</span></div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Peringkat Lingkungan -->
                <div class="card stat-card peringkat-card">
                    <p class="stat-card-label">PERINGKAT LINGKUNGAN</p>
                    <div class="peringkat-big-num">
                        #3
                    </div>
                    <p class="peringkat-sub">
                        Dari 248 nasabah aktif
                    </p>
                    <p class="peringkat-hint">
                        Butuh 1.700 poin lagi untuk menuju peringkat #1
                    </p>
                    <a href="peringkat.php" class="peringkat-arrow-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M12 5l7 7-7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

            </div>

        </div>


        <!-- ── KATALOG PENUKARAN HADIAH ── -->
        <section class="katalog-section">
            <div class="katalog-header">
                <h2 class="katalog-title">Katalog Penukaran Hadiah</h2>
                <a href="tukar_poin.php" class="link-green">Lihat semua hadiah →</a>
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
                            <a href="tukar_poin.php" class="btn-tukar" style="display:block;text-align:center;text-decoration:none;">Tukar Sekarang</a>
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

<!-- Scanner Modal -->
<div class="modal-overlay" id="scanner-modal">
    <div class="scanner-container">
        <div class="scanner-header">
            <h3>Scan QR Setoran</h3>
            <button class="btn-close-scanner" onclick="closeScanner()">&times;</button>
        </div>
        <div id="reader"></div>
        <p style="font-size: 13px; color: #666; margin-top: 10px;">Arahkan kamera ke QR Code yang diberikan oleh Admin Bank Sampah.</p>
    </div>
</div>

<script>
let html5QrcodeScanner = null;

function openScanner() {
    document.getElementById('scanner-modal').style.display = 'flex';
    
    if (!html5QrcodeScanner) {
        html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }
}

function closeScanner() {
    document.getElementById('scanner-modal').style.display = 'none';
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
        html5QrcodeScanner = null;
    }
}

function onScanSuccess(decodedText, decodedResult) {
    // decodedText is a JSON string from admin QR
    try {
        const data = JSON.parse(decodedText);
        if (data.type === 'setor' && data.id_setor) {
            closeScanner();
            claimPoints(data.id_setor);
        } else {
            Swal.fire('Error', 'QR Code tidak valid atau format salah.', 'error');
        }
    } catch (e) {
        Swal.fire('Error', 'QR Code tidak dapat dibaca.', 'error');
    }
}

function onScanFailure(error) {
    // handle scan failure, usually better to ignore and keep scanning
    // console.warn(`Code scan error = ${error}`);
}

function claimPoints(id_setor) {
    Swal.fire({
        title: 'Memproses...',
        text: 'Mengirim data ke server',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    const formData = new FormData();
    formData.append('id_setor', id_setor);

    fetch('ajax_claim_qr.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                confirmButtonColor: '#16A34A'
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: data.message || 'Terjadi kesalahan'
            });
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Koneksi ke server gagal.', 'error');
    });
}
</script>

</body>
</html>

