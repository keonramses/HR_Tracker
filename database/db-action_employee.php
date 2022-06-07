<?php
    include "db.php";
    date_default_timezone_set('America/Vancouver');

    if(isset($_POST["action"]))
    {
        if($_POST["action"] == "fetch_single")
        {
            $fetchedID = $_POST['id'];
            $result = mysqli_query($conn, "SELECT * FROM employee WHERE id='$fetchedID'");
            foreach($result as $row){
                $output['name'] = $row['name'];
                $output['status'] = $row['status'];
                $output['comment'] = $row['comment'];
            }
            echo json_encode($output);
        }

        if($_POST["action"] == "update")
        {
            $id = $_POST['hidden_id'];
            $status = $_POST['status'];
            $comment = $_POST['comment'];
            $lastUpdated = date('d-M-Y @ <b>g:i a</b>');

            
            $sql = "UPDATE employee SET status=?, comment=?, lastUpdated=? WHERE id=?";
            
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo '<p>SQL Error</p>';
            }
            else{
                mysqli_stmt_bind_param($stmt, "sssi", $status, $comment, $lastUpdated, $id);
                mysqli_stmt_execute($stmt);
                echo '<p>Employee updated!</p>';
            }
            mysqli_stmt_close($stmt);
        }

        mysqli_close($conn);
    }

	
?>