<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
    require '../../../conn.php';

    $kode = $_GET['kode'];

    $queryEditGudang = mysqli_prepare($conn, "update Gudang set nama = ?, alamat = ?, penanggung_jawab = ?, status_aktif = ?");
    mysqli_stmt_bind_param($queryEditGudang, "sssi", $nama, $alamat, $penanggung_jawab, $status_aktif);

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $penanggung_jawab = mysqli_escape_string($conn, $_POST['penanggung_jawab']);
    $status_aktif = mysqli_escape_string($conn, $_POST['status']);

    $queryLogEditGudang = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditGudang, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $queryDataGudangLama = mysqli_query($conn, "select * from Gudang where kode = '$kode'");
    $rowDataGudangLama = mysqli_fetch_assoc($queryDataGudangLama);

    $editedSupplier = array();

    if($nama !== $rowDataGudangLama['nama']){
        $editedSupplier[] = "nama gudang dari " . $rowDataGudangLama['nama'] . " menjadi $nama";
    }
    if($alamat !== $rowDataGudangLama['alamat']){
        $editedSupplier[] = "alamat gudang dari " . $rowDataGudangLama['alamat'] . " menjadi $alamat";
    }
    if($penanggung_jawab !== $rowDataGudangLama['penanggung_jawab']){
        $editedSupplier[] = "penanggung jawab gudang dari " . $rowDataGudangLama['penanggung_jawab'] . " menjadi $penanggung_jawab";
    }
    if($status_aktif !== $rowDataGudangLama['status_aktif']){
        $editedSupplier[] = "status gudang dari " . $rowDataGudangLama['status_aktif'] . " menjadi $status_aktif";
    }

    $keteranganLog = implode(', ', $editedSupplier);


    $no_transaksi = $kode;
    $action = "UPDATE" ;
    $keteranganLog = $_SESSION['username'] . " merubah " . $keteranganLog;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryEditGudang)){
        mysqli_stmt_execute($queryLogEditGudang);
        mysqli_stmt_close($queryEditGudang);
        mysqli_close($conn);
        $m = "gudang berhasil terubah";
        header("location:../../index.php?content=gudang&t=$m");
    } else {
        mysqli_stmt_close($queryEditGudang);
        mysqli_close($conn);
        $m = "gudang gagal diubah";
        header("location:../../index.php?content=gudangt=$m");
    }
}
} else {
    http_response_code(405);
}
?>
