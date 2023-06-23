<?php
include "../conn.php";
session_start();


$queryUser = mysqli_prepare($conn, "select * from user where username = ? and password = ?");
mysqli_stmt_bind_param($queryUser, "ss", $username, $password);

$username = mysqli_escape_string($conn, $_POST['username']);
$password = mysqli_escape_string($conn, $_POST['password']);

mysqli_stmt_execute($queryUser);

$dataUser = mysqli_stmt_get_result($queryUser);
$cekDataUser = $dataUser->num_rows;

if ($cekDataUser > 0) {
    $rowUser = mysqli_fetch_assoc($dataUser);
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
