<?php
include '../../conn.php';
    $queryNoTransaksi = mysqli_query($conn, "select no_transaksi from `sales_order`");
    $data = array();
    while($rowNoTransaksi = mysqli_fetch_assoc($queryNoTransaksi)){
        $data[] = $rowNoTransaksi;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>