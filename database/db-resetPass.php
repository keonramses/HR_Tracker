<?php
    include "db.php";

    // function to generate random password
    function generate_password($len = 8){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $len );
        return $password;
    } 
    $flag = 0;

    $id = $_GET['id'];

    $password = generate_password();
    $loginPwd = password_hash($password, PASSWORD_DEFAULT);

    $result = mysqli_query($conn, "SELECT name, email FROM employee WHERE id='$id'");
    $q1 = mysqli_fetch_array($result);

    $sql = "UPDATE employee SET loginPwd=? WHERE id=?";

    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error deleting record";
        $flag = 1;
    }
    else{
        mysqli_stmt_bind_param($stmt, "si", $loginPwd, $id);
        mysqli_stmt_execute($stmt);
        
        // Send password to email after employee password is reset.
                    $headers = 'From: HR Manager <webmaster@test.com>' . "\r\n" .
                               'Reply-To: webmaster@test.com' . "\r\n" .
                               'X-Mailer: PHP/' . phpversion();
                    $msg = "Hello ".$q1['name'].",\nYour HRTracker Account Password has been Reset! \nYour New Password is: ".$password;
                    $msg = wordwrap($msg,70);
                    mail($q1['email'],"HRTracker Login Info!",$msg,$headers);
                    header("Location:../edit.php?id=$id");
                    $flag = 2;
                    alert("Password Generated & Sent to Employee");
        exit;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>
