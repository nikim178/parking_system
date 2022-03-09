<?php
ob_start();
session_start();
include "end.php";
include "connection.php";
include "sms.php";


if (isset($_REQUEST["phone_no"])) {
	$phone_no =  mysqli_escape_string($conn, $_REQUEST["phone_no"]);
	$otp = rand(1000, 9999);
	$_SESSION['otp_sent_time'] = 0;

	$name = $_REQUEST['name'];
	$email = $_REQUEST['email'];
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	$c_password = $_REQUEST['c_password'];

	if($password != $c_password){
		echo "<script>
			alert('Password didn't match');
			history.back();
		</script>";
	}

	$sql2 = "SELECT * FROM `customers` WHERE `username` = '$username'";
	$result_sql2 = mysqli_query($conn, $sql2);

	if(mysqli_num_rows($result_sql2) > 0){
		echo "<script>
			alert('Username already taken');
			history.back();
		</script>";
	}

} else if (strlen($_SERVER['QUERY_STRING']) > 0) {
	
	$decrypted = doEncrypt($_SERVER['QUERY_STRING'], "d");
	parse_str($decrypted, $output);

	if (isset($output['phone_no'])) {
		$phone_no = $output['phone_no'];

		if(isset($output['name'])){
			$name = $output['name'];
			$email = $output['email'];
			$username = $output['username'];
			$password = $output['password'];
			$c_password = $output['c_password'];
		}

		if ($_SESSION['otp_sent_time'] + 30 < time()) {
			$otp = rand(1000, 9999);
			sms($phone_no, $otp);
			// echo $otp;
			$_SESSION['otp_sent_time'] = time();
			$_SESSION['otp_sent_number'] = $phone_no;
			$_SESSION['last_otp_sent'] = $otp;
			echo "<script>
							alert('New OTP Sent');
						</script>";
		} else {
			$otp = $_SESSION['last_otp_sent'];
			echo "<script>
									alert('Wait for while you will get SMS');
								</script>";
		}
	} else {
		echo "<script>
				window.location.href='index.php';
				</script>";

		die();
	}
}else{
	echo 	"<script>
				window.location.href='index.php';
				</script>";

		die();
}








if ($_SESSION['otp_sent_time'] + 30 < time()) {
	$otp = rand(1000, 9999);
	sms($phone_no, $otp);
	$_SESSION['otp_sent_time'] = time();
	$_SESSION['otp_sent_number'] = $phone_no;
	$_SESSION['last_otp_sent'] = $otp;
} else {
	$otp = $_SESSION['last_otp_sent'];
}
			
		
	



if(isset($name)){
	$secure_query = "phone_no=" . $phone_no . "&name=" . $name . "&email=" . $email . "&username=" . $username . "&password=" . $password . "&c_password=" . $c_password;
	$encrypted = doEncrypt($secure_query, "e");

	$secure_otp = "phone_no=" . $phone_no . "&name=" . $name . "&email=" . $email . "&username=" . $username . "&password=" . $password . "&c_password=" . $c_password . "&otp=" . $otp;
	$encrypted_otp = doEncrypt($secure_otp, "e");
}




?>


<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, autoRotate:disabled">
	<title>Project Shop</title>
	<link rel="stylesheet" href="css/home.css">
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#FFF27B">
    <link rel="apple-touch-icon" href="img/icon-96x96.png">
	<style>
        #otp{
            height: 7%;
            margin-top: 5%;
            font-family: roboto;
        }
		h2{
            font-family: montserrat;
            color: #001359;
            text-align: center;
            margin-top: 3%;
        }
    </style>
</head>

<body id="body1">
	

    <div id="main">
	<h2 style="margin-top: 35vh; display: inline-block;">Smart Parking</h2><br>
            <form action="votpc.php" name="otpverify" method="POST" onsubmit="return validateform(this);">
                <input type="number" name="otp" id="phone" class="input_login" placeholder="ENTER OTP" required>
                <input type="hidden" name="phone_n" value="<?php echo $phone_no; ?>">
                <input type="hidden" name="encrypted_otp" value="<?php echo $encrypted_otp; ?>">

                <br>
			    <a href="sotpc.php?<?php echo $encrypted; ?>" style="margin-left: 40vw; color: black;" id="resend">Resend OTP?</a>
			    <br>
                <input type="submit" style="width: 40%; padding: 0; margin-left: 30%; background-color: #232323; color: white;" onclick="post_values()" id="login-btn" class="input" value="Submit">
            </form>
    </div>
</body>

</html>


<script>
	let timerOn = true;

	function timer(remaining) {
		var m = Math.floor(remaining / 60);
		var s = remaining % 60;

		m = m < 10 ? '0' + m : m;
		s = s < 10 ? '0' + s : s;

		remaining -= 1;

		if (remaining >= 0 && timerOn) {
			setTimeout(function() {
				timer(remaining);
			}, 1000);
			return;
		}

		if (!timerOn) {
			// Do validate stuff here
			return;
		}

		// Do timeout stuff here

		// window.location.href = 'index.php';
	}

	timer(30);
</script>




<script>
    var modal = document.getElementById("myModal");
        var ulClass = document.getElementById("ul-class");       
        var pointer = 1;
        var bg = document.getElementById("main");
        // bg.style.backgroundImage = "url('img/bg1.png')";
        var interval = setInterval(function(){ change_slide(1); }, 4000);
        var main_h1 = document.getElementById("home_main1_h1");
        var projects_btn1 = document.getElementById("projects-btn1");
        var projects_btn2 = document.getElementById("projects-btn2");
    function change_slide(num){
            pointer+=num;            
            if(pointer > 2){
                pointer = 1;
            }else if(pointer < 1){
                pointer = 2;
            }
            
            bg.style.backgroundImage = "url('img/bg"+pointer+".png')";
        }
	function validateform() {

		var userotp = document.otpverify.otp.value;
		var encrypted_otp = document.otpverify.encrypted_otp.value;
		var actualotp = <?php echo $otp; ?>;

		if (userotp == actualotp) {
			window.location.href = 'votpc.php?' + encrypted_otp;
			return false;
		} else {
			var attempt2 = window.prompt("You entered wrong OTP. Try Again! ");

			if (attempt2 == actualotp) {
				window.location.href = 'votpc.php?' + encrypted_otp;
				return false;

			} else {
				var attempt3 = window.prompt("You entered wrong OTP. Last Attempt! ");

				if (attempt3 == actualotp) {
					window.location.href = 'votpc.php?' + encrypted_otp;
					return false;

				} else {
					alert("Attempt limit exceeded")
					window.location.href = 'index.php';
					return false;
				}

			}

		}


	}
</script>