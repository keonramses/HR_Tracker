<?php
require_once "page/header.php";
include "database/db-populate.php";

if (isset($_GET['error'])) {
    $errorMessage = $_GET['error'];

    // Clear the error from the URL
    echo '<script>history.replaceState({}, "", location.pathname);</script>';

    // Display the error message in a Bootstrap modal
    echo '
        <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0" style="background-color: #FF4848;">
                    <div class="modal-header border-0">
                        <strong class="lead text-uppercase modal-title w-100 text-center text-white" id="errorModalLabel">' . $errorMessage . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
        <script>
        $(document).ready(function() {
            $("#errorModal").modal("show");

            setTimeout(function() {
                $("#errorModal").modal("hide");
            }, 4000);
        });
    </script>';
}
?>

<?php // <!-- Role Data --> ?>

<div class="panel panel-default">
    <!-- Add Role Button -->
    <?php if ($_SESSION['isAdmin']) : ?>
        <button type="button" name="assign_role" id="assign_role" class="btn btn-success btn-xs shadow" style="margin-left: 0.1%; margin-bottom: 0.5%;"><i class="fa fa-plus"> <STRONG>ASSIGN ROLE</STRONG></i></button>
    <?php endif ?>
    <!-- Logout Button -->
    <a class="btn btn-danger btn-xs shadow" style="float:right;" data-bs-toggle="modal" data-bs-target="#logout"><i class="fa fa-sign-out"><STRONG>LOGOUT</STRONG></i></a>
    <!-- Special Role Table -->
    <div id="role_data" class="table-responsive table "></div>
</div>

<!-- Special Role Pop-Up -->
<?php include "page/popup/role_popUp.php" ?>

<!-- Manager and General Service Contact Data -->

<!-- Show Contacts Button -->

<div>
    <button type="button" id="toggle_contacts" class="btn btn-primary btn-xs shadow" style=" margin-bottom: 10px;">SHOW CONTACTS</button><br>

    <!-- Contact Tables -->
    <div class="container-fluid">
        <div class="row" id="primary_contacts">

            <!-- Manager Contact Table -->
            <div class="col-md-6">
                <h3><strong>Managers</strong></h3>
                <div id="employee_manager_data"></div>
            </div>

            <!-- General Contact Table -->
            <div class="col-md-6">
                <!-- Add Button for Contact Table -->
                <?php if ($_SESSION['isAdmin']) : ?>
                    <button type="button" id="add_contact" class="btn btn-success btn-xs shadow" style="float:right;"><i class="fa fa-plus"> <STRONG>ADD CONTACT</STRONG> </i></button>
                <?php endif ?>
                <h3><strong>General Contact</strong></h3>
                <div id="contact_data"></div>
            </div>


        </div>
    </div>
</div>


<!-- Contact Pop-Up -->
<?php include "page/popup/contact_popUp.php" ?>
<hr>

<!-- Show Stats Table to Admin Only -->
<?php if ($_SESSION['isAdmin']) : ?>
    <div class="panel-body">
        <!-- Stats Table -->
        <div id="stats_data" class="table-responsive mb-3" style="width:100%;"></div>
    </div>
    <hr>
<?php endif ?>

<!-- Logged In Employee -->

<div class="panel-body">
    <!-- Logged In Employee Table -->
    <div id="loggedin_employee_data" class="table table-responsive" style="width:100%;"></div>
</div>

<div class="panel panel-default">

    <?php if ($_SESSION['isAdmin']) : ##<!-- Add Employee Button -->
    ?>
        <div class="mb-3" style="float:left;">
            <h2><a href="add.php" class="btn btn-success btn-xs shadow"> <i class="fa fa-plus"><strong> ADD EMPLOYEE </strong></i> </a></h2>
        </div>
    <?php endif ?>

    <!-- Status Filter -->
    <div class="status-filter" style="float:right; margin-left:10px; margin-bottom:10px; margin-top:10px; z-index: 3;">
        <label for="statusFilter"><strong>Filter By Status:</strong></label>
        <select name="statusFilter" id="statusFilter" data-width="210px" data-style="btn-primary btn-xs" class="form-control selectpicker">
            <option value=" ">Show All</option>
            <?php
            while ($statusFilter = mysqli_fetch_array($all_status)) :;
            ?>
                <option value="<?php echo $statusFilter["status"]; ?>"><?php echo $statusFilter["status"]; ?></option>
            <?php
            endwhile;
            ?>
        </select>
    </div>


    <!-- Team Filter -->
    <div class="team-filter" style="float:right; z-index: 2; margin-left:10px; margin-bottom:10px; margin-top:10px;">
        <label for="teamFilter"><strong>Filter By Team:</strong></label>
        <select name="teamFilter" id="teamFilter" data-width="210px" data-style="btn-primary btn-xs" class="form-control selectpicker">
            <option value=" ">Show All</option>
            <?php
            while ($teamFilter = mysqli_fetch_array($all_team)) :;
            ?>
                <option value="<?php echo $teamFilter["team"]; ?>"><?php echo $teamFilter["team"]; ?></option>
            <?php
            endwhile;
            ?>
        </select>
    </div>

    <!-- Search Box -->
    <div style="float:right; z-index: 1; margin-left:10px; margin-top:10px;">
        <input type="text" name="searchBox" placeholder="Search For Employee" maxlength="12" id="searchBox" class="form-control search input placeholder-glow">
    </div>

</div>

<Br><Br>

<div>
    <Br>
    <!-- Length Menu -->
    <div>
        <div style="float:left; margin-bottom:8px; margin-top:10px;">
            <span style="float:left;  line-height: 35px;">Show&nbsp;</span>
            <select id="lengthFilter" data-width="65px" data-style="btn-primary btn-xs" class="form-control selectpicker">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span style="float:right; line-height: 35px;">&nbsp;Entries</span>
        </div>
    </div>
    <!-- Employee Table -->
    <div id="employee_data" class="table table-responsive"></div>
</div>
<!-- Pop-Up (Update Status/Comment) -->
<?php include "page/popup/employee_popUp.php" ?>

<!-- Modal -->
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="logout" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="logout">Logout</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="lead">Are You Sure You Want to Logout?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <form action="page/logout.php" method="post" id="generatePasswordForm">
                    <button type="submit" class="btn btn-danger" name="logoutBtn" id="generatePasswordBtn">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php require_once "page/footer.php"; ?>