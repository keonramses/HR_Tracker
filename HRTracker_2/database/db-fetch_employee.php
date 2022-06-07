<?php
    include "db.php";
    session_start();

    $sql = "SELECT * FROM employee";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    
    // https://stackoverflow.com/questions/36767492/php-newline-after-10th-comma
    function showTeams($team){
        $teamArray = explode(", ",$team);
        $teamOutput = "";
        foreach($teamArray as $teamElement){
            $teamOutput .= $teamElement ."<br>";
        }
        return $teamOutput;
    }

    if($_SESSION['isAdmin']){

    $output = '
    <table class="table table-hover table-responsive display nowrap rounded border shadow" cellspacing="0" width="100%" id="mainTable">
    <col style="width:15%">
    <col style="width:4%">
    <col style="width:15%">
    <col style="width:6%">
    <col style="width:20%">
    <col style="width:10%">
    <col style="width:10%">
    <col style="width:5%">
    <col style="width:5%">
        <thead bgcolor="#E59BFF" class = "shadow">
            <tr>
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>
                <th> Status </th>
                <th> Comment </th>
                <th> Last Updated On</th>
                <th> Team </th>
                <th style="text-align:center;">  Update </th>
                <th style="text-align:center;"> Edit</th>
            </tr>
        </thead>
        <tbody>
    ';
}

if(!$_SESSION['isAdmin']){

    $output = '
    <table class="table table-hover table-responsive display nowrap rounded border shadow" cellspacing="0"  style = "margin-left:auto;margin-right:auto" id="mainTable">
    <col style="width:15%">
    <col style="width:4%">
    <col style="width:15%">
    <col style="width:6%">
    <col style="width:30%">
    <col style="width:10%">
    <col style="width:15%">
        <thead bgcolor="#E59BFF" class = "shadow">
            <tr>
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>
                <th> Status </th>
                <th> Comment </th>
                <th> Last Updated On</th>
                <th> Team </th>
            </tr>
        </thead>
        <tbody>
    ';
}

    if($numRows > 0)
    {
        foreach($result as $row)
        {
            if($_SESSION['isAdmin']){
            $output .= '
                <tr>
                    <td id='.$row["name"].'><strong><nobr>'.$row["name"].'</nobr></strong></td>
                    <td>'.$row["local"].'</td>
                    <td><nobr>'.$row["cell"].'</nobr></td>
                    <td>'.$row["status"].'</td>
                    <td>'.$row["comment"].'</td>
                    <td><nobr>'.$row["lastUpdated"].'</nobr></td>
                    <td><nobr>'.showTeams($row["team"]).'</nobr></td>
                    <td style="text-align:center;">
                        <button type="button" name="update" class="btn btn-success btn-xs shadow update" id="'.$row["id"].'">
						<i class="	fa fa-chevron-up"></i>
        </a>
                        </button>
                    </td>
                    <td style="text-align:center;">                      				
					<a href="edit.php?id='.$row['id'].' " class="btn btn-primary btn-xs shadow">
                                <i class="fa fa-edit"></i>
                    </td>
                </tr>
            ';
        }

            if(!$_SESSION['isAdmin']){
                $output .= '
                    <tr>
                        <td id='.$row["name"].'><nobr>'.$row["name"].'</nobr></td>
                        <td>'.$row["local"].'</td>
                        <td><nobr>'.$row["cell"].'</nobr></td>
                        <td>'.$row["status"].'</td>
                        <td>'.$row["comment"].'</td>
                        <td><nobr>'.$row["lastUpdated"].'</nobr></td>
                        <td><nobr>'.showTeams($row["team"]).'</nobr></td>
                    </tr>
                ';}
        }
    }
    else
    {
        $output .= '
            <tr colspan="4" align="center">Data not found</tr>
        ';
    }
    $output .= '</tbody></table>';

    // https://datatables.net/examples/basic_init/state_save.html

    if($_SESSION['isAdmin']){
         $output .= '<script>
    $(document).ready(function() {
        $("#mainTable").DataTable({
            "columnDefs": [
                { "orderable": false, "targets": [0, 2, 4, 6, 7, 8] },
                { "orderable": true, "targets": [1, 3, 5] }
            ],
            "stateSave": true,
        });
    });
    </script>';}

    if(!$_SESSION['isAdmin']){
        $output .= '<script>
   $(document).ready(function() {
       $("#mainTable").DataTable({
           "columnDefs": [
               { "orderable": false, "targets": [0, 2, 4, 6] },
               { "orderable": true, "targets": [1, 3, 5] }
           ],
           "stateSave": true
       });
   });
   </script>';}
    
    
    echo $output;
?>
