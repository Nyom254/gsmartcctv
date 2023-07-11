<?php
include "../conn.php";
session_start();


$queryUser = mysqli_prepare($conn, "select * from user where username = ? and status_aktif = 1");
mysqli_stmt_bind_param($queryUser, "s", $username);

$username = mysqli_escape_string($conn, $_POST['username']);
$password = $_POST['password'];
mysqli_stmt_execute($queryUser);

$dataUser = mysqli_stmt_get_result($queryUser);
$cekDataUser = $dataUser->num_rows;
$rowUser = mysqli_fetch_assoc($dataUser);

if ($cekDataUser > 0) {
    if (password_verify($password, $rowUser['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['id_user'] = $rowUser['id_user'];
        if ($rowUser['level'] == '1') {
            $_SESSION['status'] = "master_login";
            header("location:../home/index.php");
        } else if ($rowUser['level'] == '0') {
            $_SESSION['status'] = "user_login";
            header("location:../home/index.php");
        }
    } else {
        header("location:./login_page.php?m=gagal");
    }
} else {
    header("location:./login_page.php?m=gagal");
}
