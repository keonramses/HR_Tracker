<?php
	include "db.php";
    date_default_timezone_set('America/Vancouver');

    $flag = 0;
    $selectedID = $_GET['id'];
    $result = mysqli_query($conn,"SELECT * FROM employee WHERE id = '$selectedID'");

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
        $hasSpecialRole = $_POST['hasSpecialRole'];
        $email = $_POST['email'];

        $sql = "UPDATE employee SET name=?, local=?, cell=?, status=?, comment=?, lastUpdated=?, team=?, isManager=?, hasSpecialRole=?, email=? WHERE id=?";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            $flag = 0;
            echo "Error updating record";
        }
        else{
            mysqli_stmt_bind_param($stmt, "ssssssssssi", $name, $local, $cell, $status, $comment, $lastUpdated, $team, $isManager, $hasSpecialRole, $email, $id);
            mysqli_stmt_execute($stmt);
            header("Location:index.php");
            exit;
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
	
?>