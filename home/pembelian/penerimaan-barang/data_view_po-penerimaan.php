<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailPO = mysqli_query($conn, "select * from po_penerimaan left join barang on barang.id_barang= po_penerimaan.KODE_BARANG  where po_penerimaan.NO_TRANSAKSI = '$noTransaksi' and po_penerimaan.st = 0 ");
    $data = array();
    while($rowDetailPO = mysqli_fetch_assoc($dataDetailPO)){
        $data[] = $rowDetailPO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>