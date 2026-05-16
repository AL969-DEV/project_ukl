<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

include '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_nasabah_str = $_POST['id_nasabah'] ?? '';
    $id_kategori = $_POST['id_kategori'] ?? '';
    $berat = $_POST['berat'] ?? '';
    $catatan = $_POST['catatan'] ?? '';

    // Validate inputs
    if (empty($id_nasabah_str) || empty($id_kategori) || empty($berat)) {
        echo json_encode(['status' => 'error', 'message' => 'Semua kolom wajib diisi kecuali catatan.']);
        exit;
    }

    // Extract ID Nasabah
    // It can be "NSB-0001", "0001", or "1"
    $id_nasabah = preg_replace('/[^0-9]/', '', $id_nasabah_str);
    if (empty($id_nasabah)) {
        echo json_encode(['status' => 'error', 'message' => 'Format ID Nasabah tidak valid.']);
        exit;
    }

    // Check if nasabah exists
    $stmt_nasabah = mysqli_prepare($conn, "SELECT id_nasabah FROM nasabah WHERE id_nasabah = ?");
    mysqli_stmt_bind_param($stmt_nasabah, "i", $id_nasabah);
    mysqli_stmt_execute($stmt_nasabah);
    $res_nasabah = mysqli_stmt_get_result($stmt_nasabah);
    if (mysqli_num_rows($res_nasabah) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Nasabah tidak ditemukan.']);
        exit;
    }
    
    // Get Kategori and Poin
    $stmt_kat = mysqli_prepare($conn, "SELECT poin_per_kg FROM kategori_sampah WHERE id_kategori = ?");
    mysqli_stmt_bind_param($stmt_kat, "i", $id_kategori);
    mysqli_stmt_execute($stmt_kat);
    $res_kat = mysqli_stmt_get_result($stmt_kat);
    if (mysqli_num_rows($res_kat) === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Kategori sampah tidak valid.']);
        exit;
    }
    $kat_row = mysqli_fetch_assoc($res_kat);
    $poin_per_kg = $kat_row['poin_per_kg'];
    
    // Calculate Poin
    $poin = round(floatval($berat) * $poin_per_kg);
    
    $id_admin = $_SESSION['id_admin'] ?? 1; // Fallback if id_admin isn't in session but role is admin
    if (isset($_SESSION['id_account'])) {
        $id_admin = $_SESSION['id_account']; // Wait, in previous chats we saw admin id might be id_account.
    }

    // Insert to transaksi_setor
    $query = "INSERT INTO transaksi_setor (id_admin, id_profile, id_kategori, berat, poin, tgl_setor, status, catatan) 
              VALUES (?, ?, ?, ?, ?, NOW(), 'pending', ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iiidis", $id_admin, $id_nasabah, $id_kategori, $berat, $poin, $catatan);
    
    if (mysqli_stmt_execute($stmt)) {
        $id_setor = mysqli_insert_id($conn);
        echo json_encode(['status' => 'success', 'id_setor' => $id_setor]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan transaksi: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
