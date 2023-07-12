<?php 
include_once '../../conn.php';

$inventarisId = urldecode($_GET['id']);

$queryAttachment = mysqli_query($conn, "select attachment from inventaris_kantor where no_inventaris = $inventarisId");
$dataAttachment = mysqli_fetch_assoc($queryAttachment);
header("Content-type: image/*");
echo $dataAttachment['attachment'];
?>