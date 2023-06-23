<?php 
    include '../../../conn.php';
    $noTransaksi = $_GET['no'];
    $dataDetailPO = mysqli_query($conn, "select * from detail_purcashe_order left join po_penerimaan on detail_purcashe_order.KODE_BARANG = po_penerimaan.KODE_BARANG AND detail_purcashe_order.NO_TRANSAKSI = po_penerimaan.NO_TRANSAKSI where detail_purcashe_order.NO_TRANSAKSI = '$noTransaksi' and po_penerimaan.NO_TRANSAKSI = '$noTransaksi' and po_penerimaan.st = 0;");
    $data = array();
    while($rowDetailPO = mysqli_fetch_assoc($dataDetailPO)){
        $data[] = $rowDetailPO;
    }

    $jsonData = json_encode($data);

header('Content-Type: application/json');
echo $jsonData;

?>