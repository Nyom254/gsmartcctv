<?php 
include_once '../../../conn.php';

$no_pembayaran = urldecode($_GET['id']);

$queryAttachment = mysqli_query($conn, "select attachment from pembayaran_customer where no_pembayaran = $no_pembayaran");
$dataAttachment = mysqli_fetch_assoc($queryAttachment);
header("Content-type: image/*");
echo $dataAttachment['attachment'];
?>