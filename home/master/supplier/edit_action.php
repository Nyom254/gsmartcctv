<?php 
    include '../../../conn.php';

    session_start();

    $queryEditUser = mysqli_prepare($conn,"update supplier set alamat = ?, nama = ?, kota = ?, email = ?, keterangan = ?, status_aktif = ?, contact = ? where id_supplier = ? ");
    mysqli_stmt_bind_param($queryEditUser,"sssssiss", $alamat, $nama, $kota, $email, $keterangan, $status, $contact, $id_supplier);

    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $kota = mysqli_escape_string($conn, $_POST['kota']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $status = mysqli_escape_string($conn, $_POST['status']);
    $contact = mysqli_escape_string($conn, $_POST['contact']);
    $id_supplier = $_GET['id_supplier'];

    $queryLogEditSupplier = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditSupplier, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $queryDataSupplierLama = mysqli_query($conn, "select * from supplier where id_supplier = '$id_supplier'");
    $rowDataSupplierLama = mysqli_fetch_assoc($queryDataSupplierLama);

    $editedSupplier = array();

    if($nama !== $rowDataSupplierLama['nama']){
        $editedSupplier[] = "nama supplier dari " . $rowDataSupplierLama['nama'] . " menjadi $nama";
    }
    if($alamat !== $rowDataSupplierLama['alamat']){
        $editedSupplier[] = "alamat supplier dari " . $rowDataSupplierLama['alamat'] . " menjadi $alamat";
    }
    if($kota !== $rowDataSupplierLama['kota']){
        $editedSupplier[] = "kota supplier dari " . $rowDataSupplierLama['kota'] . " menjadi $kota";
    }
    if($email !== $rowDataSupplierLama['email']){
        $editedSupplier[] = "email supplier dari " . $rowDataSupplierLama['email'] . " menjadi $email";
    }
    if($keterangan !== $rowDataSupplierLama['keterangan']){
        $editedSupplier[] = "keterangan supplier dari " . $rowDataSupplierLama['keterangan'] . " menjadi $keterangan";
    }
    if($contact !== $rowDataSupplierLama['contact']){
        $editedSupplier[] = "contact supplier dari " . $rowDataSupplierLama['contact'] . " menjadi $contact";
    }
    if($status !== $rowDataSupplierLama['status_aktif']){
        $editedSupplier[] = "status supplier dari " . $rowDataSupplierLama['status_aktif'] . " menjadi $status";
    }

    $keteranganLog = implode(', ', $editedSupplier);


    $no_transaksi = $id_supplier;
    $action = "UPDATE" ;
    $keteranganLog = $_SESSION['username'] . " merubah " . $keteranganLog;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryEditUser)){
        mysqli_stmt_execute($queryLogEditSupplier);
        mysqli_stmt_close($queryEditUser);
        mysqli_close($conn);
        header("location:../../index.php?content=supplier");
    } else {
        mysqli_stmt_close($queryEditUser);
        mysqli_close($conn);
        header("location:../../index.php?content=supplier");
    }
?>