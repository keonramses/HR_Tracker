<?php session_start();
// set cookie samesite attribute to SameSite=Lax, which prevents the cookie from being sent in a cross-site request.
// This behavior protects user data from accidentally leaking to third parties and cross-site request forgery.
if (isset($_COOKIE["PHPSESSID"])) {
    header('Set-Cookie: PHPSESSID=' . $_COOKIE["PHPSESSID"] . '; SameSite="Strict"');
}
// Start session and redirect to login page if not logged in //
if (!isset($_SESSION['loggedin'])) { //if login in session is not set
    header("Location: page/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 
        Project By: Kenenth I. Iwuchukwu  
    -->

    <!-- CSS -->
    <link rel="stylesheet" href="page/style.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
   
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <!-- DataTable -->
    <link href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/fc-4.2.2/fh-3.3.2/r-2.4.1/sr-1.2.2/datatables.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.4/b-2.3.6/b-colvis-2.3.6/b-html5-2.3.6/b-print-2.3.6/cr-1.6.2/fc-4.2.2/fh-3.3.2/r-2.4.1/sr-1.2.2/datatables.min.js"></script>


    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- JQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Multiselect -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/css/bootstrap-select.min.css" integrity="sha512-g2SduJKxa4Lbn3GW+Q7rNz+pKP9AWMR++Ta8fgwsZRCUsawjPvF/BxSMkGS61VsR9yinGoEgrHPGPn2mrj8+4w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta3/js/bootstrap-select.min.js" integrity="sha512-yrOmjPdp8qH8hgLfWpSFhC/+R9Cj9USL8uJxYIveJZGAiedxyIxwNw4RsLDlcjNlIRR4kkHaDHSmNHAkxFTmgg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    
    <!-- Date & Live Time -->
    <script type="text/javascript">
        function display_c() {
            var refresh = 1000; // Refresh rate in milli seconds
            mytime = setTimeout('display_ct()', refresh)
        }

        function display_ct() {
            const currentDate = new Date();
const options = {
  weekday: 'short',
  month: 'short',
  day: 'numeric',
  year: 'numeric',
  hour: 'numeric',
  minute: 'numeric',
};
const timeZoneOptions = {
  timeZoneName: 'long'
};

const formattedDate = currentDate.toLocaleString('en-US', options).replace(/,/g, ' ') + ' (' + new Intl.DateTimeFormat('en-US', timeZoneOptions).formatToParts(currentDate).find(part => part.type === 'timeZoneName').value + ')';
            document.getElementById('ct').innerHTML = formattedDate;
            display_c();
        }
    </script>

    <title>HRTracker</title>
    <link rel="shortcut icon" type="image/jpg" href="page\favicon.ico" />

</head>

<body onload=display_ct(); style="padding: 0.5%;">
    <header>
        <div class="grid-container">
            <div class="grid-item">
                <div class="text-center">
                    <h1 id="header_index"> HRTracker</h1>
                    <span id='ct'></span>
                </div>
            </div>
            <div class="grid-item">
                <a href="index.php">
                    <img src="page\logo.png" alt="logo">
                </a>
            </div>
        </div>
        <br>
        <div class="text-center">
            <br>
            <span class="alert alert-info text-center" role="alert" style="font-size:0.71em;">Logged in as: <strong><?php echo ($_SESSION['user']) ?></strong> [<em><?php echo ($_SESSION['email']) ?></em>] <?php if ($_SESSION['isAdmin']) : ?>- HRManager: <strong><?php echo ($_SESSION['level']) ?></strong><?php endif ?></span>
        </div>
    </header>
    <br>
    <hr>