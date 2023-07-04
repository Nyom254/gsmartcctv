<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailSO = mysqli_query($conn, "SELECT * FROM detail_sales_order WHERE no_transaksi = '$noTransaksi'");
    $data = array();
    while($rowDetailSO = mysqli_fetch_assoc($dataDetailSO)){
        $data[] = $rowDetailSO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>