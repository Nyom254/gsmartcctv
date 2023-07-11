<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailSO = mysqli_query($conn, "SELECT * FROM `sales_order` LEFT JOIN( SELECT no_transaksi, kode_barang, keterangan AS keterangan_detail, quantity, harga, diskon, diskon_persentase, urutan FROM detail_sales_order ) AS detail_sales_order ON detail_sales_order.no_transaksi = sales_order.no_transaksi INNER JOIN so_invoice ON so_invoice.kode_barang = detail_sales_order.kode_barang  AND so_invoice.no_transaksi = detail_sales_order.no_transaksi INNER JOIN( SELECT id_barang, nama, status_aktif, satuan, group_barang, TYPE FROM barang WHERE status_aktif = 1 ) AS barang ON barang.id_barang = detail_sales_order.kode_barang WHERE sales_order.no_transaksi = '$noTransaksi' AND st = 0;");
    $data = array();
    while($rowDetailSO = mysqli_fetch_assoc($dataDetailSO)){
        $data[] = $rowDetailSO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>