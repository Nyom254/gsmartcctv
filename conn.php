<?php 
ini_set('display_errors', 'on'); 
error_reporting(E_ALL); 

    $conn = mysqli_connect("localhost","root","","cctv");
    if(!$conn) {
        echo "failed connect to database: " . mysqli_connect_error();
    };
?>