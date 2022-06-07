<?php
    include "db.php";
    session_start();

    $sql = "SELECT * FROM contact";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);


if($_SESSION['isAdmin']){
    $output = '
    <table class="table table-hover rounded border shadow contactTable" id="mainContactTable">
        <col style="width:30%">
        <col style="width:10%">
        <col style="width:40%">
        <col style="width:10%">
        <col style="width:10%">
        <thead bgcolor="#E59BFF" class = "shadow">
            <tr>
                <th> Name </th>
                <th> Local </th>
                <th> Cell </th>
                <th> Update </th>
                <th> Delete </th>
            </tr>
        </thead>
        <tbody>
    ';}

 if(!$_SESSION['isAdmin']){
    $output = '
        <table class="table table-hover rounded border shadow contactTable" id="mainContactTable">
            <col style="width:40%">
            <col style="width:20%">
            <col style="width:40%">
            <thead bgcolor="#E59BFF" class = "shadow">
                <tr>
                    <th> Name </th>
                    <th> Local </th>
                    <th> Cell </th>
                </tr>
            </thead>
            <tbody>
        ';}
    if($numRows > 0)
    {
        foreach($result as $row)
        {
            if($_SESSION['isAdmin']){
            $output .= '
                <tr>
                    <td><nobr><strong>'.$row["contactName"].'</strong></nobr></td>
                    <td><nobr>'.$row["contactLocal"].'</nobr></td>
                    <td><nobr>'.$row["contactCell"].'</nobr></td>
                    <td style="text-align:center;">
                        <button type="button" name="update_contact" class="btn btn-primary btn-xs shadow update_contact" id="'.$row["contactID"].'">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                    <td style="text-align:center;">
                        <button type="button" name="delete_contact" class="btn btn-danger btn-xs shadow delete_contact" id="'.$row["contactID"].'">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            ';}
            if(!$_SESSION['isAdmin']){
                $output .= '
                    <tr>
                        <td><nobr><strong>'.$row["contactName"].'</strong></nobr></td>
                        <td><nobr>'.$row["contactLocal"].'</nobr></td>
                        <td><nobr>'.$row["contactCell"].'</nobr></td>
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


    if($_SESSION['isAdmin']){
        $output .= '<script>$(document).ready(function() {
            $("#mainContactTable").DataTable({
                    "paging":   false, 
                    "info":     false, 
                    "searching":false,
                    "columnDefs": [
                        { "orderable": false, "targets": [1, 2, 3, 4] },
                        { "orderable": true, "targets": [0] }
                    ]
                });
            });
            </script>';}

    if(!$_SESSION['isAdmin']){
    $output .= '<script>$(document).ready(function() {
        $("#mainContactTable").DataTable({
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