<?php
include '../../../conn.php';
session_start();

if (array_key_exists('kode-barang', $_POST)) {
    $queryTambahSalesOrder = mysqli_prepare($conn, "insert into sales_order (no_transaksi, tanggal, no_ref, keterangan, jatuh_tempo, diskon, dpp, ppn, jenis_ppn, subtotal, ppn_persentase, batal, pengirim, cruser, kode_departemen, kode_customer) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahSalesOrder, "sssssdddsdiissss", $no_transaksi, $tanggal, $no_ref, $keterangan, $jatuh_tempo, $diskon, $dpp, $ppn, $jenis_ppn, $subtotal, $ppn_persentase, $batal, $pengirim, $cruser, $kode_departemen, $kode_customer);

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
    $pengirim = mysqli_escape_string($conn, $_POST['pengirim']);
    $cruser = $_SESSION['username'];
    $kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);
    $kode_customer = mysqli_escape_string($conn, $_POST['customer']);


    $kode_barang = $_POST['kode-barang'];
    $keteranganDetail = $_POST['keterangan-detail'];
    $quantity = $_POST['quantity'];
    $harga = $_POST['harga'];
    $diskon_barang = $_POST['diskon-barang'];
    $diskon_persentase_barang = $_POST['diskon-persentase'];
    $urutan = $_POST['no-urut'];



    $queryLogTambahSO = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahSO, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $action = "INSERT";
    $keteranganLog = $_SESSION['username'] . " menambahkan Sales Order  " . $no_transaksi;
    $userid = $_SESSION['id_user'];

    if (mysqli_stmt_execute($queryTambahSalesOrder)) {
        for ($i = 0; $i < count($_POST['kode-barang']); $i++) {
            $queryTambahDetailSalesOrder = mysqli_prepare($conn, "insert into detail_sales_order (no_transaksi, kode_barang, keterangan, quantity, harga, diskon, diskon_persentase, urutan) values (?, ?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($queryTambahDetailSalesOrder, "sssidddi", $no_transaksi, $kode_barang[$i], $keteranganDetail[$i], $quantity[$i], $harga[$i], $diskon_barang[$i], $diskon_persentase_barang[$i], $urutan[$i]);
            mysqli_stmt_execute($queryTambahDetailSalesOrder);
        }
        mysqli_stmt_execute($queryLogTambahSO);
        mysqli_stmt_close($queryTambahDetailSalesOrder);
        mysqli_stmt_close($queryTambahSalesOrder);
        mysqli_close($conn);
        header("location:../../index.php?content=sales_order");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=sales_order");
    }
} else {
    $m = "mohon isi barang yang akan di jual";
    header("location:../../index.php?content=tambah-sales-order&t=$m");
}
