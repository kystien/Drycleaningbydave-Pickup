<?
 /* Initialize the session */
session_start();

/* Load Config Data */
require_once "valet/src/config.php";

	/* ------------------- Mailer Data ---------------------- */
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;
	/* ------------ Initiate Mailer Class ------------------ */
	$mail = new PHPMailer();
	/* ------------------- Setup SMTP ------------------- */
	$mail->IsSMTP();                // Sets up a SMTP connection
	$mail->SMTPDebug  = 2;          // This will print debugging info
	$mail->SMTPAuth = true;         // Connection with the SMTP does require authorization
	$mail->SMTPSecure = "tls";      // Connect using a TLS connection
	$mail->Host = "smtp.mailgun.org";
	$mail->Encoding = "7bit";       // SMS uses 7-bit encoding
 	/* ------------------- Authenticate ------------------- */
	$mail->Username   = "postmaster@sandboxec2dd140d60648d28ded9010a2bc515a.mailgun.org"; // Login
	$mail->Password   = "f1401d7544755182e6e3e857b35a3def-bd350f28-a2b16b54"; // Password
	$mail->From = 'Pickups@DrycleaningbyDave.ca';
	$mail->FromName = 'Jeff Mills';
	
	/* ~~~ Form Submission Data ~~~ */	

	$corporate = trim($_POST["corporate"]);
    $public = trim($_POST["public"]);
	$admin = trim($_POST["admin"]);

	$firstname = trim($_POST["first"]);
	$lastname = trim($_POST["last"]);
	$address = trim($_POST["address"]);
	$city = trim($_POST["city"]);
	$phone = trim($_POST["phone"]);
	
	$staff = trim($_POST["staff"]);
	$valet = trim($_POST["valet"]);

	$name = $firstname . " " . $lastname;
	$addy = $address . " " . $city;

	/* ~~~ Public Submissions ~~~ */
	if($public == true){
			/* ~~~ Send Email ~~~ */
		try {
			//Content
			$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
			$mail->isHTML(true);	// Set email format to HTML
			$mail->Subject = "Pickup Request";
			$mail->Body    = $name . " has a pickup request. <br>Address: " . $addy . "<b>Pickup for </b>";
			$mail->AltBody = $name . " has a pickup request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
			$mail->send();
			echo "Message has been sent";
			/* Redirect to login page */
			header("location: welcome.php");
			exit;
		} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
		}
	}
	
	/* if($public == true && $city == "Banff"){ */
			/* ~~~ Send Email ~~~ */
	/*	try {
			//Content
			$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
			$mail->isHTML(true);	// Set email format to HTML
			$mail->Subject = "Pickup Request";
			$mail->Body    = $name . " has a pickup request. <br>Address: " . $addy . "<b>Pickup for </b>";
			$mail->AltBody = $name . " has a pickup request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
			$mail->send();
			echo "Message has been sent";
				/* Redirect to login page */
	/*		header("location: welcome.php");
			exit;
		} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
		}
	} */
		/* ~~~ Corporate Submissions ~~~ */
		/* ~~~ Staff Pickup Requests ~~~ */
	/*if($corporate == true && $city == "Canmore"){
		if($staff == true){ */
			/* ~~~ Send Email ~~~ */
	/*		try {
				//Content
				$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
				$mail->isHTML(true);	// Set email format to HTML
				$mail->Subject = "Hotel Pickup Request";
				$mail->Body    = $name . " has a pickup request. <br>Address: " . $addy . "<b>Pickup for </b>";
				$mail->AltBody = $name . " has a pickup request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
				$mail->send();
				echo "Message has been sent";
				/* Redirect to login page */
	/*			header("location: welcome.php");
				exit;
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
			}
		}
	} */
	if($corporate == true){
		if($staff == true){
			/* ~~~ Send Email ~~~ */
			try {
				//Content
				$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
				$mail->isHTML(true);	// Set email format to HTML
				$mail->Subject = "Hotel Pickup Request";
				$mail->Body    = $name . " has a pickup request. <br>Address: " . $addy . "<b>Pickup for </b>";
				$mail->AltBody = $name . " has a pickup request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
				$mail->send();
				echo "Message has been sent";
				/* Redirect to login page */
				header("location: welcome.php");
				exit;
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
			}
		}
	}
		/* ~~~ Hotel Guest Valet Requests ~~~ */
	if($corporate == true){
		if($valet == true){
			/* ~~~ Send Email ~~~ */
			try {
				//Content
				$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
				$mail->isHTML(true);	// Set email format to HTML
				$mail->Subject = "Hotel Pickup Request";
				$mail->Body    = $name . " has a guest valet request. <br>Address: " . $addy . "<b>Pickup for </b>";
				$mail->AltBody = $name . " has a guest valet request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
				$mail->send();
				echo "Message has been sent";
				/* Redirect to login page */
				header("location: welcome.php");
				exit;
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
			}
		}
	}
	/* if($corporate == true && $city == "Banff"){
		if($valet == true){ */
			/* ~~~ Send Email ~~~ */
	/*		try {
				//Content
				$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
				$mail->isHTML(true);	// Set email format to HTML
				$mail->Subject = "Hotel Pickup Request";
				$mail->Body    = $name . " has a guest valet request. <br>Address: " . $addy . "<b>Pickup for </b>";
				$mail->AltBody = $name . " has a guest valet request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
				$mail->send();
				echo "Message has been sent";
				/* Redirect to login page */
	/*			header("location: welcome.php");
				exit;
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
			}
		}
	} */
	if($admin == true){
		if($valet == true){
			/* ~~~ Send Email ~~~ */
			try {
				//Content
				$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
				$mail->isHTML(true);	// Set email format to HTML
				$mail->Subject = "Test Hotel Pickup Request";
				$mail->Body    = $name . " has a guest valet request. <br>Address: " . $addy . "<b>Pickup for </b>";
				$mail->AltBody = $name . " has a guest valet request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
				$mail->send();
				echo "Message has been sent";
				/* Redirect to login page */
				header("location: welcome.php");
				exit;
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
			}
		}
		if($staff == true){
			/* ~~~ Send Email ~~~ */
			try {
				//Content
				$mail->AddAddress = "4036091161@msg.telus.com"; // Where to send it
				$mail->isHTML(true);	// Set email format to HTML
				$mail->Subject = "Test Staff Hotel Pickup Request";
				$mail->Body    = $name . " has a staff pickup request. <br>Address: " . $addy . "<b>Pickup for </b>";
				$mail->AltBody = $name . " has a staff pickup request." . \r\n . "Address: " . $addy . " Pickup for ";
			 
				$mail->send();
				echo "Message has been sent";
				/* Redirect to login page */
				header("location: welcome.php");
				exit;
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: ", $mail->ErrorInfo;
			}
		}
	}
?>