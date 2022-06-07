<?php
    include "db.php";
    session_start();
    

    $s1 = mysqli_query($conn,"SELECT * FROM employee ");
    $s2  = mysqli_query($conn,"SELECT status FROM employee WHERE status = 'In'");
    $s3 = mysqli_query($conn,"SELECT status FROM employee WHERE status = 'Break' OR status = 'Lunch'");
    $s4 = mysqli_query($conn,"SELECT status FROM employee WHERE status = 'Out'");
    
    $total_employees = mysqli_num_rows($s1);
    $total_signedIn = mysqli_num_rows($s2);
    $total_breakLunch = mysqli_num_rows($s3);
    $total_signedOut = mysqli_num_rows($s4);
    

    $output = '
    <table class="table table-striped table-responsive display nowrap rounded border border-info table-bordered shadow caption-top" cellspacing="0" width="35%" id="showStats" style = "margin-left:auto;margin-right:auto">
    <col style="width:25%">
    <col style="width:25%">
    <col style="width:25%">
    <col style="width:25%">

    <caption>HRTracker Statistics</caption>

        <thead style="text-align:center;" hidden>
            <tr class="table-success">
            <th> Total Employees </th>
            <th> Signed In </th>
            <th> On Break/Lunch </th>
            <th> Signed Out </th>
            </tr>
        </thead>
        <tbody>
    ';
    if($total_employees > 0)
    {
            $output .= '
                <tr style="text-align:center;">
                    <td id='.$total_employees.'><strong>'.$total_employees.'</strong>'.' <br> Total Employees'.'</td>
                    <td ><strong>'.$total_signedIn.'</strong>'.' <br> Signed In'.'</td>
                    <td><strong>'.$total_breakLunch.'</strong>'.' <br> On Break/Lunch'.'</td>
                    <td><strong>'.$total_signedOut.'</strong>'.' <br> Signed Out'.'</td>
                </tr>
            ';
    }
    $output .= '</tbody></table>';

    // https://datatables.net/examples/basic_init/state_save.html

    $output .= '<script>
        $(document).ready(function() {
            $("#showStats").DataTable({
                "paging":   false, 
                "info":     false, 
                "searching":false,
                "orderable": false
            });
        });
        </script>';
    
    echo $output;
?>
