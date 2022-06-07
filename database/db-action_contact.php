<?php
    include "db.php";

    date_default_timezone_set('America/Vancouver');

    if(isset($_POST["actionContact"]))
    {
        if($_POST["actionContact"] == "insertContact")
        {
            $contactName = $_POST['contactName'];
            $contactLocal = $_POST['contactLocal'];
            $contactCell = $_POST['contactCell'];

            $sql = "SELECT * FROM contact WHERE contactName=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo '<p>SQL Error</p>';
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $contactName);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $rowCount = mysqli_stmt_num_rows($stmt);
                if($rowCount > 0){
                    echo '<p>Contact already exists!</p>';
                }
                else{
                    $sql = "INSERT INTO contact (contactName, contactLocal, contactCell) VALUES(?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo '<p>SQL Error</p>';
                    }
                    else{
                        mysqli_stmt_bind_param($stmt, "sss", $contactName, $contactLocal, $contactCell);
                        mysqli_stmt_execute($stmt);
                        echo '<p>New Contact Added!</p>';
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }

        if($_POST["actionContact"] == "fetch_singleContact")
        {
            $fetchedContactID = $_POST['contactID'];
            $result = mysqli_query($conn, "SELECT * FROM contact WHERE contactID='$fetchedContactID'");
            foreach($result as $row){
                $output['contactName'] = $row['contactName'];
                $output['contactLocal'] = $row['contactLocal'];
                $output['contactCell'] = $row['contactCell'];
            }
            echo json_encode($output);
        }

        if($_POST["actionContact"] == "updateContact")
        {
            $contactID = $_POST['hidden_contactID'];
            $contactName = $_POST['contactName'];
            $contactLocal = $_POST['contactLocal'];
            $contactCell = $_POST['contactCell'];

            $sql = "UPDATE contact SET contactName=?, contactLocal=?, contactCell=? WHERE contactID=?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo '<p>SQL Error</p>';
            }
            else{
                mysqli_stmt_bind_param($stmt, "sssi", $contactName, $contactLocal, $contactCell, $contactID);
                mysqli_stmt_execute($stmt);
                echo '<p>Contact updated!</p>';
            }
            mysqli_stmt_close($stmt);
        }

        if($_POST["actionContact"] == 'deleteContact')
        {
            $contactIDToDelete = $_POST['contactID'];
            $sql = "DELETE FROM contact WHERE contactID = ?";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "<p>SQL Error</p>";
            }
            else{
                mysqli_stmt_bind_param($stmt, "i", $contactIDToDelete);
                mysqli_stmt_execute($stmt);
                echo '<p>Contact deleted!</p>';
            }
            mysqli_stmt_close($stmt);
        }
    }
?>