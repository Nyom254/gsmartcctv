<?php
include '../../conn.php';
    $queryNoKertas = mysqli_query($conn, "select no_kertas from KERTAS");
    $data = array();
    while($rowNoKertas = mysqli_fetch_assoc($queryNoKertas)){
        $data[] = $rowNoKertas;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>