<?php
    require_once "page/header.php";
    require_once "database/db-insert.php";
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
?>
<!-- Check if user is admin -->
<?php if($_SESSION['isAdmin']) : ?>

<div class="panel panel-default">
    <!-- Messages that display whether or not employee is inserted in database -->
    <?php if($flag == 1) {?>
    <div class="alert alert-danger">
        <strong>Employee already exists!</strong>
    </div>
    <?php }?>
    <?php if($flag == 2) {?>
    <div class="alert alert-success">
        <strong>Employee Profile Successfully Created!</strong>
        <strong>Login Details Sent To Employee!</strong>
    </div>
    <?php }?>
    

    <div class="form">
	<h5 class = "mb-4">| ADD NEW EMPLOYEE |</h5>
	 <!-- Back button -->
    <div class="panel-heading">
        <a class="btn btn-secondary btn-xs shadow" href="index.php"><i class="fa fa-arrow-left"> </i> Back</a>
    </div>
	
        <form action="add.php" method="post">
            <!-- Name -->
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" required> 
            </div>
            <!-- Local -->
            <div class="mb-3">
                <label for="local">Local</label>
                <input type="text" name="local" placeholder="Enter 4 Digit Local No." pattern="[0-9]{4}" maxlength="4" title="#### Eg: 1234" id="local" class="form-control"> 
            </div>
            <!-- Cell -->
            <div class="mb-3">
                <label for="cell">Cell</label>
                <input type="text" name="cell" placeholder="Enter 10 Digit Cell No. ###-###-####" pattern="[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}" maxlength="12" title="###-###-#### Eg: 123-456-7890" id="cell" class="form-control"> 
            </div>
            <!-- Status -->
            <div class="mb-3">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="In">In</option>
                    <option value="Break">Break</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Out">Out</option>
                </select>
            </div>
            <!-- Comment -->
            <div class="mb-3">
                <label for="comment">Comment</label>
                <textarea type="text" name="comment" id="comment" maxlength="100" class="form-control"></textarea>
            </div>
            <!-- Team -->
            <div class="mb-3">
                <label for="team">Team:</label>
                <select name="team[]" id="team" class="selectpicker" data-width="300px" data-style="btn-primary btn-xs shadow" multiple="multiple" required>
                <option value="Accounting">Accounting</option>
                    <option value="Administration">Administration</option>
                    <option value="Help Desk">Help Desk</option>
					<option value="Human Resources (HR)">Human Resources (HR)</option>
                    <option value="IT Support (IT)">IT Support (IT)</option>
					<option value="Security">Security</option>
                </select>
            </div>
              <!-- Is Manager -->
        <div class="mb-3">
            <label for="isManager">Manager?</label>
            <select name="isManager" id="isManager" class="form-select">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
        </div>
            <!-- Is Assigned Special Role -->
            <div class="mb-3">
            <label for="hasSpecialRole">Has Special Role?</label>
            <select name="hasSpecialRole" id="hasSpecialRole" class="form-select">
                <option value="No">No</option>
                <option value="Yes">Yes</option>
            </select>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="email@example.com" id="email" class="form-control" required>
            </div>
            <!-- Submit -->
            <div class="form-group">
                <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-xs shadow" required> 
            </div>
        </form>
    </div>
	<br>
</div>
<?php endif ?>
<?php if(!$_SESSION['isAdmin']) : ?>
    <div class="w3-display-middle">
<h1 class="w3-jumbo w3-animate-top w3-center"><code>Access Denied</code></h1>
<hr class="w3-border-white w3-animate-left" style="margin:auto;width:50%">
<h3 class="w3-center w3-animate-right">You dont have permission to view this page. <a href="index.php">GO HOME</a></h3>
<h6 class="w3-center w3-animate-zoom">error code:403 forbidden</h6>
</div>
    <?php endif ?>

<?php require_once "page/footer.php"; ?>

