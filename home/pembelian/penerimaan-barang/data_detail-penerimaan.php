<?php 
    include '../../../conn.php';
    $noPenerimaan = $_GET['no'];
    $dataDetailPenerimaan = mysqli_query($conn, "select * from detail_penerimaan where no_penerimaan = '$noPenerimaan'");
    $data = array();
    while($rowDetailPenerimaan = mysqli_fetch_assoc($dataDetailPenerimaan)){
        $data[] = $rowDetailPenerimaan;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>