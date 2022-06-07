<?php
    include "db.php";

    $sql = "SELECT name FROM employee WHERE hasSpecialRole = 'Yes'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    function getSpecialRoleList($result){
        $list = '';
        $list .= '<option value=""></option>';
        foreach($result as $row){
            $list .= '<option value="'.$row["name"].'">'.$row['name'].'</option>';
        }
        return $list;
    }

    $output = getSpecialRoleList($result);

    // echo getSpecialRoleList($result);
    echo $output;
?>