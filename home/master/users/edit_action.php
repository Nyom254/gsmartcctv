<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    if (!isset($_SESSION['status'])) {
        http_response_code(403);
        echo "Anda harus Login untuk mengakses resources ini";
    } else {
        require '../../../conn.php';


        if ($_POST['password'] === '') {
            $queryEditUser = mysqli_prepare($conn, "update user set nama = ?, username = ?, level = ?, status_aktif = ? where id_user = ? ");
            mysqli_stmt_bind_param($queryEditUser, "sssii", $nama, $username, $level, $status_aktif, $id_user);
        } else {
            $queryEditUser = mysqli_prepare($conn, "update user set nama = ?, username = ?, password = ?, level = ?, status_aktif = ? where id_user = ? ");
            mysqli_stmt_bind_param($queryEditUser, "ssssii", $nama, $username, $password, $level, $status_aktif, $id_user);
        }

        $nama = mysqli_escape_string($conn, $_POST['nama']);
        $username = mysqli_escape_string($conn, $_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $level = mysqli_escape_string($conn, $_POST['level']);
        $status_aktif = mysqli_escape_string($conn, $_POST['status']);

        $id_user = $_GET['id_user'];


        $queryLogEditUser = mysqli_prepare($conn, "insert into log_transaksi (NO_TRANSAKSI, ACTION, KETERANGAN, USERID) values (?, ?, ?, ?)");
        mysqli_stmt_bind_param($queryLogEditUser, "ssss", $no_transaksi, $action, $keterangan, $userid);

        $queryDataUserLama = mysqli_query($conn, "select * from user where id_user = '$id_user'");
        $rowDataUserLama = mysqli_fetch_assoc($queryDataUserLama);

        $editedGroup = array();

        if ($nama !== $rowDataUserLama['nama']) {
            $editedGroup[] = "nama user dari " . $rowDataUserLama['nama'] . " menjadi $nama";
        }
        if ($username !== $rowDataUserLama['username']) {
            $editedGroup[] = "username user dari " . $rowDataUserLama['username'] . " menjadi $username";
        }
        if ($password !== $rowDataUserLama['password']) {
            $editedGroup[] = "password user ";
        }
        if ($level !== $rowDataUserLama['level']) {
            $editedGroup[] = "level user dari " . $rowDataUserLama['level'] . " menjadi $level";
        }
        $keteranganLog = implode(', ', $editedGroup);


        $no_transaksi = $id_user;
        $action = "UPDATE";
        $keterangan = $_SESSION['username'] . " merubah " . $keteranganLog;
        $userid = $_SESSION['id_user'];

        if (mysqli_stmt_execute($queryEditUser)) {
            mysqli_stmt_execute($queryLogEditUser);
            mysqli_stmt_close($queryEditUser);
            mysqli_close($conn);
            header("location:../../index.php?content=users");
        } else {
            mysqli_stmt_close($queryEditUser);
            mysqli_close($conn);
            header("location:../../index.php?content=user");
        }
    }
} else {
    http_response_code(405);
}
