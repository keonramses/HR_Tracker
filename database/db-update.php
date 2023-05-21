<?php
	include "db.php";
    date_default_timezone_set('America/Vancouver');

    $flag = 0;
    $selectedID = $_GET['id'];
    $result = mysqli_query($conn,"SELECT * FROM employee WHERE id = '$selectedID'");

    function generate_password($len = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr(str_shuffle($chars), 0, $len);
        return $password;
    }


// Populate fields to edit based on selected ID from db
    while($row=mysqli_fetch_array($result)){
        $fetchedID = $row['id'];
        $fetchedName = $row['name'];
        $fetchedLocal = $row['local'];
        $fetchedCell = $row['cell'];
        $fetchedStatus = $row['status'];
        $fetchedComment = $row['comment'];
        $fetchedTeam = $row['team'];
		$fetchedIsManager = $row['isManager'];
		$fetchedHasSpecialRole = $row['hasSpecialRole'];
        $fetchedEmail = $row['email'];
    }
// UPDATE - Return updated values to db
    if(isset($_POST['submit'])){
		$id = $_POST['id'];
        $name = $_POST['name'];
        $local = $_POST['local'];
        $cell = $_POST['cell'];
        $status = $_POST['status'];
        $comment = $_POST['comment'];
        $lastUpdated = date('d-M-Y @ <b>g:i a</b>');
        $teamInput = $_POST['team'];
        $team = implode(', ',$teamInput);
        $isManager = $_POST['isManager'];
        $hasSpecialRole = $_POST['giveSpecialRole'];
        $email = $_POST['email'];

        $sql = "UPDATE employee SET name=?, local=?, cell=?, status=?, comment=?, lastUpdated=?, team=?, isManager=?, hasSpecialRole=?, email=? WHERE id=?";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            $flag = 1;
            echo "Error updating record";
        }
        else{
            mysqli_stmt_bind_param($stmt, "ssssssssssi", $name, $local, $cell, $status, $comment, $lastUpdated, $team, $isManager, $hasSpecialRole, $email, $id);
            mysqli_stmt_execute($stmt);
            header("Location: index.php");
            exit;
        }
        mysqli_stmt_close($stmt);
    }
    // Generate Password for User
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generatePasswordBtn'])) {
        $id = $_GET['id'];

        $info = mysqli_query($conn, "SELECT name, email FROM employee WHERE id='$id'");

        $q1 = mysqli_fetch_array($info);

        $sql = "UPDATE employee SET loginPwd=? WHERE id=?";

        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $flag = 4;
        }
        else {
            $password = generate_password();
            $loginPwd = password_hash($password, PASSWORD_DEFAULT);

            mysqli_stmt_bind_param($stmt, "si", $loginPwd, $id);
            mysqli_stmt_execute($stmt);
    
            // Send password to email after employee password is reset.
            $headers = 'From: HR Manager <webmaster@test.com>' . "\r\n" .
                'Reply-To: webmaster@test.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            $msg = "Hello " . $q1['name'] . ",\n\nYour HRTracker Account Password has been Reset! \n\nNew Password: " . $password;
            $msg = wordwrap($msg, 70);
            mail($q1['email'], "HRTracker Password Reset!", $msg, $headers);
    
            $flag = 2;
        }
        mysqli_stmt_close($stmt);
    }
    // Delete Employee Record
    if (isset($_POST['deleteEmployeeBtn'])) {

        $idToDelete = $_GET['id'];
        $sql = "DELETE FROM employee WHERE id = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "Error deleting record";
        }
        else{
            mysqli_stmt_bind_param($stmt, "i", $idToDelete);
            mysqli_stmt_execute($stmt);
            header("Location: index.php");
            exit;
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
	
?>