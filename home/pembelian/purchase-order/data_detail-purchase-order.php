<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailPO = mysqli_query($conn, "select * from detail_purcashe_order where NO_TRANSAKSI = '$noTransaksi'");
    $data = array();
    while($rowDetailPO = mysqli_fetch_assoc($dataDetailPO)){
        $data[] = $rowDetailPO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>