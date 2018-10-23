<?php
	/* ------------------- PDO Login Information ------------------- */	
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', ' ');
	define('DB_PASSWORD', ' ');
	define('DB_NAME', ' ');
	/* ------------------- PDO connect to database ------------------- */
	try{
		$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    	// Set the PDO error mode to exception
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e){
		die("ERROR: Could not connect. " . $e->getMessage());
	}
	/* ------------------- Include Mailer ---------------------- */
	require "valet/src/mailer/Exception.php";
	require "valet/src/mailer/PHPMailer.php";
	require "valet/src/mailer/SMTP.php";
?>