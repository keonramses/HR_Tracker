<?php
include "db.php";
session_start();

$sql = "SELECT * FROM employee";
$result = mysqli_query($conn, $sql);
$numRows = mysqli_num_rows($result);

// https://stackoverflow.com/questions/36767492/php-newline-after-10th-comma
function showTeams($team)
{
    $teamArray = explode(", ", $team);
    $teamOutput = "";
    foreach ($teamArray as $teamElement) {
        $teamOutput .= $teamElement . "<br>";
    }
    return $teamOutput;
}


$output = '

    <table class="table table-hover border shadow" id="mainTable">   
    
 
        <thead style="background-color: #E59BFF;" class = "shadow">
            <tr>
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>
                <th> Status </th>
                <th> Comment </th>
                <th> Last Updated On</th>
                <th> Team </th>';
if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
    $output .= '<th> Update | Edit </th>';
}
$output .= '
            </tr>
        </thead>
        <tbody>
    ';

if ($numRows > 0) {
    foreach ($result as $row) {
        $output .= '
                <tr>
                    <td id=' . $row["name"] . '><strong><nobr>' . $row["name"] . '</nobr></strong></td>
                    <td>' . $row["local"] . '</td>
                    <td><nobr>' . $row["cell"] . '</nobr></td>
                    <td>' . $row["status"] . '</td>
                    <td class="comment-cell">' . $row["comment"] . '</td>
                    <td><nobr>' . $row["lastUpdated"] . '</nobr></td>
                    <td><nobr>' . showTeams($row["team"]) . '</nobr></td>';
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $output .= '<td><nobr><button type="button" name="update" class="btn btn-success shadow update" id="' . $row["id"] . '">
                    <i class="	fa fa-chevron-up"></i></button>
                    <a href="edit.php?id=' . $row['id'] . ' " class="btn btn-primary shadow">
                                <i class="fa fa-edit"></i>
                    </a></nobr></td>';
        }
        $output .= '
                </tr>
            ';
    }
} else {
    $output .= '
            <tr colspan="4" align="center">Data not found</tr>
        ';
}
$output .= '</tbody></table>';

// https://datatables.net/examples/basic_init/state_save.html

$output .= '<script>
        $(document).ready(function() {
            
            dataTable = $("#mainTable").DataTable({

            "columnDefs": [
                { orderable: true, className: "reorder", targets: [0,6] },
                { orderable: false, targets: "_all" }
            ],
            "dom": "trpi",
            "autoWidth": false,
            "responsive": true,
            "initComplete": function(settings, json) {
                $(".dataTables_info").css("margin-top", "-10px");
            },
            "language": {
                "info": "Showing _END_ entries (filtered from _MAX_ total entries)",
            }
               
        });

        $("#statusFilter").on("change", function(e){
            var status = $(this).val();
            $("#statusFilter").val(status)
            console.log(status)
            dataTable.column(3).search(status).draw();
          });
        
          $("#teamFilter").on("change", function(e){
            var team = $(this).val();
            $("#teamFilter").val(team)
            console.log(team)
            dataTable.column(6).search(team).draw();
          });

          $("#searchBox").on("input", function(e){
            var search = $(this).val();
            $("#searchBox").val(search)
            console.log(search)
            dataTable.column(0).search(search).draw();
          });

          $("#lengthFilter").on("change", function(e){
            var length = $(this).val();
            $("#lengthFilter").val(length);
            dataTable.page.len(length).draw();
        });
    });
   

   </script>';

echo $output;
