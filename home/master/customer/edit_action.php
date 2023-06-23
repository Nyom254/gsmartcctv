<?php 
    include '../../../conn.php';
    session_start();

    $queryEditCustomer = mysqli_prepare($conn, "update customer set nama = ?, alamat = ?, telp = ?, kota = ?, provinsi = ?, keterangan = ?, status_aktif = ?, email = ?, status = ? where id_customer = ?");
    mysqli_stmt_bind_param($queryEditCustomer,"ssssssisss", $nama, $alamat, $telp, $kota, $provinsi, $keterangan, $status_aktif, $email, $status, $id_customer);

    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $telp = mysqli_escape_string($conn, $_POST['no_telp']);
    $kota = mysqli_escape_string($conn, $_POST['kota']);
    $provinsi = mysqli_escape_string($conn, $_POST['provinsi']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $status_aktif = mysqli_escape_string($conn, $_POST['status_aktif']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $status = mysqli_escape_string($conn, $_POST['status']);
    $id_customer = $_GET['id_customer'];


    $queryLogEditCustomer = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogEditCustomer, "ssss", $no_transaksi, $action, $keteranganLog, $userid);


    $queryDataCustomerLama = mysqli_query($conn, "select * from customer where id_customer = '$id_customer'");
    $rowDataCustomerLama = mysqli_fetch_assoc($queryDataCustomerLama);

    $editedCustomer = array();

    if($nama !== $rowDataCustomerLama['nama']){
        $editedCustomer[] = "nama customer dari " . $rowDataCustomerLama['nama'] . " menjadi $nama";
    }
    if($alamat !== $rowDataCustomerLama['alamat']){
        $editedCustomer[] = "alamat customer dari " . $rowDataCustomerLama['alamat'] . " menjadi $alamat";
    }
    if($telp !== $rowDataCustomerLama['telp']){
        $editedCustomer[] = "no telp customer dari " . $rowDataCustomerLama['telp'] . " menjadi $telp";
    }
    if($kota !== $rowDataCustomerLama['kota']){
        $editedCustomer[] = "kota customer dari " . $rowDataCustomerLama['kota'] . " menjadi $kota";
    }
    if($provinsi !== $rowDataCustomerLama['provinsi']){
        $editedCustomer[] = "provinsi customer dari " . $rowDataCustomerLama['provinsi'] . " menjadi $provinsi";
    }
    if($keterangan !== $rowDataCustomerLama['keterangan']){
        $editedCustomer[] = "keterangan customer dari " . $rowDataCustomerLama['keterangan'] . " menjadi $keterangan";
    }
    if($status_aktif !== $rowDataCustomerLama['status_aktif']){
        $editedCustomer[] = "status aktif customer dari " . $rowDataCustomerLama['status_aktif'] . " menjadi $status_aktif";
    }
    if($email !== $rowDataCustomerLama['email']){
        $editedCustomer[] = "email customer dari " . $rowDataCustomerLama['email'] . " menjadi $email";
    }
    if($status !== $rowDataCustomerLama['status']){
        $editedCustomer[] = "status customer dari " . $rowDataCustomerLama['status'] . " menjadi $status";
    }


    $keteranganLog = implode(', ', $editedCustomer);

    $no_transaksi = $id_customer;
    $action = "UPDATE" ;
    $keteranganLog = $_SESSION['username'] . " merubah " . $keteranganLog;
    $userid = $_SESSION['id_user'];

    if(mysqli_stmt_execute($queryEditCustomer)) {
        mysqli_stmt_execute($queryLogEditCustomer);
        mysqli_stmt_close($queryEditCustomer);
        mysqli_close($conn);
        header("location:../../index.php?content=customer");
    }  else {
        mysqli_close($conn);
        header("location:../../index.php?content=customer?m=gagal");
    }

?>