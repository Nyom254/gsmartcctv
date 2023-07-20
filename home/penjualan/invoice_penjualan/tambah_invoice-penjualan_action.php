<?php
include '../../../conn.php';
session_start();
$queryTambahSalesOrder = mysqli_prepare($conn, "insert into invoice_penjualan (no_transaksi, tanggal, no_ref, keterangan, jatuh_tempo, diskon, dpp, ppn, jenis_ppn, subtotal, ppn_persentase, batal, pengirim, cruser, kode_departemen, kode_customer, no_so) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($queryTambahSalesOrder, "sssssdddsdiisssss", $no_transaksi, $tanggal, $no_ref, $keterangan, $jatuh_tempo, $diskon, $dpp, $ppn, $jenis_ppn, $subtotal, $ppn_persentase, $batal, $pengirim, $cruser, $kode_departemen, $kode_customer, $no_so);

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
$no_so = mysqli_escape_string($conn, $_POST['no_so']);
$gudang = mysqli_escape_string($conn, $_POST['gudang']);

$kode_barang = $_POST['kode-barang'];
$keteranganDetail = $_POST['keterangan-detail'];
$quantity = $_POST['qty-terjual'];
$harga = $_POST['harga'];
$diskonPersentase = $_POST['diskon-persentase'];
$diskonDetail = $_POST['diskon-satuan'];


$queryUpdateSO = mysqli_prepare($conn, "UPDATE sales_order set lama_invoice = ? where no_transaksi = '$no_so'");
mysqli_stmt_bind_param($queryUpdateSO, "i", $lama_invoice);

$queryGetTanggalSO = mysqli_query($conn, "SELECT tanggal from sales_order where no_transaksi = '$no_so'");
$rowTanggalSO = mysqli_fetch_assoc($queryGetTanggalSO);
$tanggalSO = DateTime::createFromFormat('Y-m-d', $rowTanggalSO['tanggal']);
$tanggalInvoice = DateTime::createFromFormat('Y-m-d', $tanggal);
$interval = $tanggalSO->diff($tanggalInvoice);
$lama_invoice = $interval->days;


$queryLogTambahInvoicePenjualan = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
mysqli_stmt_bind_param($queryLogTambahInvoicePenjualan, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

$action = "INSERT";
$keteranganLog = $_SESSION['username'] . " menambahkan Invoice Penjualan  " . $no_transaksi;
$userid = $_SESSION['id_user'];

if (array_key_exists('kode-barang', $_POST)) {
    if (mysqli_stmt_execute($queryTambahSalesOrder)) {
        for ($i = 0; $i < count($_POST['kode-barang']); $i++) {

            $queryTambahDetailInvoicePenjualan = mysqli_prepare($conn, "insert into detail_invoice_penjualan (no_transaksi, kode_barang, keterangan, quantity, harga, diskon_persentase, diskon) values (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($queryTambahDetailInvoicePenjualan, "sssiddd", $no_transaksi, $kode_barang[$i], $keteranganDetail[$i], $quantity[$i], $harga[$i], $diskonPersentase[$i], $diskonDetail[$i]);
            mysqli_stmt_execute($queryTambahDetailInvoicePenjualan);

            if (isset($quantity[$i]) && $quantity[$i] != '' && $quantity[$i] != 0) {
                $queryBarang = mysqli_query($conn, "select satuan, harga, type, kode_departemen from barang where id_barang = '$kode_barang[$i]'");
                $dataBarang = mysqli_fetch_assoc($queryBarang);
                $satuan = $dataBarang['satuan'];
                $status_stok;
                if ($dataBarang['type'] == 'non_persediaan') {
                    $status_stok = 0;
                } else {
                    $status_stok = 1;
                }
                $kode_departemen = $dataBarang['kode_departemen'];
                $quantityDetail = -$quantity[$i];
                $queryTambahSaldoStok = mysqli_prepare($conn, "insert into saldo_stok (no_transaksi, tgl, gudang, kode_barang, qty, satuan, harga, status_stok, kode_departmen) values (?, ?, ?, ?, ?, ?, ?, ?, ?) ");
                mysqli_stmt_bind_param($queryTambahSaldoStok, "ssssisiis", $no_transaksi, $tanggal, $gudang, $kode_barang[$i], $quantityDetail, $satuan, $harga[$i], $status_stok, $kode_departemen);
                mysqli_stmt_execute($queryTambahSaldoStok);
            }
        }
        mysqli_stmt_execute($queryUpdateSO);
        mysqli_stmt_execute($queryLogTambahInvoicePenjualan);
        mysqli_stmt_close($queryTambahSalesOrder);
        mysqli_close($conn);
        header("location:../../index.php?content=invoice_penjualan");
    } else {
        mysqli_close($conn);
        header("location:../../index.php?content=invoice_penjualan");
    }
} else {
    $m = "mohon pilih Sales Order yang telah terjual";
    header("location:../../index.php?content=invoice_penjualan?t=$m");
}
