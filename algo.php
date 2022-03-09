
<?php

include "connection.php";

$end_lat =  $_REQUEST['lat'];
$end_long =  $_REQUEST['long'];

// $end_lat = 21.1458004;
// $end_long = 79.0881546;

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
  if (($lat1 == $lat2) && ($lon1 == $lon2)) {
    return 0;
  }
  else {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
      return ($miles * 1.609344);
    } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
      return $miles;
    }
  }
}


$a1 = "SELECT * FROM `parking_locations`";
$res1=mysqli_query($conn,$a1);

$count = 1;

while($row4=mysqli_fetch_assoc($res1))
{
$start_lat = $row4['lat'];
$start_lang = $row4['long'];

$distance =distance($start_lat, $start_lang, $end_lat, $end_long, "K");

$sql = "UPDATE `parking_locations` SET `distance`= $distance where id = '$count' ";
mysqli_query($conn,$sql);

++$count;
}


// $sql1 = "SELECT MIN(distance) FROM `parking_locations`";
// $min_distance = mysqli_query($conn,$sql1);
// while($row1=mysqli_fetch_assoc($min_distance))
// {
// $number = $row1['number'];
// }


?>