<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
        require '../../conn.php';

        $inventarisId = urldecode($_GET['id']);

        $queryAttachment = mysqli_query($conn, "select attachment from inventaris_kantor where no_inventaris = $inventarisId");
        $dataAttachment = mysqli_fetch_assoc($queryAttachment);
        header("Content-type: image/*");
        echo $dataAttachment['attachment'];
    }
} else {
    http_response_code(405);
}
