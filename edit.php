<?php
require_once "database/db.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the error handling code at the beginning

// Check if user accessing the edit page is an admin and redirect back to index page if they are not 
if (!$_SESSION['isAdmin']) {
    $errorMessage = "You dont have permission to view this page";
    // Set a response code
    //var_dump(http_response_code(403));
    header("HTTP/1.1 403 Forbidden");
    header("Location: index.php?error=" . urlencode($errorMessage));
    exit;
}

// Check if the form is submitted for updating the record
if (($_SERVER["REQUEST_METHOD"] === "POST") && !isset($_POST['generatePasswordBtn'])) {
    require_once "database/db-update.php";
    exit;
}

// Get the record ID from the URL parameter
$recordId = $_GET['id'];

// Validate and sanitize the input
if (!is_numeric($recordId)) {
    // Invalid ID format
    $errorMessage = "Invalid record ID";
    header("Location: index.php?error=" . urlencode($errorMessage));
    exit;
}

// Query the database to check if the record exists
$query = "SELECT * FROM employee WHERE id = $recordId";
$result = mysqli_query($conn, $query);

// Check if the record exists
if (mysqli_num_rows($result) === 0) {
    // Record not found
    $errorMessage = "Record not found";
    header("Location: index.php?error=" . urlencode($errorMessage));
    exit;
}
mysqli_close($conn);
?>
<?php
ob_start();
require_once "page/header.php";
require_once "database/db-update.php";
ob_end_flush();
?>
<?php
if ($_SESSION['isAdmin'] && $fetchedID == "") { //if login in session is not set
    header("Location: index.php");
}
?>


<div class="panel panel-default">

    <!-- Messages that display whether or not employee is inserted in database -->

    <?php
    $error = error_get_last();
    if ($error !== null) {
        $flag = 3;
        //echo $error['message'];
    }
    ?>


    <?php
    if ($flag == 1) {
        echo '<div class="alert alert-danger text-center lead">';
        echo 'Error Updating Record Please Try Again Later!';
        echo '</div>';
    } else {
        if ($flag == 2) {
            echo '<div class="alert alert-success text-center lead">';
            echo 'Password Generated & Sent to Employee!';
            echo '</div>';
        } else {
            if ($flag == 3) {
                echo '<div class="alert alert-danger text-center lead">';
                echo '<strong>Error: </strong>' . $error['message'];
                echo '</div>';
            } else {
                if ($flag == 4) {
                    echo '<div class="alert alert-success text-center lead">';
                    echo 'Error: "Generating New Password" Please Try Again Later!';
                    echo '</div>';
                } else {
                    if ($flag == 5) {
                        echo '<div class="alert alert-success text-center lead">';
                        echo 'Error: "Will not Generate" Please Try Again Later!';
                        echo '</div>';
                    }
                }
            }
        }
    }
    ?>

    <div class="form">
        <h5 class="mb-4">| EDIT EXISTING EMPLOYEE |</h5>
        <!-- Back button -->
        <div class="panel-heading">
            <a class="btn btn-secondary btn-xs shadow" href="index.php"><i class="fa fa-arrow-left"> </i> Back</a>
            <a class="btn btn-success btn-xs shadow" data-bs-toggle="modal" data-bs-target="#generatePassword">
                <i class="fa fa-refresh"> GENERATE NEW PASSWORD</i></a>
            <!-- Delete button -->
            <a class="btn btn-danger btn-xs shadow" data-bs-toggle="modal" data-bs-target="#deleteEmployeeRecord">
                <i class="fa fa-trash"></i></a>
        </div>
        <br>
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
                    <option value="In" <?php if ($fetchedStatus == "In") echo 'selected="selected"'; ?>>In</option>
                    <option value="Break" <?php if ($fetchedStatus == "Break") echo 'selected="selected"'; ?>>Break</option>
                    <option value="Lunch" <?php if ($fetchedStatus == "Lunch") echo 'selected="selected"'; ?>>Lunch</option>
                    <option value="Out" <?php if ($fetchedStatus == "Out") echo 'selected="selected"'; ?>>Out</option>
                </select>
            </div>
            <!-- Comment -->
            <div class="mb-3">
                <label for="comment">Comment</label>
                <textarea type="text" name="comment" id="comment" class="form-control"><?php echo $fetchedComment; ?></textarea>
            </div>
            <!-- Team -->
            <div class="mb-3">
                <label for="team">Team:</label>

                <select name="team[]" id="team" class="selectpicker" data-width="300px" data-style="btn-primary btn-xs shadow" required>
                    <!-- Accounting -->
                    <option value="Accounting" <?php
                                                if (strpos($fetchedTeam, "Accounting") !== false) echo 'selected="selected"';
                                                ?>>
                        Accounting
                    </option>
                    <!-- Administration -->
                    <option value="Administration" <?php
                                                    if (strpos($fetchedTeam, "Administration") !== false) echo 'selected="selected"';
                                                    ?>>
                        Administration
                    </option>
                    <!-- Help Desk -->
                    <option value="Help Desk" <?php
                                                if (strpos($fetchedTeam, "Help Desk") !== false) echo 'selected="selected"';
                                                ?>>
                        Help Desk
                    </option>
                    <!-- Human Resources (HR) -->
                    <option value="Human Resources (HR)" <?php
                                                            if (strpos($fetchedTeam, "Human Resources (HR)") !== false) echo 'selected="selected"';
                                                            ?>>
                        Human Resources (HR)
                    </option>
                    <!-- IT Support (IT) -->
                    <option value="IT Support (IT)" <?php
                                                    if (strpos($fetchedTeam, "IT Support (IT)") !== false) echo 'selected="selected"';
                                                    ?>>
                        IT Support (IT)
                    </option>
                    <!-- Security -->
                    <option value="Security" <?php
                                                if (strpos($fetchedTeam, "Security") !== false) echo 'selected="selected"';
                                                ?>>
                        Security
                    </option>
                </select>
            </div>
            <!-- Is Manager -->
            <div class="mb-3">
                <label for="isManager">Manager?</label>
                <select name="isManager" id="isManager" class="form-select">
                    <option value="No" <?php if ($fetchedIsManager == "No") echo 'selected="selected"'; ?>>No</option>
                    <option value="Yes" <?php if ($fetchedIsManager == "Yes") echo 'selected="selected"'; ?>>Yes</option>
                </select>
            </div>
            <!-- Is Assigned Special Role -->
            <div class="mb-3">
                <label for="giveSpecialRole">Has Special Role?</label>
                <select name="giveSpecialRole" id="giveSpecialRole" class="form-select">
                    <option value="No" <?php if ($fetchedHasSpecialRole == "No") echo 'selected="selected"'; ?>>No</option>
                    <option value="Yes" <?php if ($fetchedHasSpecialRole == "Yes") echo 'selected="selected"'; ?>>Yes</option>
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


<!-- Modal -->
<div class="modal fade" id="generatePassword" tabindex="-1" role="dialog" aria-labelledby="generatePassword" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="generatePassword">Password Reset</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lead">Are You Sure You Want To Generate a New Password?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="" method="post" id="generatePasswordForm">
                    <button type="submit" class="btn btn-success" name="generatePasswordBtn" id="generatePasswordBtn">Generate New Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteEmployeeRecord" tabindex="-1" role="dialog" aria-labelledby="deleteEmployeeRecord" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="deleteEmployeeRecord">Delete Employee Record!</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lead">Are You Sure You Want To Permanently Delete Employee Record?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <form action="" method="post" id="generatePasswordForm">
                    <button type="submit" class="btn btn-danger" name="deleteEmployeeBtn" id="deleteEmployeeBtn">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once "page/footer.php"; ?>