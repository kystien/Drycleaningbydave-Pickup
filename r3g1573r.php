<?php
// Include config file
require_once "valet/src/config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
	if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    	// Validate username
    	if(empty(trim($_POST["username"]))){
        	$username_err = "Please enter a username.";
    	} else{
        	// Prepare a select statement
        	$sql = "SELECT id FROM users WHERE username = :username";
        
        	if($stmt = $pdo->prepare($sql)){
            	// Bind variables to the prepared statement as parameters
            	$stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            	// Set parameters
            	$param_username = trim($_POST["username"]);
            
            	// Attempt to execute the prepared statement
            	if($stmt->execute()){
                	if($stmt->rowCount() == 1){
                    	$username_err = "This username is already taken.";
                	} else{
                    	$username = trim($_POST["username"]);
                	}
            	} else{
                	echo "Oops! Something went wrong. Please try again later.";
            	}
        	}
         
        	// Close statement
        	unset($stmt);
    	}
    
    	// Validate password
    	if(empty(trim($_POST["password"]))){
        	$password_err = "Please enter a password.";     
    	} elseif(strlen(trim($_POST["password"])) < 6){
        	$password_err = "Password must have atleast 6 characters.";
    	} else{
        	$password = trim($_POST["password"]);
    	}
    
    	// Validate confirm password
    	if(empty(trim($_POST["confirm_password"]))){
        	$confirm_password_err = "Please confirm password.";     
    	} else{
        	$confirm_password = trim($_POST["confirm_password"]);
        	if(empty($password_err) && ($password != $confirm_password)){
            	$confirm_password_err = "Password did not match.";
        	}
    	}
    	// Validate name
    	if(empty(trim($_POST["first"]))){
        	$first_err = "Please type a firstname.";     
    	} else{
        	$firstname = trim($_POST["first"]);
    	}
    	if(empty(trim($_POST["last"]))){
        	$last_err = "Please type a lastname.";     
    	} else{
        	$lastname = trim($_POST["last"]);
    	}
    	// Validate city
    	if(empty(trim($_POST["city"]))){
        	$city_err = "Please type a city.";     
    	} else{
        	$city = trim($_POST["city"]);
    	}
		if(empty(trim($_POST["address"]))){
        	$address_err = "Please input an address for delivery.";     
    	} else{
        	$address = trim($_POST["address"]);
    	}
		if(empty(trim($_POST["phone"]))){
        	$phone_err = "Please input a contact number.";     
    	} else{
        	$phone = trim($_POST["phone"]);
    	}
    	if(empty(trim($_POST["corporate"]))){
    		$corporate = "0";     
    	} else{
        	$corporate = trim($_POST["corporate"]);
    	}
		if(empty(trim($_POST["public"]))){
			$public = "0";     
    	} else{
        	$public = trim($_POST["public"]);
    	}
    	if(empty(trim($_POST["admin"]))){
    		$admin = "0"; 
    	} else{
        	$admin = trim($_POST["admin"]);
    	}

	    // Check input errors before inserting in database
    	if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($city_err) && empty($address_err) && empty($phone_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, first, last, city, address, phone, corporate, public, admin) VALUES (:username, :password, :first, :last, :city, :address, :phone, :corporate, :public, :admin)";
         
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
			$stmt->bindParam(":first", $param_first, PDO::PARAM_STR);
			$stmt->bindParam(":last", $param_last, PDO::PARAM_STR);
            $stmt->bindParam(":city", $param_city, PDO::PARAM_STR);
            $stmt->bindParam(":address", $param_address, PDO::PARAM_STR);
			$stmt->bindParam(":phone", $param_phone, PDO::PARAM_STR);
			$stmt->bindParam(":corporate", $param_corporate, PDO::PARAM_STR);
			$stmt->bindParam(":public", $param_public, PDO::PARAM_STR);
			$stmt->bindParam(":admin", $param_admin, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_first = $firstname;
			$param_last = $lastname;
            $param_city = $city;
            $param_address = $address;
			$param_phone = $phone;
			$param_corporate = $corporate;
			$param_public = $public;
			$param_admin = $admin;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
	}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Drycleaning by Dave - Pickup Request - Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .header{ width: 450px; padding: 20px; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
		<center><img src="valet/images/logo.png"></center>
		<br>
		<center><img src="valet/images/truck.png"></center>
		<center><div class="header" align="left">
		<h2 align="center">Create Account</h2>
        <p>Please fill this form to create an account for the Drycleaning by Dave home pickup and delivery service.</p>
		</div></center>
    <center><div class="wrapper" align="left">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <center><label>Account Type</label></center>
			<div class="form-group">
				<input type="checkbox" name="corporate" value="1"> Corporate<br>
				<input type="checkbox" name="public" value="1"> General Public<br>
				<input type="checkbox" name="admin" value="1"> Administration<br>
			</div>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($first_err)) ? 'has-error' : ''; ?>">
                <label>First Name</label>
                <input type="text" name="first" class="form-control" value="<?php echo $firstname; ?>">
                <span class="help-block"><?php echo $first_err; ?></span>
			</div>
			<div class="form-group <?php echo (!empty($last_err)) ? 'has-error' : ''; ?>">
				<label>Last Name</label>
                <input type="text" name="last" class="form-control" value="<?php echo $lastname; ?>">
                <span class="help-block"><?php echo $last_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($city_err)) ? 'has-error' : ''; ?>">
                <label>City</label>
                <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                <span class="help-block"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
                <span class="help-block"><?php echo $address_err; ?></span>
            </div>
			<div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                <label>Best Contact Phone Number</label>
                <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                <span class="help-block"><?php echo $phone_err; ?></span>
            </div>
            <div class="form-group">
            	<div class="col-md-6" align="left">
                <input type="reset" class="btn btn-default" value="Reset">
				</div>
				<div class="col-md-6" align="right">
                <input type="submit" class="btn btn-primary" value="Submit">
            	</div>
            	<br>
            </div>
            <!-- <p>Already have an account? <a href="login.php">Login here</a>.</p> -->
        </form>
    </div></center>
    <br>
</body>
</html>