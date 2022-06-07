<?php
    include "db.php";

    $idToDelete = $_GET['id'];

    $sql = "DELETE FROM employee WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "Error deleting record";
    }
    else{
        mysqli_stmt_bind_param($stmt, "i", $idToDelete);
        mysqli_stmt_execute($stmt);
        header("Location:../index.php");
        exit;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>