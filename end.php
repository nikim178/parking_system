<?php

function doEncrypt($encrypt,$task)
{


$function = $task;


$ciphering = "AES-128-CTR"; 

$simple_string = $encrypt;
$encryption = $encrypt;


$ciphering = "AES-128-CTR";  

$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 
 
$encryption_iv = '1234567891011121'; 

$encryption_key = "password_validation"; 
  

if($function == "e")
{

	$encryption = openssl_encrypt($simple_string, $ciphering, 
            $encryption_key, $options, $encryption_iv); 

	return $encryption;

}

$iv_length = openssl_cipher_iv_length($ciphering); 
$options = 0; 
				  
$encryption_iv = '1234567891011121'; 
				  
$encryption_key = "password_validation"; 
				  
$decryption_iv = '1234567891011121'; 
				  
$decryption_key = "password_validation"; 
	
if($function == "d")
	{

		$decryption=openssl_decrypt ($encryption, $ciphering,  
						$decryption_key, $options, $decryption_iv);

		return $decryption;
	}

}




?>