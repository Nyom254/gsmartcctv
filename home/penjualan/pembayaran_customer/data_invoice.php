<?php 
include '../../../conn.php';
    $queryNoPembayaran = mysqli_query($conn, "select no_pembayaran from pembayaran_customer order by no_penerimaan desc limit 1");
    $data = array();
    while($rowNoPembayaran = mysqli_fetch_assoc($queryNoPembayaran)){
        $data[] = $rowNoPembayaran;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;
?>