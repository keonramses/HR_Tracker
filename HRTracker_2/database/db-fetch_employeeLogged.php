<?php
    include "db.php";
    session_start();

    $loggedUser = $_SESSION['email'];

    $sql = "SELECT * FROM employee WHERE email = '$loggedUser'";
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

    $output = '
    <table class="table table-striped table-responsive caption-top display nowrap rounded border border-info shadow" cellspacing="0" id="loggedInEmployee" style = "margin-left:auto;margin-right:auto">
    <col style="width:15%">
    <col style="width:4%">
    <col style="width:15%">
    <col style="width:6%">
    <col style="width:30%">
    <col style="width:10%">
    <col style="width:10%">
    <col style="width:5%">
    <caption>Update Your HRTracker Status | Comment </caption>
        <thead hidden>
            <tr class="table-success">
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>
                <th> Status </th>
                <th> Comment </th>
                <th> Last Updated On</th>
                <th> Team </th>
                <th style="text-align:center;">  Update </th>
            </tr>
        </thead>
        <tbody>
    ';
    if($numRows > 0)
    {
        foreach($result as $row)
        {
            $output .= '
                <tr style = "vertical-align: middle; text-align:center;">
                    <td id='.$row["name"].'><strong><nobr>'.$row["name"].'</nobr></strong></td>
                    <td>'.$row["local"].'</td>
                    <td><nobr>'.$row["cell"].'</nobr></td>
                    <td>'.$row["status"].'</td>
                    <td><wrap>'.$row["comment"].'</wrap></td>
                    <td><nobr>'.$row["lastUpdated"].'</nobr></td>
                    <td><nobr>'.showTeams($row["team"]).'</nobr></td>
                    <td>
                        <button type="button" name="update" class="btn btn-success btn-xs shadow update" id="'.$row["id"].'">
						<i class="	fa fa-chevron-up"></i><span><b>UPDATE</b></span>
        </a>
                        </button>
                    </td>
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

    // https://datatables.net/examples/basic_init/state_save.html

    $output .= '<script>
        $(document).ready(function() {
            $("#loggedInEmployee").DataTable({
                "paging":   false, 
                "info":     false, 
                "searching":false,
                "columnDefs": [
                    { "orderable": false, "targets": [1, 2, 4, 6, 7] },
                    { "orderable": true, "targets": [0, 3, 5] }
                ],
                "stateSave": true
            });
        });
        </script>';
    
    echo $output;
?>
