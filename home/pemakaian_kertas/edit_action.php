<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
    require '../../conn.php';

    $queryEditKertas = mysqli_prepare($conn, "update KERTAS set tgl = ?, jenis = ?, qty = ?, keterangan = ?, kode_user = ?, kode_barang = ?, mduser = ?, mdtime = ? where no_kertas = ? ");
    mysqli_stmt_bind_param($queryEditKertas, "ssissssss", $tanggal, $jenis, $qty, $keterangan, $kode_user, $kode_barang, $mduser, $mdtime, $no_kertas);

    $tanggal = mysqli_escape_string($conn, $_POST['tanggal']);
    $jenis = mysqli_escape_string($conn, $_POST['jenis']);
    $qty = mysqli_escape_string($conn, $_POST['quantity']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $kode_user = mysqli_escape_string($conn, $_POST['kode_user']);
    $kode_barang = mysqli_escape_string($conn, $_POST['kode_barang']);
    $mduser = $_SESSION['username'];
    date_default_timezone_set("Asia/jakarta");
    $mdtime = date('Y-m-d h:i:s');
    $no_kertas = mysqli_escape_string($conn, $_POST['no_kertas']);


    $queryLogEditKertas = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditKertas, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $queryDataKertasLama = mysqli_query($conn, "select * from KERTAS where no_kertas = '$no_kertas'");
    $rowDataKertasLama = mysqli_fetch_assoc($queryDataKertasLama);

    $editedKertas = array();

    if($tanggal !== $rowDataKertasLama['tgl']){
        $editedKertas[] = "tanggal pemakaian kertas dari " . $rowDataKertasLama['tanggal'] . " menjadi $tanggal";
    }
    if($jenis !== $rowDataKertasLama['jenis']){
        $editedKertas[] = "jenis pemakaian kertas dari " . $rowDataKertasLama['jenis'] . " menjadi $jenis";
    }
    if($qty !== $rowDataKertasLama['qty']){
        $editedKertas[] = "quantity pemakaian kertas dari " . $rowDataKertasLama['qty'] . " menjadi $qty";
    }
    if($kode_user !== $rowDataKertasLama['kode_user']){
        $editedKertas[] = "pengguna pemakaian kertas dari " . $rowDataKertasLama['kode_user'] . " menjadi $kode_user";
    }
    if($kode_barang !== $rowDataKertasLama['kode_barang']){
        $editedKertas[] = "barang pemakaian kertas dari " . $rowDataKertasLama['kode_barang'] . " menjadi $kode_barang";
    }
    if($keterangan !== $rowDataKertasLama['keterangan']){
        $editedKertas[] = "keterangan pemakaian kertas dari " . $rowDataKertasLama['keterangan'] . " menjadi $keterangan";
    }

    $keteranganLog = implode(', ', $editedKertas);


    $no_transaksi = $no_kertas;
    $action = "UPDATE" ;
    $keteranganLog = $_SESSION['username'] . " merubah " . $keteranganLog;
    $userid = $_SESSION['id_user'];


    if(mysqli_stmt_execute($queryEditKertas)){
        mysqli_stmt_execute($queryLogEditKertas);
        mysqli_stmt_close($queryEditKertas);
        mysqli_stmt_close($queryLogEditKertas);
        mysqli_close($conn);
        $m = "pemakaian kertas berhasil diubah";
        header("location:../index.php?content=pemakaian_kertas&t=$m");
    } else {
        mysqli_close($conn);
        $m = "pemakaian kertas gagal diubah";
        header("location:../index.php?content=pemakaian_kertas&t=$m");
    }
    }
} else {
    http_response_code(405);
}