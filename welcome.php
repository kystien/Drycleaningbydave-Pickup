<?php
	// Initialize the session
	session_start();

	date_default_timezone_set('America/Edmonton');
	$currentday = date('D');
	$currenttime = date('g:i A');
	$targettime = "10:00 AM";
	$nopickup = array("Fri", "Sat", "Sun");
	$manager1 = "Candice.Mills";
	$manager2 = "Jeff.Mills";
	$fri = "Fri";
	$sat = "Sat";
	$sun = "Sun";
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    	header("location: login.php");
    	exit;
	}

	require_once "valet/src/config.php";

	$user = htmlspecialchars($_SESSION["username"]);
	$param_id = $_SESSION["id"];
	$upull = $pdo->prepare("SELECT id, username, First, Last, City, Address, phone, Corporate, Public, Admin FROM users WHERE id = :id");
	$upull->bindParam(":id", $param_id, PDO::PARAM_INT);
	$upull->execute();

	foreach($upull as $row){
			$first = $row["First"];
			$last = $row["Last"];
			$town = $row["City"];
			$address = $row["Address"];
			$phone = $row["phone"];
			$corporate = $row["Corporate"];
			$public = $row["Public"];
			$admin = $row["Admin"];
			$fullname = $first . " " . $last;
	}
	/* Schedual a pickup */
	if($_SERVER["REQUEST_METHOD"] == "POST"){
			// Validate name
			$param_name = $fullname;
			$city = $town;
			$param_address = $address;
			$param_phone = $phone;
			if($corporate == true){
				if($staff == true){
					$type = "Business - Staff";
				}
				if($valet == true){
					$type = "Business - Valet";
				}
			}elseif($public == true){
				$type = "Public";
			}else{
				if($staff == true){
					$type = "Administrator - Test - Business - Staff";
				}
				if($valet == true){
					$type = "Administrator - Test - Business - Valet";
				}
			}
			if (date('H') >= 9 && !in_array($currentday, $nopickup)){
				/* ~~~ Prompt that it is after 9am & schedualed for the next day ~~~ */
				date('d-m-Y', strtotime('+1 day', $param_pickupd));
			}elseif (date('H') >= 9 && in_array($currentday, $nopickup)){
				/* ~~~ Prompt that no pickups occure due to the time & schedual for next business day ~~~ */
					if($currentday == $fri){
						date('d-m-Y', strtotime('+3 day', $param_pickupd));
					}
				/* ~~~ Prompt that no pickups occure on this day & schedual for next business day ~~~ */
					if($currentday == $sat){
						date('d-m-Y', strtotime('+2 day', $param_pickupd));
					}
				/* ~~~ Prompt that no pickups occure on this day & schedual for next business day ~~~ */
					if($currentday == $sun){
						date('d-m-Y', strtotime('+1 day', $param_pickupd));
					}
				/* ~~~ Prompt pickup for the day is schedualed ~~~ */
			}elseif (date('H') <= 9 && in_array($currentday, $nopickup)){
				/* ~~~ Prompt pickup for the day is schedualed ~~~ */
					if($currentday == "Fri"){
						$param_pickupd = $currentday;
					}
				/* ~~~ Prompt that no pickups occure on this day & schedual for next business day ~~~ */
					if($currentday == "Sat"){
						date('d-m-Y', strtotime('+2 day', $param_pickupd));
					}
				/* ~~~ Prompt that no pickups occure on this day & schedual for next business day ~~~ */
					if($currentday == "Sun"){
						date('d-m-Y', strtotime('+1 day', $param_pickupd));
					}
			}else{
				/* ~~~ Prompt pickup for the day is schedualed ~~~ */
				$param_pickupd = $currentday;
			}
			
		$schedpickup = $pdo->prepare("INSERT INTO pickups (username, Name, Address, City, phone, type, pickup_date) VALUES (:username, :name, :address, :city, :phone, :type, :pickupd)";
			$schedpickup->bindParam(":username", $user, PDO::PARAM_STR);
			$schedpickup->bindParam(":name", $param_name, PDO::PARAM_STR);
			$schedpickup->bindParam(":address", $param_address, PDO::PARAM_STR);
			$schedpickup->bindParam(":city", $city, PDO::PARAM_STR);
			$schedpickup->bindParam(":phone", $param_phone, PDO::PARAM_STR);
			$schedpickup->bindParam(":type", $type, PDO::PARAM_STR);
			$schedpickup->bindParam(":pickupd", $param_pickupd, PDO::PARAM_STR);
		
	
		if($schedpickup->execute()){
			/* schedual added  */
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
	<div class="page-header">
		<center><img src="valet/images/logo.png"></center>
    	<center><b><? echo $currentday; ?> <? echo $currenttime; ?></b></center>
        <?php 
			if($corporate == true){
				$business = $fullname;
				echo "<h1>Good day <b>" . $business . " staff.</b></h1>";
				echo "<h2>Please request staff and valet pickups below.</h2>";
			}elseif($public == true){
				$person = $fullname;
				echo "<h1>Good day <b>" . $person . ".</b></h1>";
				echo "<h2>Welcome to the Drycleaning by Dave request pickup app.</h2>";
			}else{
				if($user == $manager1 || $user == $manager2){
					echo "Welcome back <b>" . $first . "</b>!";
				}else{
					$dcbd = $town . " " . $fullname;
					echo "<h1>Welcome <b>" . $dcbd . "</b></h1>";
					echo "<h3>You are logged into the administration page.</h3>";
				}
			}
			?>
		<center><img src="valet/images/truck.png"></center>
    </div>
	<div class="container">
	<?
		/* General Public Display */
		if($public == true){
		?>
		<form action="pickup.php" method="post">
		<input type="submit" class="btn btn-default" value="Request Pickup">
    	<!-- <a href="pickup-request.php" class="btn btn-success">Request Pickup</a> -->
		<hr>
		<center><div class="custdata">
		<center><h3>Address & Contact Verification</h3></center>
			<input type="hidden" name="public" value="<? echo $public; ?>">
			<div class="namesec">
			<div class="form-inline" align="left">
                <label>Name: &nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="first" class="form-control" value="<?php echo $first; ?>" size="15" disabled>
                <input type="text" name="last" class="form-control" value="<?php echo $last; ?>" size="15" disabled>
				<span class="help-block"></span>
            </div>
			</div>
            <div class="form-inline" align="left">
                <label>Address: </label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" size="30" disabled>
				<span class="help-block"></span>
            </div>
            <div class="form-inline" align="left">
                <label>City: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="city" class="form-control" value="<?php echo $town; ?>" size="15" disabled>
				<span class="help-block"></span>
            </div>
			<div class="form-inline" align="left">
                <label>Contact: &nbsp;</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" size="15" disabled>
                <span class="help-block"></span>
            </div>
            <div class="form-group" align="center">
					<a href="userupdate.php" class="btn btn-primary">Update</a> <a href="reset-password.php" class="btn btn-warning">Change Password</a> <a href="logout.php" class="btn btn-danger">Sign Out</a>
            </div>
        </form>
		</div></center>
		
		<?
		/* ~~~ END General Public Display ~~~ */
		/* Corporate & Hotel Display */
		} elseif($corporate == true){
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<center><label>Hotel Pickup Type</label></center>
			<div class="form-group">
				<input type="checkbox" name="staff" value="staff"> Staff <input type="checkbox" name="valet" value="valet"> Valet
			</div>
			<input type="hidden" name="corporate" value="<? echo $corporate; ?>">
		<input type="submit" class="btn btn-default" value="Request Pickup">
		<!-- <a href="pickup-request.php" class="btn btn-success">Request Pickup</a> -->
		<hr>
		<center><div class="custdata">
		<center><h3>Address & Contact Verification</h3></center>
			<div class="namesec">
			<div class="form-inline" align="left">
                <label>Name: &nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="first" class="form-control" value="<?php echo $first; ?>" size="15" disabled>
                <input type="text" name="last" class="form-control" value="<?php echo $last; ?>" size="15" disabled>
				<span class="help-block"></span>
            </div>
			</div>
            <div class="form-inline" align="left">
                <label>Address: </label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" size="40" disabled>
				<span class="help-block"></span>
            </div>
            <div class="form-inline" align="left">
                <label>City: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="city" class="form-control" value="<?php echo $town; ?>" size="15" disabled>
				<span class="help-block"></span>
            </div>
			<div class="form-inline" align="left">
                <label>Contact: &nbsp;</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" size="15" disabled>
                <span class="help-block"></span>
            </div>
            <div class="form-group" align="center">
					<a href="userupdate.php" class="btn btn-primary">Update</a> <a href="reset-password.php" class="btn btn-warning">Change Password</a> <a href="logout.php" class="btn btn-danger">Sign Out</a>
            </div>
        </form>
		</div></center>
		
		<?
		/* ~~~ END Corporate & Hotel Display ~~~ */
		/* Administration Display */
		} else{
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<input type="submit" class="btn btn-danger" value="submit">
		<!-- <a href="pickup-request.php" class="btn btn-danger">Send Test Pickup</a> -->
		<a href="r3g1573r.php" class="btn btn-primary">Add Client</a>
		<hr>
		<center><div class="custdata">
		<form action="pickup.php" method="post">
		<center><h3>Address & Contact Verification</h3></center>
            <center><label>Hotel Pickup Type</label></center>
			<div class="form-group">
				<input type="checkbox" name="staff" value="staff"> Staff <input type="checkbox" name="valet" value="valet"> Valet
			</div>
			<input type="hidden" name="admin" value="<? echo $admin; ?>">
			<div class="namesec">
			<div class="form-inline" align="left">
                <label>Name: &nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="first" class="form-control" value="<?php echo $first; ?>" size="15" disabled>
                <input type="text" name="last" class="form-control" value="<?php echo $last; ?>" size="15" disabled>
				<span class="help-block"></span>
            </div>
			</div>
            <div class="form-inline" align="left">
                <label>Address: </label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>" size="40" disabled>
				<span class="help-block"></span>
            </div>
            <div class="form-inline" align="left">
                <label>City: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <input type="text" name="city" class="form-control" value="<?php echo $town; ?>" size="15" disabled>
				<span class="help-block"></span>
            </div>
			<div class="form-inline" align="left">
                <label>Contact: &nbsp;</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" size="15" disabled>
                <span class="help-block"></span>
            </div>
            <div class="form-group" align="center">
					<a href="userupdate.php" class="btn btn-primary">Update</a> <a href="reset-password.php" class="btn btn-warning">Change Password</a> <a href="logout.php" class="btn btn-danger">Sign Out</a>
            </div>
        </form>
		</div></center>
		<?
		}
		/* ~~~ END Administration Display ~~~ */
		?>
    </div>
</body>
</html>