<?php
include '../../../conn.php';
    $queryNoPenerimaan = mysqli_query($conn, "select no_penerimaan from penerimaan order by no_penerimaan desc limit 1");
    $data = array();
    while($rowNoPenerimaan = mysqli_fetch_assoc($queryNoPenerimaan)){
        $data[] = $rowNoPenerimaan;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>