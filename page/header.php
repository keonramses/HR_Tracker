<!DOCTYPE html>
<?php // set cookie samesite attribute to SameSite=Lax, which prevents the cookie from being sent in a cross-site request.
// This behavior protects user data from accidentally leaking to third parties and cross-site request forgery.
if(isset($_COOKIE["PHPSESSID"])){
    header('Set-Cookie: PHPSESSID='.$_COOKIE["PHPSESSID"].'; SameSite="Lax"');
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <!-- 
        Project By: Kenenth I. Iwuchukwu  
    -->

    <!-- CSS -->
	<link rel="stylesheet" href="page/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

	<!-- DataTable CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet" >
	<link href="https://cdn.datatables.net/1.11.1/css/dataTables.bootstrap5.min.css" rel="stylesheet" >
    <link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.css" rel="stylesheet" >

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>

    <!-- JQuery UI -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

    <!-- Multiselect -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js" integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Date & Live Time -->
    <script type="text/javascript"> 
        function display_c(){
            var refresh=1000; // Refresh rate in milli seconds
            mytime=setTimeout('display_ct()',refresh)
        }
        function display_ct() {
            var x = new Date()
            document.getElementById('ct').innerHTML = x;
            display_c();
        }
    </script> 

    <title>HRTracker</title>
    <link rel="shortcut icon" type="image/jpg" href="page\favicon.ico"/>

      <!-- Start session and redirect to login page if not logged in -->
<?php
        session_start();

        if(!isset($_SESSION['loggedin'])){ //if login in session is not set
            header("Location: page/login.php");
        }
?>
</head>

<body onload=display_ct(); style="padding: 0.5%;">
<header>
    <div class="grid-container">
        <div class="grid-item">
            <div class="text-center" ><h1 id = "header_index"> HRTracker</h1>
            <span id='ct' ></span></div>
        </div>
        <div class="grid-item">
        <a href="index.php">
            <img src="page\logo.png" alt="logo">
    </a>
    <span>Logged in as: <?php echo ($_SESSION['email']) ?> &lt;|> (HrManager: <?php echo ($_SESSION['level']) ?> )</span>
        </div>
    </div>
</header>
<br>
<hr>
