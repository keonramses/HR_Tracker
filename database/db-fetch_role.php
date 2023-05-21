<?php
    include "db.php";
    session_start();

    $sql = "SELECT * FROM specialrole";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);


    $output = '
    <table class="table rounded border shadow" id = "roles">
        <thead style="background-color: #E59BFF;" class = "shadow">
            <tr>
                <th> Role Name </th>
                <th> Assigned To </th>
                <th> Last Updated On</th>';
                if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                    $output .= '
                    <th> Update </th>
                    <th> Delete </th>';
                }
                $output .= '
            </tr>
        </thead>
        <tbody>
    ';

    if($numRows > 0){
        foreach($result as $row){
            $output .= '
                <tr>
                    <td><nobr><strong>'.$row["roleName"].'</strong></nobr></td>
                    <td><nobr>'.$row["assignedTo"].'</nobr></td>
                    <td><nobr>'.$row["lastUpdated"].'<nobr></td>';
                    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                        $output .= '
                    <td>
                        <button type="button" name="update_role" class="btn btn-success btn-xs shadow update_role" id="'.$row["roleID"].'">
                            <i class="fa fa-chevron-up"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" name="delete_role" class="btn btn-danger btn-xs shadow delete_role" id="'.$row["roleID"].'">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>';
                }
                $output .= '
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
    
            $output .= '<script>
       $(document).ready(function() {
           $("#roles").DataTable({
            "paging":   false, 
            "info":     false, 
            "searching":false,
            "columnDefs": [
                { orderable: true, className: "reorder", targets: [0] },
                { orderable: false, targets: "_all" }
            ],
            "autoWidth": false,
            "responsive": true    

           });
       });
       </script>';
    
    echo $output;
?>