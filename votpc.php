<?php
    ob_start();
    session_start();
	include "connection.php";
	include "end.php";


	if(strlen($_SERVER['QUERY_STRING']) == 0)
	{
		if(!isset($_REQUEST["otp"]))
		{
			echo "<script>
				alert('Login Please');
				window.location.href='index.php';
				</script>";

		}else
		{
			$user_otp =  $_REQUEST["otp"];
			
		}
	}else
		{
			$otp_decrypted = doEncrypt($_SERVER['QUERY_STRING'],"d");
			parse_str ($otp_decrypted,$output);

			$otp = $output['otp'];
			$phone_no = $output['phone_no'];
			
			if(isset($output['name'])){
				$name = $output['name'];
				$email = $output['email'];
				$username = $output['username'];
				$password = $output['password'];
				$c_password = $output['c_password'];
			}

	}

	if(isset($_SESSION['otp_sent_time'])  && isset($_SESSION['otp_sent_number']) && isset($_SESSION['last_otp_sent']))
	{
		if($_SESSION['last_otp_sent'] == $otp)
		{
			if($_SESSION['otp_sent_time'] + 30 > time())
			{	
				$last_otp_time = time();
				$sql = "SELECT `id` FROM `customers` WHERE `phone` = '$phone_no'";
				$result = mysqli_query($conn, $sql);
			    if(mysqli_num_rows($result) == 0)
	   			{	
					if(isset($name)){
						$sql2 = "INSERT INTO `customers` (`phone`, `name`, `email`, `username`, `password`) VALUES ('$phone_no', '$name', '$email', '$username', '$password')";				
					}else{
						$sql2 = "INSERT INTO `customers` (`phone`) VALUES ('$phone_no')";	
					}
					
					$result2 = mysqli_query($conn, $sql2);

					echo "<script>
						window.location.href = 'index.php';
					</script>";


				}else
				{
					echo "<script>
					alert('This number is already registerd');
						window.location.href = 'index.php';
					</script>";
				}

						unset($_SESSION['otp_sent_time']);
						unset($_SESSION['otp_sent_number']);
						unset($_SESSION['last_otp_sent']);
                        
						echo "<script>
							alert('OTP is verified');
							window.location.href='index.php';
							</script>";
						
						die();
					
				

			}else
			{
				echo "<script>
					alert('You are timed Out');
					window.location.href='index.php';
					</script>";
				
				die();
			}
		}else
		{
			echo "<script>
					alert('Invalid OTP');
					window.location.href='index.php';
					</script>";

		}

	}else
	{
			echo "<script>
					alert('Something Went Wrong');
					window.location.href='index.php';
					</script>";

	}
