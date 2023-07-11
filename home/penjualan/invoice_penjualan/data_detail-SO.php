<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailSO = mysqli_query($conn, "SELECT * FROM detail_sales_order INNER JOIN (SELECT id_barang, nama FROM barang) AS barang on detail_sales_order.kode_barang = barang.id_barang LEFT JOIN so_invoice ON detail_sales_order.kode_barang = so_invoice.kode_barang AND detail_sales_order.no_transaksi = so_invoice.no_transaksi WHERE detail_sales_order.no_transaksi = '$noTransaksi'");
    $data = array();
    while($rowDetailSO = mysqli_fetch_assoc($dataDetailSO)){
        $data[] = $rowDetailSO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;
