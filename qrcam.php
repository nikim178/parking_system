<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, autoRotate:disabled">
    <title>BookBarber</title>
    <link rel="apple-touch-icon" href="img/icon-96x96.png">
    <meta name="apple-mobile-web-app-status-bar" content="#F37736">
    <meta name="theme-color" content="#F37736">
    <link rel="shortcut icon" type="image/png" href="img/icon-72x72.png">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/instascan.min.js"></script>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#FFF27B">
    <link rel="apple-touch-icon" href="img/icon-96x96.png">
</head>
<body>
<div id="loader_bg">
        <div id="loader">

        </div>
    </div>
    <div>
        <video id="qrcam"></video>
        <h2 id="h2_scan">Scan Qr Code Here</h2>
    </div>
    <div id="home_buttons" style=" left: 23%;">
        <button class="home-buttons" id="myQRCode">
            <img style="width: 50%; height: 60%;" src="img/scan.png" /><br />
            <span class="button-text" style="font-weight: bold;">Scan</span>
        </button>
        <button class="home-buttons" onclick="all_bookings()" id="myBookings">
            <img style="width: 50%; height: 60%;" src="img/bookings.png" /><br />
            <span class="button-text" style="font-weight: bold;">All Bookings</span>
        </button>
    </div>
    <script src="js/home_fun.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        var qr = new Instascan.Scanner({
            video: document.getElementById('qrcam')
        });

        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia || msGetUserMedia || navigator.oGetUserMedia;

        if (navigator.getUserMedia) {
            Instascan.Camera.getCameras().then(function(cams) {
                qr.start(cams[0]);
            }).catch(function(err) {
                console.log(err);
                alert('please grant permission');
            });

            qr.addListener('scan', function(data) {
                window.location.href = "park_time.php?id=" + data;

            });  
        } else {
            alert('please grant permission');
        }

        function all_bookings(){
            window.location.href = "admin_home.php";
        }

        var btn = document.getElementById('myQRCode');

        btn.onclick = function() {
            window.location.href = "qrcam.php";
        }
    </script>
</body>

</html>