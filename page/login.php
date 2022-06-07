<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ../index.php");
    exit;
}
 
// Include config file
include "../database/db.php";
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = $_POST['email'];
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = $_POST['password'];
    }
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, loginPwd, isAdmin FROM employee WHERE email = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = $email;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $isAdmin);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["level"] = $isAdmin;
                            
                            if($isAdmin == "Yes"){
                                $_SESSION["isAdmin"] = true; 
                            }
                            else{
                                $_SESSION["isAdmin"] = false; 
                            }
                            
                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Incorrect Email or Password";
                        }
                    }
                } else{
                    // Employee doesn't exist, display a generic error message
                    $login_err = "Incorrect Email or Password";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href=
    "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Login Page | HRTracker</title>
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico"/>
</head>

<body>
    <header id ="header">
            <!--img src="logo.png" alt="logo"-->
            <span>HRTracker</span>
    </header>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="login-box">
            <h1>Login</h1>
           
           <?php 
            if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
            } ?>
            <div class="textbox">
                <i class="fa1 fa fa-user" aria-hidden="true"></i>
                <input type="text" placeholder="Login Email"
                         name="email"  class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                         value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
  
            <div class="textbox">
                <i class="fa1 fa fa-lock" aria-hidden="true"></i>
                <input type="password" placeholder="Password"
                name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
  
            <input class="button" type="submit"
                     name="login" value="Login">
            </div>
</form>
<footer><div class="well text-center" id="footer"> <small>&copy; Copyright <?php echo date("Y"); ?>, HRTracker (Kenneth Iwuchukwu).</small> </div></footer>
</body>

</html>