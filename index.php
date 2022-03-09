<?php
    include 'connection.php';
    include 'end.php';
    include 'getlocation.php';
    session_start();

    $login = 0;
    if(isset($_COOKIE['cst_id'])){
        $cst_id = $_COOKIE['cst_id'];
        $login = 1;
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
        <?php
            if($login == 0){
                ?>
                        <a href="login.php" id="login_a">Login</a>
                <?php
            }else{
                ?>
                <a href="logout.php" id="login_a">Logout</a>
                <?php
            }
        ?>
    </div>
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div style="pointer-events: none;" id="qr_div"></div>
        </div>

    </div>
    <!-- <div id="search_div">
        <input type="text" name="search" class="search" autocomplete="off" id="search" onkeypress="keypress(event, this)" placeholder="Search your Destination" value="">
        <div class="result"></div>
    </div> -->
    <div id="result_main_div">
        <?php
            for($count = 0; $count < $num_locations; $count++){
        ?>
        <div id="result_sub_div" style="height: auto;">
            <h2><?php echo $name[$count]; ?></h2>
            <h4><?php echo $address[$count]; ?></h4>
            <h4>Distance:- <?php echo sprintf("%01.1f", $distance[$count]); ?> Km</h4>
            <button id="locate" onclick="openMaps(<?php echo $lat[$count]; ?>,<?php echo $long[$count]; ?>)">Locate on map</button><hr style="width: 100%; margin-left: 0;">
        </div>
        <?php
            }
        ?>
    </div>
    
    <?php
        if($login == 1){
    ?>
    <div id="home_buttons">
        <button class="home-buttons" onclick="locations()" id="saved">
            <img style="width: 50%; height: 60%;" src="img/locations.png" /><br />
            <span class="button-text" style="font-weight: bold;">Home</span>
        </button>
        <button class="home-buttons" id="myQRCode">
            <img style="width: 50%; height: 60%;" src="img/qrcode.png" /><br />
            <span class="button-text" style="font-weight: bold;">My QR</span>
        </button>
        <button class="home-buttons" onclick="my_bookings()" id="myBookings">
            <img style="width: 50%; height: 60%;" src="img/bookings.png" /><br />
            <span class="button-text" style="font-weight: bold;">My Bookings</span>
        </button>
    </div>
    <?php
        }
    ?>
    <script src="js/app.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/qrcode.min.js"></script>
    <script src="js/home_fun.js"></script>
    <script>
document.onclick = function() {
            if (document.querySelector('.search') === document.activeElement) {
                document.querySelector('.result').style.display = "block";
                document.body.style.background = "rgba(0,0,0,0.2)";
                document.body.style.overflow = "hidden";
            } else {
                document.querySelector('.result').style.display = "none";
                document.body.style.background = "rgba(0,0,0,0)";
                document.body.style.overflow = "scroll";
            }
        }
        

        function keypress(e, text){
            var code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) { //Enter keycode
                alert("Select from auto suggestion");
            }
        }
        $(document).ready(function() {
            $('#search').on("keyup input", function() {
                /* Get input value on change */
                var inputVal = $(this).val();
                var resultDropdown = $(this).siblings(".result");
                if (inputVal.length) {
                    $.get("get_parking_location.php", {
                        term: inputVal
                    }).done(function(data) {
                        // Display the returned data in browser

                        resultDropdown.html(data);
                    });
                } else {
                    resultDropdown.empty();
                }
            });

            // Set search input value on click of result item
            $(document).on("click", ".result p", function() {
                $(this).parents("#search").val($(this).text());
                $(this).parent(".result").empty();
                inputVal = $(this).text();
                project_details(inputVal);
            }); 
        });
        var phone_number = getCookie('cst_id');
        var modal = document.getElementById("myModal");
        var display = false;
        var btn = document.getElementById('myQRCode');

        btn.onclick = function() {
            modal.style.display = "block";
            if (!display) {
                var qr_data = phone_number;

                var qr_div = new QRCode(document.getElementById('qr_div'), {
                    width: 200,
                    height: 200
                });
                qr_div.makeCode(qr_data);
                display = true;
                console.log(qr_data);
            }
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(showPosition);
            } else { 
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude =  position.coords.longitude;

            $.post("algo.php", {lat: latitude, long: longitude});
        }

        getLocation();

        function my_bookings(){
            window.location.href = "my_bookings.php";
        }

        function locations(){
            window.location.href = "index.php";
        }

        function openMaps(lat, long) {
            window.open("https://www.google.com/maps?z=12&t=m&q=loc:" + lat + "+" + long);
        }
    </script>
</body>
</html>