<?php
include 'connection.php';
include 'end.php';
session_start();


$password = $_REQUEST['password'];

$sql = "SELECT * FROM `admin` WHERE `password` = '$password'";
$result_sql = mysqli_query($conn, $sql);

if(mysqli_num_rows($result_sql) > 0){
    while($row = mysqli_fetch_assoc($result_sql)){
        $phone = $row['phone'];
        $admin_id = $row['id'];
    }

    setcookie("admin_id", $admin_id, time() + (86400 * 30), "/");

    echo "<script>
        window.location.href = 'admin_home.php';
    </script>";
}else{
    echo "<script>
        alert('Incorrect Password');
        history.back();
    </script>";
}




?>