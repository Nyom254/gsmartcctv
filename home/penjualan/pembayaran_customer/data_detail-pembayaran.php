<?php 
include '../../../conn.php';
$noPembayaran = $_GET['no'];
$dataDetailPembayaran = mysqli_query($conn, "select * from detail_pembayaran where no_pembayaran = '$noPembayaran'");
$data = array();
while($rowDetailPembayaran = mysqli_fetch_assoc($dataDetailPembayaran)){
    $data[] = $rowDetailPembayaran;
}

$jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;
?>