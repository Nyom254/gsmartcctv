<?php
include '../../../conn.php';
$noTransaksi = $_GET['no'];
$dataDetailInvoice = mysqli_query($conn, "SELECT * FROM detail_invoice_penjualan LEFT JOIN (SELECT id_barang, nama from barang) as barang on barang.id_barang = detail_invoice_penjualan.kode_barang WHERE detail_invoice_penjualan.no_transaksi = '$noTransaksi'");
$data = array();
while ($rowDetailInvoice = mysqli_fetch_assoc($dataDetailInvoice)) {
    $data[] = $rowDetailInvoice;
}

$jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;
