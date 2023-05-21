<?php
    include "db.php";
    session_start();

    $sql = "SELECT * FROM contact";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);

    $output = '
    <table class="table table-hover rounded border shadow " id="smainContactTable">
        <thead style="background-color: #E59BFF;" class = "shadow">
            <tr>
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>';
                if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                    $output .= '<th> Update | Delete </th>';
                }
                $output .= '
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
                    <td><nobr><strong>'.$row["contactName"].'</strong></nobr></td>
                    <td><nobr>'.$row["contactLocal"].'</nobr></td>
                    <td><nobr>'.$row["contactCell"].'</nobr></td>
                    ';
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
            $output .= '<td><nobr><button type="button" name="update_contact" class="btn btn-primary btn-xs shadow update_contact" id="' . $row["contactID"] . '">
                    <i class="fa fa-edit"></i></button>
                    <button type="button" name="delete_contact" class="btn btn-danger btn-xs shadow delete_contact" id="' . $row["contactID"] . '">
                    <i class="fa fa-trash"></i></button>
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


        $output .= '<script>$(document).ready(function() {
            $("#smainContactTable").DataTable({
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