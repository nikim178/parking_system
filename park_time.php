<?php
    include 'connection.php';
// $cst_id = 15;
$admin_id = $_COOKIE['admin_id'];
$location_id = 2;
    $cst_id = $_REQUEST['id'];
    $sql = "SELECT * FROM `customers` WHERE `id` = $cst_id";
    $result_sql = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result_sql) > 0){
        while($row = mysqli_fetch_assoc($result_sql)){
            $cst_name = $row['name'];
            $phone_no = $row['phone'];
            $unique_park_id = $row['unique_park_id'];
            $sql6 = "SELECT * FROM `parking_log` WHERE `unique_park_id` = '$unique_park_id'";
            $result_sql6 = mysqli_query($conn, $sql6);
            while($row2 = mysqli_fetch_assoc($result_sql6)){
                $in_timestamp = $row2['in_timestamp'];
            }
        }
    }

    $sql8 = "SELECT * FROM `admin` WHERE `id` = $admin_id";
    $result_sql8 = mysqli_query($conn, $sql8);

    if(mysqli_num_rows($result_sql8) > 0){
        while($row8 = mysqli_fetch_assoc($result_sql8)){
            $admin_name = $row8['name'];
        }
    }

    $sql7 = "SELECT * FROM `parking_locations` WHERE `id` = $location_id";
    $result_sql7 = mysqli_query($conn, $sql7);

    if(mysqli_num_rows($result_sql7) > 0){
        while($row7 = mysqli_fetch_assoc($result_sql7)){
            $price_per_hour = $row7['price_per_hour'];
        }
    }

    if($unique_park_id == ""){
        $in_timestamp = time();
        $unique_park_id = uniqid();
    }else{
        $out_timestamp = time();
        $total_time = $out_timestamp - $in_timestamp;
        if($total_time < 3600){
            $price = $price_per_hour;
        }else{
            $price = $price_per_hour * (floor($total_time/3600) + 1);
        }

        $sql2 = "UPDATE `parking_log` SET `out_timestamp` = '$out_timestamp', `total_time_seconds` = $total_time, `price` = $price WHERE `unique_park_id` = '$unique_park_id'";
        $sql5 = "UPDATE `customers` SET `unique_park_id` = NULL WHERE `id` = $cst_id";
        $result_sql2 = mysqli_query($conn, $sql2);
        $result_sql5 = mysqli_query($conn, $sql5);
        echo "<script>
        alert('Exit registered');
            window.location.href = 'qrcam.php';
        </script>";
        die();
    }
    
    


    

    $sql3 = "INSERT INTO `parking_log`(`admin_id`, `admin_name`, `cst_id`, `cst_name`, `unique_park_id`, `in_timestamp`) VALUES ($admin_id,'$admin_name',$cst_id,'$cst_name','$unique_park_id','$in_timestamp')";
    $sql4 = "UPDATE `customers` SET `unique_park_id` = '$unique_park_id' WHERE `id` = $cst_id";

    $result_sql3 = mysqli_query($conn, $sql3);
    $result_sql4 = mysqli_query($conn, $sql4);

    echo "<script>
        alert('Entry registered');
        window.location.href = 'qrcam.php';
    </script>";

?>