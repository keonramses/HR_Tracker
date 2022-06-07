<?php
    error_reporting (E_ALL ^ E_NOTICE);
    ob_start();
    require_once "page/header.php";
	require_once "database/db-update.php";
    ob_end_flush();
?>
<?php
if($_SESSION['isAdmin'] && $fetchedID ==""){ //if login in session is not set
            header("Location: index.php");
        }?>
<!-- Check if user is admin -->
<?php if($_SESSION['isAdmin']) : ?>
<div class="panel panel-default">

    <div class="form">
	<h5 class = "mb-4">| EDIT EXISTING EMPLOYEE |</h5>
	    <!-- Back button -->
    <div class="panel-heading">
        <a class="btn btn-secondary btn-xs shadow" href="index.php"><i class="fa fa-arrow-left"> </i> Back</a>
        <!-- Generate New Password -->
        <a href="database/db-resetPass.php?id=<?php echo $fetchedID; ?>" onclick="return confirm('Are You Sure You Want to Generate a New Password for the Employee?')" class="btn btn-success btn-xs shadow">
        <i class="fa fa-refresh"> GENERATE NEW PASSWORD</i></a>
        <!-- Delete button -->
		<a href="database/db-delete.php?id=<?php echo $fetchedID; ?>" onclick="return confirm('Are You Sure You Want to Delete Employee Record?')" class="btn btn-danger btn-xs shadow">
        <i class="fa fa-trash"></i></a>
    </div>
        <form action="edit.php" method="post">
            <!-- ID -->
            <input type="hidden" name="id" id="id" class="form-control" value="<?php echo $fetchedID; ?>">
            <!-- Name -->
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $fetchedName; ?>" required>
            </div>
            <!-- Local  -->
            <div class="mb-3">
                <label for="local">Local</label>
                <input type="text" name="local" placeholder="Enter 4 Digit Local No." pattern="[0-9]{4}" maxlength="4" title="#### Eg: 1234" id="local" class="form-control" value="<?php echo $fetchedLocal; ?>"> 
            </div>
            <!-- Cell -->
            <div class="mb-3">
                <label for="cell">Cell</label>
                <input type="text" name="cell" placeholder="Enter 10 Digit Cell No. ###-###-####" pattern="[0-9]{3}[-]{1}[0-9]{3}[-]{1}[0-9]{4}" maxlength="12" title="###-###-#### Eg: 123-456-7890" id="cell" class="form-control" value="<?php echo $fetchedCell; ?>"> 
            </div>
            <!-- Status -->
            <div class="mb-3 ">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-select">
                <option value="In" <?php if($fetchedStatus == "In") echo 'selected="selected"'; ?>>In</option>
                    <option value="Break" <?php if($fetchedStatus == "Break") echo 'selected="selected"'; ?>>Break</option>
                    <option value="Lunch" <?php if($fetchedStatus == "Lunch") echo 'selected="selected"'; ?>>Lunch</option>
                    <option value="Out" <?php if($fetchedStatus == "Out") echo 'selected="selected"'; ?>>Out</option>
                </select>
            </div>
            <!-- Comment -->
            <div class="mb-3">
                <label for="comment">Comment</label>
                <textarea type="text" name="comment" id="comment" class="form-control" ><?php echo $fetchedComment; ?></textarea>
            </div>
            <!-- Team -->
            <div class="mb-3">
                <label for="team">Team:</label>
                
                <select name="team[]" id="team" class="selectpicker"  data-width="300px" data-style="btn-primary btn-xs shadow" multiple="multiple" required>
                    <!-- Accounting -->
                    <option value="Accounting" 
                        <?php 
                        if(strpos($fetchedTeam,"Accounting") !== false) echo 'selected="selected"'; 
                        ?>>
                        Accounting
                    </option>
                    <!-- Administration -->
                    <option value="Administration" 
                        <?php 
                        if(strpos($fetchedTeam,"Administration") !== false) echo 'selected="selected"'; 
                        ?>>
                        Administration
                    </option>
                    <!-- Help Desk -->
                    <option value="Help Desk" 
                        <?php 
                        if(strpos($fetchedTeam,"Help Desk") !== false) echo 'selected="selected"'; 
                        ?>>
                        Help Desk
                    </option>
                    <!-- Human Resources (HR) -->
                    <option value="Human Resources (HR)" 
                        <?php 
                        if(strpos($fetchedTeam,"Human Resources (HR)") !== false) echo 'selected="selected"'; 
                        ?>>
                        Human Resources (HR)
                    </option>
                    <!-- IT Support (IT) -->
                    <option value="IT Support (IT)" 
                        <?php 
                        if(strpos($fetchedTeam,"IT Support (IT)") !== false) echo 'selected="selected"'; 
                        ?>>
                        IT Support (IT)
                    </option>
                    <!-- Security -->
                    <option value="Security" 
                        <?php 
                        if(strpos($fetchedTeam,"Security") !== false) echo 'selected="selected"'; 
                        ?>>
                        Security
                    </option>
                </select>
            </div>
			<!-- Is Manager -->
            <div class="mb-3">
                <label for="isManager">Manager?</label>
                <select name="isManager" id="isManager" class="form-select">
                    <option value="No" <?php if($fetchedIsManager == "No") echo 'selected="selected"'; ?>>No</option>
                    <option value="Yes" <?php if($fetchedIsManager == "Yes") echo 'selected="selected"'; ?>>Yes</option>
                </select>
            </div>
            <!-- Is Assigned Special Role -->
            <div class="mb-3">
                <label for="hasSpecialRole">Has Special Role?</label>
                <select name="hasSpecialRole" id="hasSpecialRole" class="form-select">
                    <option value="No" <?php if($fetchedHasSpecialRole == "No") echo 'selected="selected"'; ?>>No</option>
                    <option value="Yes" <?php if($fetchedHasSpecialRole == "Yes") echo 'selected="selected"'; ?>>Yes</option>
                </select>
            </div>
            <!-- Email -->
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $fetchedEmail; ?>" required>
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

<?php require_once "page/footer.php";?>