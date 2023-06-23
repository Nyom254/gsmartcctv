<?php 
    include '../../../conn.php';
    session_start();

    $queryEditBarang = mysqli_prepare($conn,"update barang set nama = ?, harga = ?, status_aktif = ?, satuan = ?, group_barang = ?, type = ?, kode_departemen = ? where id_barang = ? ");
    mysqli_stmt_bind_param($queryEditBarang,"siisssss", $nama, $harga, $status, $satuan, $group, $type, $kode_departemen, $id_barang);

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $harga = mysqli_escape_string($conn, $_POST['harga']);
    $status = mysqli_escape_string($conn, $_POST['status']);
    $satuan = mysqli_escape_string($conn, $_POST['satuan']);
    $group = mysqli_escape_string($conn, $_POST['group_barang']);
    $type = mysqli_escape_string($conn, $_POST['type']);
    $kode_departemen = mysqli_escape_string($conn, $_POST['departemen']);
    $id_barang = $_GET['id_barang'];

    $queryLogEditBarang = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditBarang, "ssss", $no_transaksi, $action, $keterangan, $userid);

    $queryDataBarangLama = mysqli_query($conn, "select * from barang where id_barang = '$id_barang'");
    $rowDataBarangLama = mysqli_fetch_assoc($queryDataBarangLama);

    $editedBarang = array();

    if($nama !== $rowDataBarangLama['nama']){
        $editedBarang[] = "nama barang dari " . $rowDataBarangLama['nama'] . " menjadi $nama";
    }
    if($harga !== $rowDataBarangLama['harga']){
        $editedBarang[] = "harga barang dari " . $rowDataBarangLama['harga'] . " menjadi $harga";
    }
    if($status !== $rowDataBarangLama['status_aktif']){
        $editedBarang[] = "status barang dari " . $rowDataBarangLama['status_aktif'] . " menjadi $status";
    }
    if($satuan !== $rowDataBarangLama['satuan']){
        $editedBarang[] = "satuan barang dari " . $rowDataBarangLama['satuan'] . " menjadi $satuan";
    }
    if($group !== $rowDataBarangLama['group_barang']){
        $editedBarang[] = "group barang dari " . $rowDataBarangLama['group_barang'] . " menjadi $group";
    }
    if($type !== $rowDataBarangLama['type']){
        $editedBarang[] = "tipe barang dari " . $rowDataBarangLama['type'] . " menjadi $type";
    }
    if($kode_departemen !== $rowDataBarangLama['kode_departemen']){
        $editedBarang[] = "departemen barang dari " . $rowDataBarangLama['kode_departemen'] . " menjadi $kode_departemen";
    }

    $keteranganLog = implode(', ', $editedBarang);

    $no_transaksi = $id_barang;
    $action = "UPDATE" ;
    $keterangan = $_SESSION['username'] . " merubah " . $keteranganLog ;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryEditBarang)){
        mysqli_stmt_close($queryEditBarang);
        mysqli_stmt_execute($queryLogEditBarang);
        mysqli_close($conn);
        header("location:../../index.php?content=barang");
    } else {
        mysqli_stmt_close($queryEditBarang);
        mysqli_close($conn);
        header("location:../../index.php?content=barang");
    }


?>