<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
        require '../../conn.php';
        
        $queryNoInventarisKantor = mysqli_query($conn, "select no_inventaris from inventaris_kantor");
        $data = array();
        while ($rowNoInventarisKantor = mysqli_fetch_assoc($queryNoInventarisKantor)) {
            $data[] = $rowNoInventarisKantor;
        }

        $jsonData = json_encode($data);

        header('Content-Type: application/json');
        echo $jsonData;
    }
} else {
    http_response_code(405);
}
