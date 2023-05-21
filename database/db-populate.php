<?php
    include "db.php";

// <!-- Status Filter -->
   $status_sql = "SELECT DISTINCT status FROM employee ORDER BY status ASC";
   $all_status = mysqli_query($conn, $status_sql);


// <!-- Teams Filter -->
$team_sql = "SELECT DISTINCT team FROM employee WHERE team NOT LIKE '%,%' ORDER BY team ASC";
   $all_team = mysqli_query($conn, $team_sql);

?>