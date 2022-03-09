<?php
    include 'connection.php';

    $sql = "SELECT * FROM `parking_locations` WHERE 1 ORDER BY `distance` ASC";
    $result_sql = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result_sql) > 0){
        $num_locations = mysqli_num_rows($result_sql);
        $i = 0;
        while($row = mysqli_fetch_assoc($result_sql)){
            $name[$i] = $row['location_name'];
            $address[$i] = $row['location_address'];
            $lat[$i] = $row['lat'];
            $long[$i] = $row['long'];
            $distance[$i] = $row['distance'];
            $i++;
        }
    }
    
?>