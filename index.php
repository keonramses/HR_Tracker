<?php 
require_once "page/header.php";

?>

<!-- Role Data -->
<div class="panel panel-default">
    <!-- Add Role Button -->
    <?php if($_SESSION['isAdmin']) : ?>
    <button type="button" name="assign_role" id="assign_role" class="btn btn-success btn-xs shadow" style="margin-left: 0.1%; margin-bottom: 0.5%;"><i class="fa fa-plus"> <STRONG>ASSIGN ROLE</STRONG></i></button> 
    <?php endif ?>
    <!-- Logout Button -->
    <a href="page/logout.php"  class="btn btn-danger btn-xs shadow" style="float:right;" onclick="return confirm('Are You Sure You Want to Logout?')"><i class="fa fa-sign-out"><STRONG>LOGOUT</STRONG></i></a>
    <!-- Special Role Table -->
    <div id="role_data" class="table-responsive table "></div>
</div>

<!-- Special Role Pop-Up -->
<?php include "page/role_popUp.php" ?>

<!-- Manager and General Service Contact Data -->
<div class="panel panel-default">
    <!-- Show Contacts Button -->
    <button type="button" id="toggle_contacts" class="btn btn-primary btn-xs shadow" style="margin-left: 0.1%; margin-bottom: 1%;">SHOW CONTACTS</button>

    <!-- Contact Tables -->
    <div class="row" id="primary_contacts">
		<!-- Manager Contact Table -->
		<div class= "table-responsive col-md-6">
		<h3><strong>Managers</strong></h3>
        <div id="employee_manager_data"></div>
		</div>
	
		<!-- General Contact Table -->
		<div class= "table-responsive col-md-6">
		
		<h3><strong>General Contact</strong></h3>
		<!-- Add Button for Contact Table -->
        <?php if($_SESSION['isAdmin']) : ?>
            <button type="button" id="add_contact" class="btn btn-success btn-xs shadow" style="float:right;" ><i class="fa fa-plus"> <STRONG>ADD CONTACT</STRONG> </i></button>
		<?php endif ?>
            <div id="contact_data"></div>
		</div>
    </div>
</div>

<!-- Contact Pop-Up -->
<?php include "page/contact_popUp.php" ?>
<hr>

<!-- Show Stats Table to Admin Only -->
<?php if($_SESSION['isAdmin']) : ?>
<div class="panel-body">
     <!-- Stats Table -->
    <div id="stats_data" class="table-responsive mb-3" style="width:100%;"></div>
</div>
<hr>
<?php endif ?>

<!-- Logged In Employee -->

<div class="panel-body">
     <!-- Logged In Employee Table -->
    <div id="loggedin_employee_data" class="table-responsive mb-3" style="width:100%;"></div>
</div>

<?php if($_SESSION['isAdmin']) : ##<!-- Add Employee Button -->?>
<div class="mb-3">
<h2><a href="add.php" class="btn btn-success btn-xs shadow"> <i class="fa fa-plus"><strong> ADD EMPLOYEE </strong></i> </a></h2>
</div>
<?php endif ?>

<!-- Employee Data -->
<div class="panel panel-default">
     <!-- Employee Table -->
    <div id="employee_data" class="table-responsive" style="width:100%;"></div>
</div>

 

<!-- Pop-Up (Update Status/Comment) -->
<?php include "page/employee_popUp.php" ?>
<script src="page/interact.js"></script>
<?php require_once "page/footer.php"; ?>



