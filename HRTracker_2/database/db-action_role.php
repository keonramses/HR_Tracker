<?php
    include "db.php";

    date_default_timezone_set('America/Vancouver');

    if(isset($_POST["actionRole"]))
    {
        if($_POST["actionRole"] == "insertRole")
        {
            $roleName = $_POST['roleName'];
            $hasSpecialRole = $_POST['hasSpecialRole'];
            $lastUpdated = date('d-M-Y @ <b>g:i a</b>');

            $sql = "SELECT * FROM specialrole WHERE roleName=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo '<p>SQL Error</p>';
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $roleName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                if($rowCount > 0){
                    echo '<p>Role is already assigned!</p>';
                }
                else{
                    $sql = "INSERT INTO specialrole (roleName, assignedTo, lastUpdated) VALUES(?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo '<p>SQL Error</p>';
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "sss", $roleName, $hasSpecialRole, $lastUpdated);
                        mysqli_stmt_execute($stmt);
                        echo '<p>Role Assigned!</p>';
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }

        if($_POST["actionRole"] == "fetch_singleRole")
        {
            $fetchedRoleID = $_POST['roleID'];
            $result = mysqli_query($conn, "SELECT * FROM specialrole WHERE roleID='$fetchedRoleID'");
            foreach($result as $row){
                $output['roleName'] = $row['roleName'];
                $output['assignedTo'] = $row['assignedTo'];
            }
            echo json_encode($output);
        }

        if($_POST["actionRole"] == "updateRole")
        {
            $roleID = $_POST['hidden_roleID'];
            $hasSpecialRole = $_POST['hasSpecialRole'];
            $lastUpdated = date('d-M-Y @ <b>g:i a</b>');

            $sql = "UPDATE specialrole SET  assignedTo=?, lastUpdated=? WHERE roleID=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo '<p>SQL Error</p>';
            }
            else{
                mysqli_stmt_bind_param($stmt, "ssi", $hasSpecialRole, $lastUpdated, $roleID);
                mysqli_stmt_execute($stmt);
                echo '<p>Role Assignment Updated!</p>';
            }
            mysqli_stmt_close($stmt);
        }

        if($_POST["actionRole"] == 'deleteRole')
        {
            $roleIDToDelete = $_POST['roleID'];
            $sql = "DELETE FROM specialrole WHERE roleID = ?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "<p>SQL Error</p>";
            }
            else{
                mysqli_stmt_bind_param($stmt, "i", $roleIDToDelete);
                mysqli_stmt_execute($stmt);
                echo '<p>Role Assignment Deleted!</p>';
            }
            mysqli_stmt_close($stmt);
        }
    }
?>