<?php
// Initialize the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ini_set("display_errors", 0);

// Check if the user is already logged in, if yes then redirect to index page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: ../index.php");
    exit;
}

// Include config file
include "../database/db.php";

// Function to generate a random password
function generatePassword($len = 8)
{
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $password = substr(str_shuffle($chars), 0, $len);
    return $password;
}

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = $reset_ok = $login_err = "";


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['resetPassBtn'])) {

    // Retrieve email from the form
    $resetEmail = $_POST['resetEmail'];

    // Check if the email exists in the database
    $query = "SELECT * FROM employee WHERE email = '$resetEmail'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Generate a new password
        $newPassword = generatePassword();

        // Update the user's password in the database
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE employee SET loginPwd=? WHERE id=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $flag = 4;
        } else {
            mysqli_stmt_bind_param($stmt, "si", $hashedPassword, $user['id']);
            mysqli_stmt_execute($stmt);

            // Send the new password to the user's email.
            $headers = 'From: HR Manager <webmaster@test.com>' . "\r\n" .
                'Reply-To: webmaster@test.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $msg = "Hello " . $user['name'] . ",\n\nYour HRTracker Account Password has been Reset! \n\nYour New Password is: " . $newPassword;
            $msg = wordwrap($msg, 70);

            if (mail($user['email'], "HRTracker Password Reset!", $msg, $headers)) {
                $reset_ok = "An email with the new password has been sent to your email address.";
            } else {
                $login_err = "Failed to send an email. Please contact the administrator.";
            }
        }

        mysqli_stmt_close($stmt);
    } else {
        $login_err = "The email address does not exist.";
    }
}




// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['loginBtn'])) {


    // Input Validation error echo's below not shown on client side intentionally!
    // Using html data-validate attribute instead to show empty form input error

    // Check if username is empty
    $empty_email = trim($_POST["email"]);
    if (empty($empty_email)) {
        $email_err = "Please enter email.";
    } else {
        $email = $_POST['email'];
    }

    // Check if password is empty
    $empty_password = trim($_POST["password"]);
    if (empty($empty_password)) {
        $password_err = "Please enter your password.";
    } else {
        $password = $_POST['password'];
    }

    // Validate credentials
    if (empty($email_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, name, email, loginPwd, isAdmin FROM employee WHERE email = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $user, $email, $hashed_password, $isAdmin);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_destroy();
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;
                            $_SESSION["level"] = $isAdmin;
                            $_SESSION["user"] = $user;

                            if ($isAdmin == "Yes") {
                                $_SESSION["isAdmin"] = true;
                            } else {
                                $_SESSION["isAdmin"] = false;
                            }

                            // Redirect user to welcome page
                            header("location: ../index.php");
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Incorrect Email or Password";
                        }
                    }
                } else {
                    // Employee doesn't exist, display a generic error message
                    $login_err = "Incorrect Email or Password";
                }
            } else {
                $login_err = "Oops! Something went wrong. Please try again later.";
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
    <title>Login Page | HRTracker</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/jpg" href="favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha512-rRQtF4V2wtAvXsou4iUAs2kXHi3Lj9NE7xJR77DE7GHsxgY9RTWy93dzMXgDIG8ToiRTD45VsDNdTiUagOFeZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="false">

                    <?php if (!empty($login_err)) : ?>
                        <div class="alert alert-danger text-center text-danger" role="alert">
                            <i class="zmdi zmdi-alert-circle-o"> <?php echo $login_err; ?></i>
                        </div>
                    <?php endif ?>
                    <?php if (!empty($reset_ok)) : ?>
                        <div class="alert alert-success text-center" role="alert">
                            <i class="zmdi zmdi-alert-circle-o"> <?php echo $reset_ok; ?></i>
                        </div>
                    <?php endif ?>

                    <span class="login100-form-title p-b-26">
                        HRTracker - Login
                    </span>

                    <span class="login100-form-title p-b-48">
                        <i class="zmdi zmdi-swap"></i>
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Please Enter Email">
                        <input class="input100" type="text" name="email">
                        <span class="focus-input100" data-placeholder="Email"></span>
                        <?php echo $email_err; ?>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <span class="btn-show-pass">
                            <i class="zmdi zmdi-eye"></i>
                        </span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                        <?php echo $password_err; ?>

                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" id="loginBtn" name="loginBtn">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-115">
                        <span class="txt1">
                            Forgot Password?
                        </span>

                        <!-- Button to trigger the modal -->
                        <button type="button" class="text-danger" id="resetButton">
                            RESET!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="lead modal-title" id="resetModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="resetEmail" class="lead">Email</label>
                            <input type="resetEmail" class="form-control" id="resetEmail" name="resetEmail" required>
                        </div>
                        <br>
                        <form action="" method="post" id="resetPasswordForm">
                            <button type="submit" class=" lead btn btn-danger" id="resetPassBtn" name="resetPassBtn">Reset Password</button>
                        </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js" integrity="sha512-pYd2QwnzV9JgtoARJf1Ui1q5+p1WHpeAz/M0sUJNprhDviO4zRo12GLlk4/sKBRUCtMHEmjgqo5zcrn8pkdhmQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="js/login.js"></script>

    <script>
        // Wait for the document to be fully loaded
        $(document).ready(function() {
            // Handle click event on the reset button
            $('#resetButton').click(function() {
                $('#resetModal').modal('show'); // Trigger the modal to show
            });
        });
    </script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

    <footer>
        <div class="footer"> <small>&copy; Copyright <?php echo date("Y"); ?>, HRTracker (Kenneth Iwuchukwu).</small> </div>
    </footer>

</body>

</html>