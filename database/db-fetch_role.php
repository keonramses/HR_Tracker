<?php
    include "db.php";
    session_start();

    $sql = "SELECT * FROM specialrole";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);


    if($_SESSION['isAdmin']){

    $output = '
    <table class="table rounded border shadow" id = "roles">
        <thead bgcolor="#E59BFF" class = "shadow">
            <tr>
                <th> Role Name </th>
                <th> Assigned To </th>
                <th> Last Updated On</th>
                <th> Update </th>
                <th> Delete </th>
            </tr>
        </thead>
        <tbody>
    ';}

    if(!$_SESSION['isAdmin']){

        $output = '
        <table class="table table-hover rounded border shadow" style = "margin-left:auto;margin-right:auto" id = "roles">
        <col style="width:40%">
        <col style="width:30%">
        <col style="width:30%">
        <thead bgcolor="#E59BFF" class = "shadow">
                <tr>
                    <th> Role Name </th>
                    <th> Assigned To </th>
                    <th> Last Updated On</th>
                </tr>
            </thead>
            <tbody>
        ';}
  

    if($numRows > 0){
        foreach($result as $row){
            if($_SESSION['isAdmin']){
            $output .= '
                <tr>
                    <td><nobr><strong>'.$row["roleName"].'</strong></nobr></td>
                    <td><nobr>'.$row["assignedTo"].'</nobr></td>
                    <td><nobr>'.$row["lastUpdated"].'<nobr></td>
                    <td>
                        <button type="button" name="update_role" class="btn btn-success btn-xs shadow update_role" id="'.$row["roleID"].'">
                            <i class="fa fa-chevron-up"></i>
                        </button>
                    </td>
                    <td>
                        <button type="button" name="delete_role" class="btn btn-danger btn-xs shadow delete_role" id="'.$row["roleID"].'">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            ';
             }

             if(!$_SESSION['isAdmin']){
                $output .= '
                    <tr>
                        <td><nobr><strong>'.$row["roleName"].'</strong></nobr></td>
                        <td><nobr>'.$row["assignedTo"].'</nobr></td>
                        <td><nobr>'.$row["lastUpdated"].'<nobr></td>
                    </tr>
                ';
                 }
          }
     }
    
    else
    {
        $output .= '
            <tr colspan="4" align="center">Data not found</tr>
        ';
    }
    $output .= '</tbody></table>';
    

        if($_SESSION['isAdmin']){
            $output .= '<script>
       $(document).ready(function() {
           $("#roles").DataTable({
            "paging":   false, 
            "info":     false, 
            "searching":false,
            "columnDefs": [
                   { "orderable": false, "targets": [1, 3, 4] },
                   { "orderable": true, "targets": [0, 2] }
               ]
           });
       });
       </script>';}
   
       if(!$_SESSION['isAdmin']){
           $output .= '<script>
      $(document).ready(function() {
          $("#roles").DataTable({
            "paging":   false, 
            "info":     false, 
            "searching":false,
            "columnDefs": [
                  { "orderable": false, "targets": [1, 2] },
                  { "orderable": true, "targets": [0] }
              ]
          });
      });
      </script>';}
    
    echo $output;
?>