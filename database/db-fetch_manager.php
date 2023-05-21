<?php
    include "db.php";

    $sql = "SELECT name, local, cell, team FROM employee WHERE isManager = 'Yes'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    
    function showTeams($team){
        $teamArray = explode(", ",$team);
        $teamOutput = "";
        foreach($teamArray as $teamElement){
            $teamOutput .= $teamElement ."<br>";
        }
        return $teamOutput;
    }

    // https://stackoverflow.com/questions/24739126/scroll-to-a-specific-element-using-html
    function managerName($name){
        $managerOutput = "<a class='' href=#".$name.">".$name."</a>";
        return $managerOutput;
    }

    $output = '
    <table class="table table-hover rounded border shadow" style="width:100%" id="managerTable">
        <thead style="background-color: #E59BFF;"  class = "shadow">
            <tr>
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>
                <th> Team </th>
            </tr>
        </thead>
        <tbody>
    ';
    if($numRows > 0)
    {
        foreach($result as $row)
        {
            $output .= '
                <tr>
                    <td><nobr>'.managerName($row["name"]).'</nobr></td>
                    <td><nobr>'.$row["local"].'</nobr></td>
                    <td><nobr>'.$row["cell"].'</nobr></td>
                    <td><nobr>'.showTeams($row["team"]).'</nobr></td>
                </tr>
            ';
        }
    }
    else
    {
        $output .= '
            <tr colspan="4" align="center">Data not found</tr>
        ';
    }
    $output .= '</tbody></table>';
    

    $output .= '<script>$(document).ready(function() {
        $("#managerTable").DataTable({
            "columnDefs": [
                { orderable: true, className: "reorder", targets: [0] },
                { orderable: false, targets: "_all" }
            ],
            "dom": "t",
            "autoWidth": true,
            "responsive": true
            });
        });
        </script>';

    echo $output;
?>