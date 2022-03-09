<?php
include 'connection.php';
include 'end.php';
session_start();

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql = "SELECT * FROM `customers` WHERE `username` = '$username' AND `password` = '$password'";
$result_sql = mysqli_query($conn, $sql);

if(mysqli_num_rows($result_sql) > 0){
    while($row = mysqli_fetch_assoc($result_sql)){
        $phone = $row['phone'];
        $cst_id = $row['id'];
    }

    setcookie("cst_id", $cst_id, time() + (86400 * 30), "/");

    echo "<script>
        window.location.href = 'index.php';
    </script>";
}else{
    echo "<script>
        alert('Invalid Credentials');
        history.back();
    </script>";
}




?>