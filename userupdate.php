<?php
	// Initialize the session
	session_start();

	date_default_timezone_set('America/Edmonton');
	$currentday = date('D');
	$currenttime = date('g:i A');
	$targettime = "10:00 AM";
	$nopickup = array("Sat", "Sun");
	$manager1 = "Candice.Mills";
	$manager2 = "Jeff.Mills";
	$fedit = " ";
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	  	header("location: login.php");
  	exit;
	}

	require_once "valet/src/config.php";

	$user = htmlspecialchars($_SESSION["username"]);
	$param_user = htmlspecialchars($_SESSION["username"]);
	$upull = $pdo->prepare("SELECT * FROM users WHERE username = :username");
	$upull->bindParam(":username", $param_user, PDO::PARAM_STR);
	$upull->execute();

	foreach($upull as $row){
			$corporate = $row["Corporate"];
			$public = $row["Public"];
			$admin = $row["Admin"];
			$first = $row["First"];
			$last = $row["Last"];
			$town = $row["City"];
			$address = $row["Address"];
			$phone = $row["phone"];
			$fullname = $first . " " . $last;
	}
	
	/* Update user data */
	$param_id = $_SESSION["id"];
	if($_SERVER["REQUEST_METHOD"] == "POST"){
			// Validate name
		if(empty(trim($_POST["first"]))){
			$name_err = "Please type a firstname.";   
		} else{
			$param_first = trim($_POST["first"]);
		}
		if(empty(trim($_POST["last"]))){
			$name_err = "Please type a lastname.";   
		} else{
			$param_last = trim($_POST["last"]);
		}
			// Validate city
    	if(empty(trim($_POST["town"]))){
        	$city_err = "Please type a city.";     
    	} else{
        	$city = trim($_POST["town"]);
    	}
			// Validate address
		if(empty(trim($_POST["address"]))){
			$address_err = "Please input an address for delivery.";   
		} else{
			$param_address = trim($_POST["address"]);
		}
			// Validate phone
		if(empty(trim($_POST["phone"]))){
			$phone_err = "Please input a contact number.";   
		} else{
			$param_phone = trim($_POST["phone"]);
		}
	
	$uupdate = $pdo->prepare("UPDATE users SET First=:first, Last=:last, City=:city, phone=:phone, Address=:address WHERE id = :id");
		$uupdate->bindParam(":id", $param_id, PDO::PARAM_INT);
		$uupdate->bindParam(":first", $param_first, PDO::PARAM_STR);
		$uupdate->bindParam(":last", $param_last, PDO::PARAM_STR);
		$uupdate->bindParam(":city", $city, PDO::PARAM_STR);
		$uupdate->bindParam(":address", $param_address, PDO::PARAM_STR);
		$uupdate->bindParam(":phone", $param_phone, PDO::PARAM_STR);
		
	
		if($uupdate->execute()){
                // account updated successfully
			header("location: welcome.php");
			exit();
		} else{
			echo "Oops! Something went wrong. Please try again later.";
		}
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome <? echo $fullname; ?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
  <style type="text/css">
    body{ font: 14px sans-serif; text-align: center; }
		.btn-success{ 
			background-color: #D9531E !important;
			border-color: #D9531E !important; 
		}
		.custdata{
			width: 400px;
		}
  </style>
</head>
<body>
	<center><img src="valet/images/logo.png"></center>
	<div class="page-header">
		<h1>Contact Update</h1>
	</div>
	<center><img src="valet/images/truck.png"></center>
	<div class="container">
		<hr>
		<center><div class="custdata">
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="namesec">
				<div class="form-inline" align="left">
					<label>Name: &nbsp;&nbsp;&nbsp;</label>
					<input type="text" name="first" class="form-control" value="<?php echo $first; ?>" size="15">
					<input type="text" name="last" class="form-control" value="<?php echo $last; ?>" size="15">
					<span class="help-block"><?php echo $name_err; ?></span>
				</div>
			</div>
			<div class="form-inline <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>" align="left">
				<label>Address: </label>
				<input type="text" name="address" class="form-control" value="<?php echo $address; ?>" size="40">
				<span class="help-block"><?php echo $address_err; ?></span>
			</div>
			<div class="form-inline <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>" align="left">
				<label>City: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
				<input type="text" name="town" class="form-control" value="<?php echo $town; ?>" size="15">
				<span class="help-block"><?php echo $city_err; ?></span>
			</div>
			<div class="form-inline <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>" align="left">
				<label>Contact: &nbsp;</label>
				<input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" size="15">
				<span class="help-block"><?php echo $phone_err; ?></span>
			</div>
			<div class="form-group" align="right">
				<input type="submit" class="btn btn-default" value="submit"> <a href="reset-password.php" class="btn btn-warning">Change Password</a>
			</div>
		</form>
		</div></center>
		<hr>
	</div>
</body>
</html>