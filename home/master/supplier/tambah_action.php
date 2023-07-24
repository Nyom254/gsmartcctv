<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
    require '../../../conn.php';


    $queryTambahSupplier = mysqli_prepare($conn, "insert into supplier (id_supplier, alamat, nama, kota, email, keterangan, status_aktif, contact) values(?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryTambahSupplier,"ssssssis",$id_supplier,$alamat,$nama,$kota,$email,$keterangan,$status_aktif, $contact);
    $queryIdSupplier = mysqli_query($conn, "select id_supplier from supplier order by id_supplier desc limit 1");
    $cekIdSupplier = $queryIdSupplier -> num_rows;

    if ($cekIdSupplier > 0) {
        $rowIdSupplier = mysqli_fetch_assoc($queryIdSupplier);
        $lastIdSupplier = $rowIdSupplier['id_supplier'];

        $id_letter = substr($lastIdSupplier, 0, 1);
        $id_num = intval(substr($lastIdSupplier, 1));
        $id_num++;
        $paddNum = str_pad($id_num, 6, '0', STR_PAD_LEFT);
        $id_supplier = $id_letter . $paddNum;
    } else {
        $id_supplier = "S000001";
    }

    $alamat = mysqli_escape_string($conn, $_POST['alamat']);
    $nama = mysqli_escape_string($conn, $_POST['nama']);
    $kota = mysqli_escape_string($conn, $_POST['kota']);
    $email = mysqli_escape_string($conn, $_POST['email']);
    $keterangan = mysqli_escape_string($conn, $_POST['keterangan']);
    $status_aktif = mysqli_escape_string($conn, $_POST['status']);
    $contact = mysqli_escape_string($conn, $_POST['contact']);

    $queryLogTambahSupplier = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
    mysqli_stmt_bind_param($queryLogTambahSupplier, "ssss", $no_transaksi, $action, $keteranganLog, $userid);

    $no_transaksi = $id_supplier;
    $action = "INSERT" ;
    $keteranganLog = $_SESSION['username'] . " menambahkan supplier  " . $nama;
    $userid = $_SESSION['id_user'];


    if (mysqli_stmt_execute($queryTambahSupplier)){
        mysqli_stmt_execute($queryLogTambahSupplier);
        mysqli_close($conn);
        header("location:../../index.php?content=supplier");
    } else {
        mysqli_stmt_close($queryTambahUser);
        mysqli_close($conn);
        header("location:../../index.php?content=supplier");
    }
}
} else {
    http_response_code(405);
}
?>