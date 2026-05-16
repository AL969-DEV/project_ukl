<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'nasabah') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_setor = $_POST['id_setor'] ?? '';
    $id_nasabah = $_SESSION['id_nasabah'] ?? '';

    if (empty($id_setor)) {
        echo json_encode(['status' => 'error', 'message' => 'Data QR tidak valid.']);
        exit;
    }

    // Ambil transaksi
    $stmt = mysqli_prepare($conn, "SELECT status, poin FROM transaksi_setor WHERE id_setor = ? AND id_profile = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id_setor, $id_nasabah);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Transaksi tidak ditemukan atau bukan milikmu.']);
        exit;
    }

    $row = mysqli_fetch_assoc($res);
    if ($row['status'] === 'claimed') {
        echo json_encode(['status' => 'error', 'message' => 'QR Code ini sudah diklaim sebelumnya.']);
        exit;
    }

    $poin = $row['poin'];

    // Update status transaksi
    $update_trx = mysqli_prepare($conn, "UPDATE transaksi_setor SET status = 'claimed' WHERE id_setor = ?");
    mysqli_stmt_bind_param($update_trx, "i", $id_setor);
    
    if (mysqli_stmt_execute($update_trx)) {
        // Tambahkan poin ke nasabah
        $update_nasabah = mysqli_prepare($conn, "UPDATE nasabah SET total_poin = total_poin + ? WHERE id_nasabah = ?");
        mysqli_stmt_bind_param($update_nasabah, "ii", $poin, $id_nasabah);
        mysqli_stmt_execute($update_nasabah);

        echo json_encode(['status' => 'success', 'message' => 'Berhasil klaim ' . number_format($poin, 0, ',', '.') . ' poin!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal mengupdate transaksi.']);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
