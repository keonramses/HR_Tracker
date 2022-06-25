<?php
	include "db.php";
    date_default_timezone_set('America/Vancouver');

    // Flag key:
    // 0 = sql error (no alert shows up at the top of the screen)
    // 1 = record already exists
    // 2 = record inserted
    $flag = 0;

    // function to generate random password
       function generate_password($len = 8){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $len );
        return $password;
    } 
    


    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $local = $_POST['local'];
        $cell = $_POST['cell'];
        $status = $_POST['status'];
        $comment = $_POST['comment'];
        $lastUpdated = date('d-M-Y @ <b>g:i a</b>');
        $teamInput = $_POST['team'];
        $team = implode(', ',$teamInput);
        $isManager = $_POST['isManager'];
        $hasSpecialRole = $_POST['hasSpecialRole'];
        $email = $_POST['email'];
        $password = generate_password();
        $loginPwd = password_hash($password, PASSWORD_DEFAULT);
        $setLevel = "No";


        $sql = "SELECT name FROM employee WHERE name = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            $flag = 0;
           
        }
        else{
            mysqli_stmt_bind_param($stmt, "s", $name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $rowCount = mysqli_stmt_num_rows($stmt);
            if($rowCount > 0){
                $flag = 1;
            }
            else{
                $sql = "INSERT INTO employee (name, local, cell, status, comment, lastUpdated, team, isManager, hasSpecialRole, email, loginPwd, isAdmin) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    $flag = 0;
                }
                else{
                    mysqli_stmt_bind_param($stmt, "ssssssssssss", $name, $local, $cell, $status,$comment, $lastUpdated, $team, $isManager, $hasSpecialRole, $email, $loginPwd, $setLevel);
                    mysqli_stmt_execute($stmt);
                    //echo "Your Password Is : ".$password;

                    // Send password to email after employee profile is created
                    $headers = 'From: HR Manager <webmaster@test.com>' . "\r\n" .
                               'Reply-To: webmaster@test.com' . "\r\n" .
                               'X-Mailer: PHP/' . phpversion();
                    $msg = "Hello ".$name.",\nYour HRTracker Account has been created! \nYour Email is: ".$email.  " and your password is: ".$password.".";
                    $msg = wordwrap($msg,70);
                    mail($email,"HRTracker Login Info!",$msg,$headers);
                    $flag = 2;
                }
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
?>
