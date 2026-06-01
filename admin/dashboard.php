<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/config.php';

// Menghitung total nasabah 
$query_nasabah = "SELECT COUNT(*) as total FROM nasabah";
$result_nasabah = mysqli_query($conn, $query_nasabah);
$row_nasabah = mysqli_fetch_assoc($result_nasabah);
$total_nasabah = $row_nasabah['total'] ?? 0;

// Total Sampah Terkumpul
$query_sampah_total = "SELECT SUM(berat) as total_berat FROM transaksi_setor";
$result_sampah_total = mysqli_query($conn, $query_sampah_total);
$row_sampah_total = mysqli_fetch_assoc($result_sampah_total);
$total_sampah = $row_sampah_total['total_berat'] ?? 0;

// Setoran Sampah Bulan Ini
$query_sampah_bulan = "SELECT SUM(berat) as total_berat_bulan FROM transaksi_setor WHERE MONTH(tgl_setor) = MONTH(CURRENT_DATE()) AND YEAR(tgl_setor) = YEAR(CURRENT_DATE())";
$result_sampah_bulan = mysqli_query($conn, $query_sampah_bulan);
$row_sampah_bulan = mysqli_fetch_assoc($result_sampah_bulan);
$sampah_bulan_ini = $row_sampah_bulan['total_berat_bulan'] ?? 0;

// Total Poin Beredar
$query_poin_beredar = "SELECT SUM(total_poin) as total_poin_beredar FROM nasabah";
$result_poin_beredar = mysqli_query($conn, $query_poin_beredar);
$row_poin_beredar = mysqli_fetch_assoc($result_poin_beredar);
$total_poin_beredar = $row_poin_beredar['total_poin_beredar'] ?? 0;

// Poin di-redeem bulan ini
$query_poin_redeem = "SELECT SUM(v.biaya_poin) as poin_redeem FROM log_penukaran lp JOIN voucher_reward v ON lp.id_voucher = v.id_voucher WHERE MONTH(lp.tgl_tukar) = MONTH(CURRENT_DATE()) AND YEAR(lp.tgl_tukar) = YEAR(CURRENT_DATE())";
$result_poin_redeem = mysqli_query($conn, $query_poin_redeem);
$row_poin_redeem = mysqli_fetch_assoc($result_poin_redeem);
$poin_redeem_bulan_ini = $row_poin_redeem['poin_redeem'] ?? 0;

// Menghitung jumlah transaksi pending
$query_pending = "SELECT COUNT(*) as pending_count FROM transaksi_setor WHERE status = 'pending'";
$result_pending = mysqli_query($conn, $query_pending);
$row_pending = mysqli_fetch_assoc($result_pending);
$pending_count = $row_pending['pending_count'] ?? 0;

// Kategori Berat Sampah
$query_berat_kategori = "SELECT ks.nama_sampah, SUM(ts.berat) as total_berat FROM kategori_sampah ks LEFT JOIN transaksi_setor ts ON ks.id_kategori = ts.id_kategori GROUP BY ks.id_kategori";
$result_berat_kategori = mysqli_query($conn, $query_berat_kategori);
$berat_per_kategori = [
    'Plastik' => 0,
    'Kertas' => 0,
    'Logam' => 0,
    'Kaca & Lainnya' => 0
];
while ($row = mysqli_fetch_assoc($result_berat_kategori)) {
    $nama = strtolower($row['nama_sampah']);
    $berat = $row['total_berat'] ?? 0;
    if (strpos($nama, 'plastik') !== false) {
        $berat_per_kategori['Plastik'] += $berat;
    } elseif (strpos($nama, 'kertas') !== false || strpos($nama, 'kardus') !== false) {
        $berat_per_kategori['Kertas'] += $berat;
    } elseif (strpos($nama, 'logam') !== false || strpos($nama, 'besi') !== false) {
        $berat_per_kategori['Logam'] += $berat;
    } else {
        $berat_per_kategori['Kaca & Lainnya'] += $berat;
    }
}

$query_kat = "SELECT * FROM kategori_sampah ORDER BY id_kategori ASC";
$result_kat = mysqli_query($conn, $query_kat);

$query_trx = "SELECT ts.*, n.nama_lengkap, n.id_nasabah, ks.nama_sampah, ks.poin_per_kg 
              FROM transaksi_setor ts
              LEFT JOIN nasabah n ON ts.id_profile = n.id_nasabah
              LEFT JOIN kategori_sampah ks ON ts.id_kategori = ks.id_kategori
              ORDER BY ts.tgl_setor DESC LIMIT 10";
$result_trx = mysqli_query($conn, $query_trx);

$hari_inggris = date('l');
$hari_indo = [
    'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'
];
$bulan_indo = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
$tanggal_sekarang = $hari_indo[$hari_inggris] . ', ' . date('d') . ' ' . $bulan_indo[(int)date('m')] . ' ' . date('Y');
?>

<!DOCTYPE html>
<html lang="id">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – SolusiSampah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/solusi_sampah/css/dashboard_admin.css">
</head>
<body>

<div class="app-wrapper">

    <?php $active_page = 'dashboard'; include '../includes/sidebar_admin.php'; ?>

    <div class="main-content">

        <?php include '../includes/header_admin.php'; ?>

        <div class="page-content">

            <!-- Page Title -->
            <div class="page-title-section">
                <p class="page-breadcrumb-text">Dashboard</p>
                <h1 class="page-title">Selamat Datang, <?php echo htmlspecialchars($nama_admin); ?></h1>
                <p class="page-subtitle">Ringkasan aktivitas bank sampah hari ini–<?php echo $tanggal_sekarang; ?></p>
            </div>

            <!-- STAT CARDS ROW -->
            <div class="stat-cards-row">
                <div class="stat-card">
                    <div class="stat-card-icon blue">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="9" cy="7" r="4" stroke="#3B82F6" stroke-width="2"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#3B82F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-value"><?php echo number_format($total_nasabah, 0, ',', '.'); ?></p>
                        <p class="stat-card-label blue">Total Nasabah</p>
                        <p class="stat-card-sub">Data real time</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon green">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 3C8 3 5 6 5 10c0 3.5 2.5 6.5 7 10 4.5-3.5 7-6.5 7-10 0-4-3-7-7-7z" stroke="#16A34A" stroke-width="2" stroke-linejoin="round"/><path d="M12 10v0m0 0a2 2 0 100-4 2 2 0 000 4z" stroke="#16A34A" stroke-width="2"/></svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-value"><?php echo number_format($total_sampah, 2, ',', '.'); ?> <span class="stat-unit">Kg</span></p>
                        <p class="stat-card-label green">Total Sampah Terkumpul</p>
                        <p class="stat-card-sub">Setoran bulan ini: <?php echo number_format($sampah_bulan_ini, 2, ',', '.'); ?> Kg</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-icon yellow">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" stroke="#EAB308" stroke-width="2" stroke-linejoin="round"/></svg>
                    </div>
                    <div class="stat-card-body">
                        <p class="stat-card-value"><?php echo number_format($total_poin_beredar, 0, ',', '.'); ?></p>
                        <p class="stat-card-label yellow">Total Poin Beredar</p>
                        <p class="stat-card-sub">Poin di-redeem bulan ini: <?php echo number_format($poin_redeem_bulan_ini, 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

            <!-- CATEGORY WEIGHT CARDS ROW -->
            <div class="category-cards-row">
                <div class="category-card plastik">
                    <p class="category-card-label">Plastik</p>
                    <p class="category-card-value"><?php echo number_format($berat_per_kategori['Plastik'], 2, ',', '.'); ?> Kg</p>
                </div>
                <div class="category-card kertas">
                    <p class="category-card-label">Kertas</p>
                    <p class="category-card-value"><?php echo number_format($berat_per_kategori['Kertas'], 2, ',', '.'); ?> Kg</p>
                </div>
                <div class="category-card logam">
                    <p class="category-card-label">Logam</p>
                    <p class="category-card-value"><?php echo number_format($berat_per_kategori['Logam'], 2, ',', '.'); ?> Kg</p>
                </div>
                <div class="category-card kaca">
                    <p class="category-card-label">Kaca & Lainnya</p>
                    <p class="category-card-value"><?php echo number_format($berat_per_kategori['Kaca & Lainnya'], 2, ',', '.'); ?> Kg</p>
                </div>
            </div>

            <!-- BOTTOM SECTION: QR Generator + Recent Transactions -->
            <div class="bottom-section">

                <!-- QR Code Generator Panel -->
                <div class="panel qr-panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Generate QR Code</h2>
                        <span class="panel-badge-green">Setoran Baru</span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">ID Nasabah</label>
                        <input type="text" id="qr-id-nasabah" class="form-input" placeholder="Contoh: NSB-2024-2025">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Kategori Sampah</label>
                            <select class="form-select" id="qr-kategori">
                                <option value="">-- Pilih kategori --</option>
                                <?php 
                                if($result_kat && mysqli_num_rows($result_kat) > 0) {
                                    mysqli_data_seek($result_kat, 0);
                                    while($k = mysqli_fetch_assoc($result_kat)): 
                                ?>
                                    <option value="<?php echo htmlspecialchars($k['id_kategori']); ?>"><?php echo htmlspecialchars($k['nama_sampah']); ?></option>
                                <?php 
                                    endwhile; 
                                } else {
                                ?>
                                    <option value="1">Plastik</option>
                                    <option value="2">Kertas</option>
                                    <option value="3">Logam</option>
                                    <option value="4">Kaca & Lainnya</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Berat (Kg)</label>
                            <input type="number" id="qr-berat" class="form-input" placeholder="0.00" step="0.01">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan (opsional)</label>
                        <input type="text" id="qr-catatan" class="form-input" placeholder="Tambahkan catatan...">
                    </div>
                    <button class="btn-generate" onclick="generateQR()" id="btn-generate-qr">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M3 7V5a2 2 0 012-2h2M17 3h2a2 2 0 012 2v2M21 17v2a2 2 0 01-2 2h-2M7 21H5a2 2 0 01-2-2v-2" stroke="white" stroke-width="2" stroke-linecap="round"/><rect x="7" y="7" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/><rect x="13" y="7" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/><rect x="7" y="13" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/><rect x="13" y="13" width="4" height="4" rx="0.5" stroke="white" stroke-width="1.5"/></svg>
                        <span>Generate QR Code</span>
                    </button>
                    <div id="qr-result" style="margin-top: 20px; text-align: center; display: none;">
                        <img id="qr-image" src="" alt="QR Code" style="max-width: 150px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                        <p style="margin-top: 10px; font-size: 13px; color: #6B7280;">Scan QR ini untuk konfirmasi setoran</p>
                    </div>
                </div>

                <!-- Recent Transactions Panel -->
                <div class="panel transactions-panel">
                    <div class="panel-header">
                        <div>
                            <h2 class="panel-title">Transaksi Terbaru</h2>
                            <p class="panel-subtitle"><?php echo $pending_count; ?> Transaksi menunggu konfirmasi</p>
                        </div>
                    </div>

                    <div class="table-wrapper">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID TRANSAKSI</th>
                                    <th>NAMA NASABAH</th>
                                    <th>JENIS SAMPAH</th>
                                    <th>BERAT</th>
                                    <th>POIN</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result_trx) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result_trx)): 
                                        $poin = $row['poin'] > 0 ? $row['poin'] : ($row['berat'] * ($row['poin_per_kg'] ?? 0));
                                        
                                        $nama_parts = explode(' ', trim($row['nama_lengkap'] ?? 'Nasabah'));
                                        $initials = strtoupper(substr($nama_parts[0], 0, 1));
                                        if (count($nama_parts) > 1) {
                                            $initials .= strtoupper(substr($nama_parts[1], 0, 1));
                                        }
                                        
                                        $status_class = strtolower($row['status']) == 'claimed' ? 'selesai' : 'diproses';
                                        $status_text = strtolower($row['status']) == 'claimed' ? 'Selesai' : 'Pending';
                                        
                                        $kategori_class = strtolower(explode(' ', $row['nama_sampah'] ?? '')[0]);
                                        if (!in_array($kategori_class, ['plastik', 'kertas', 'logam', 'kaca'])) {
                                            $kategori_class = 'plastik';
                                        }
                                    ?>
                                    <tr>
                                        <td class="trx-id">#TRX-<?php echo str_pad($row['id_setor'], 4, '0', STR_PAD_LEFT); ?></td>
                                        <td>
                                            <div class="nasabah-cell">
                                                <div class="nasabah-avatar" style="background-color: #DCFCE7; color: #16A34A;"><?php echo $initials; ?></div>
                                                <div class="nasabah-info">
                                                    <span class="nasabah-name"><?php echo htmlspecialchars($row['nama_lengkap'] ?? 'Nasabah'); ?></span>
                                                    <span class="nasabah-id">NSB-<?php echo str_pad($row['id_nasabah'] ?? 0, 4, '0', STR_PAD_LEFT); ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-jenis <?php echo $kategori_class; ?>"><?php echo htmlspecialchars($row['nama_sampah'] ?? 'Lainnya'); ?></span></td>
                                        <td class="berat-cell"><?php echo $row['berat']; ?> Kg</td>
                                        <td class="poin-cell"><span class="star-icon">&#9733;</span> <?php echo number_format($poin, 0, ',', '.'); ?></td>
                                        <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 20px;">Belum ada transaksi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-footer">
                        <span class="table-info">Menampilkan transaksi terbaru</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function generateQR() {
    const idNasabahStr = document.getElementById('qr-id-nasabah').value;
    const kategori = document.getElementById('qr-kategori').value;
    const berat = document.getElementById('qr-berat').value;
    const catatan = document.getElementById('qr-catatan').value;

    if (!idNasabahStr || !kategori || !berat) {
        alert('Mohon lengkapi ID Nasabah, Kategori, dan Berat!');
        return;
    }

    const btn = document.getElementById('btn-generate-qr');
    const originalText = btn.innerHTML;
    btn.innerHTML = 'Memproses...';
    btn.disabled = true;

    // Send via AJAX to save to DB first
    const formData = new FormData();
    formData.append('id_nasabah', idNasabahStr);
    formData.append('id_kategori', kategori);
    formData.append('berat', berat);
    formData.append('catatan', catatan);

    fetch('ajax_generate_qr.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        btn.innerHTML = originalText;
        btn.disabled = false;

        if (data.status === 'success') {
            // Generate QR Code containing the id_setor
            const qrPayload = JSON.stringify({ type: 'setor', id_setor: data.id_setor });
            const dataString = encodeURIComponent(qrPayload);
            const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=${dataString}&margin=10`;

            const qrResult = document.getElementById('qr-result');
            const qrImage = document.getElementById('qr-image');
            
            qrImage.src = qrUrl;
            qrResult.style.display = 'block';
            
            // Clear form
            document.getElementById('qr-id-nasabah').value = '';
            document.getElementById('qr-kategori').value = '';
            document.getElementById('qr-berat').value = '';
            document.getElementById('qr-catatan').value = '';
        } else {
            alert(data.message || 'Gagal membuat QR Code');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan sistem.');
        btn.innerHTML = originalText;
        btn.disabled = false;
    });
}
</script>

</body>
</html>
