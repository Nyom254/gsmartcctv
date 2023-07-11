<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailPO = mysqli_query($conn, "SELECT * from detail_sales_order  INNER JOIN (SELECT id_barang, nama FROM barang) AS barang ON barang.id_barang = detail_sales_order.kode_barang where detail_sales_order.no_transaksi = '$noTransaksi'");
    $data = array();
    while($rowDetailPO = mysqli_fetch_assoc($dataDetailPO)){
        $data[] = $rowDetailPO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>