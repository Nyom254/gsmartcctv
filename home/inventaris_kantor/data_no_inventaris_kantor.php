<?php
    include '../../conn.php';

    $queryNoInventarisKantor = mysqli_query($conn, "select no_inventaris from inventaris_kantor");
    $data = array();
    while($rowNoInventarisKantor = mysqli_fetch_assoc($queryNoInventarisKantor)){
        $data[] = $rowNoInventarisKantor;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;
?>
