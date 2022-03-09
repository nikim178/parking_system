<?php
$user = "root";
$db = "parking";
$password = "";
$server = "localhost";

$conn = mysqli_connect($server,$user,$password,$db);
if(!$conn)
{
	echo "connection error";
	die();
}
else
{
    
}

date_default_timezone_set('Asia/Calcutta'); 

?>





