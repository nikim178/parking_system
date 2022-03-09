<?php
    include 'connection.php';
    include 'end.php';
    session_start();

    $login = 0;
    $admin_login = 0;
    if(isset($_COOKIE['cst_id'])){
        $cst_id = $_COOKIE['cst_id'];
        $login = 1;
    }

    if(isset($_COOKIE['admin_id'])){
        $admin_id = $_COOKIE['admin_id'];
        $admin_login = 1;
    }

    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Parking</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#FFF27B">
    <link rel="apple-touch-icon" href="img/icon-96x96.png">
</head>
<body>
    <div>
    <div id="navbar">
        <h2 id="project_title">Smart Parking</h2>
    </div>
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div style="pointer-events: none;" id="qr_div"></div>
        </div>

    </div>
    <div id="result_main_div" style="height: 75vh;">
        <?php
        $sql1 = "SELECT * FROM `parking_log` WHERE `admin_id` = $admin_id";
        $result_sql1 = mysqli_query($conn, $sql1);
        if(mysqli_num_rows($result_sql1) > 0){
            while($row1 = mysqli_fetch_assoc($result_sql1)){
                $cst_name = $row1['cst_name'];
                $unique_park_id = $row1['unique_park_id'];
                $in_timestamp = $row1['in_timestamp'];
                $out_timestamp = $row1['out_timestamp'];
                $total_price = $row1['price'];

                $in_date = date('d/m/Y', $in_timestamp);
                $out_date = date('d/m/Y', $out_timestamp);
                $in_time = date('H:i:s', $in_timestamp);
                $out_time = date('H:i:s', $out_timestamp);
        ?>
        <div id="result_sub_div" style="height: 20vh;">
            <h2>Name:- <?php echo $cst_name; ?></h2>
            <h4>Parking Id:- <?php echo $unique_park_id; ?></h4>
            <h4>Date:- <?php echo $in_date . " - ". $out_date; ?></h4>
            <h4>Time:- <?php echo $in_time . " - ". $out_time; ?></h4>
            <h4>Price:- Rs <?php echo $total_price; ?></h4>
        </div><hr>
        <?php
            }
        }
        ?>
    </div>
    
    <?php
        if($admin_login == 1){
    ?>
    <div id="home_buttons" style=" left: 23%;">
        <button class="home-buttons" id="myQRCode" onclick="scan()">
            <img style="width: 50%; height: 60%;" src="img/scan.png" /><br />
            <span class="button-text" style="font-weight: bold;">Scan</span>
        </button>
        <button class="home-buttons" onclick="all_bookings()" id="myBookings">
            <img style="width: 50%; height: 60%;" src="img/bookings.png" /><br />
            <span class="button-text" style="font-weight: bold;">All Bookings</span>
        </button>
    </div>
    <?php
        }
    ?>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/qrcode.min.js"></script>
    <script src="js/home_fun.js"></script>
    <script>

        function scan() {
            window.location.href = "qrcam.php";
        }

        function all_bookings(){
            window.location.href = "admin_home.php";
        }
    </script>
</body>
</html>