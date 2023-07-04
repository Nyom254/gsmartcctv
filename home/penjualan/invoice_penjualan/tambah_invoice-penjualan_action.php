<?php
include '../../../conn.php';
session_start();
$queryTambahSalesOrder = mysqli_prepare($conn, "insert into invoice_penjualan (no_transaksi, tanggal, no_ref, keterangan, jatuh_tempo, diskon, dpp, ppn, jenis_ppn, subtotal, ppn_persentase, batal, term, pengirim, cruser, kode_departemen, kode_customer, no_so) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($queryTambahSalesOrder, "sssssdddsdiiisssss", $no_transaksi, $tanggal, $no_ref, $keterangan, $jatuh_tempo, $diskon, $dpp, $ppn, $jenis_ppn, $subtotal, $ppn_persentase, $batal, $term, $pengirim, $cruser, $kode_departemen, $kode_customer, $no_so);

$no_transaksi = mysqli_escape_string($conn, $_POST['no_transaksi']);
$tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
$no_ref = mysqli_escape_string($conn, $_POST['no_ref']);
$keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
$postTanggalJatuhTempo = mysqli_escape_string($conn, $_POST['jatuh_tempo']);
$jatuh_tempo = date('Y-m-d', strtotime($postTanggalJatuhTempo));
$diskon = $_POST['diskon'];
$dpp = $_POST['dpp'];
$ppn = $_POST['ppn'];
$jenis_ppn = mysqli_escape_string($conn, $_POST['jenis_ppn']);
$subtotal = $_POST['subtotal'];
$ppn_persentase = mysqli_escape_string($conn, $_POST['ppn-persen']);
$batal = 0;
$term = mysqli_escape_string($conn, $_POST['term']);
$pengirim = mysqli_escape_string($conn, $_POST['pengirim']);
$cruser = $_SESSION['username'];
$kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);
$kode_customer = mysqli_escape_string($conn, $_POST['customer']);
$no_so = mysqli_escape_string($conn, $_POST['no_so']);

$queryLogTambahSO = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
mysqli_stmt_bind_param($queryLogTambahSO, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

$action = "INSERT";
$keteranganLog = $_SESSION['username'] . " menambahkan Invoice Penjualan  " . $no_transaksi;
$userid = $_SESSION['id_user'];

if (mysqli_stmt_execute($queryTambahSalesOrder)) {
    mysqli_stmt_execute($queryLogTambahSO);
    mysqli_stmt_close($queryTambahSalesOrder);
    mysqli_close($conn);
    header("location:../../index.php?content=invoice_penjualan");
} else {
    mysqli_close($conn);
    header("location:../../index.php?content=invoice_penjualan");
}
