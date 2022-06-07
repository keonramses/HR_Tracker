$(document).ready(function(){

    // ----------------- FUNCTIONS --------------------------// 
    var bootstrapButton = $.fn.button.noConflict()
    $.fn.bootstrapBtn = bootstrapButton;


    // Hide/Show Person Manager table and Contact table
    $("#primary_contacts").hide();
    $("#toggle_contacts").click(function(){
        $("#primary_contacts").slideToggle('slow');
        $(this).text(function(i, text){
            return text === "HIDE CONTACTS" ? "SHOW CONTACTS" : "HIDE CONTACTS";
        })
    });

    // Scroll to the respective manager in the Employee table by clicking on the name in the Manager table
    // https://stackoverflow.com/questions/24739126/scroll-to-a-specific-element-using-html
    $(document).on('click', 'a[href^="#"]', function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 500);
        // https://stackoverflow.com/questions/3328640/how-to-highlight-a-div-for-a-few-seconds-using-jquery/3328713
        $($.attr(this,'href')).effect("highlight", {}, 5000);
    });

    // Clear/reset fields
    function clear(){
        $('#name').val('');
        $('#local').val('');
        $('#cell').val('');
        $('#status').val('NW');
        $('#comment').val('');
        $('#team').val('Administration');
        $('#isManager').val('No');
        $('#hasSpecialRole').val('No');
    }
	
	// Clear fields in the Contact form pop-up
    function clearContact(){
        $("#contactName").val('');
        $("#contactLocal").val('');
        $("#contactCell").val('');
    }

    // Hide unecessary fields quick status/comment edit
    function hideForEdit(){
        $('#name').prop("disabled",true);
        $('#local_hide').hide();
        $('#cell_hide').hide();
        $('#team_hide').hide();
        $('#isManager_hide').hide();
        $('#isSpecialRole_hide').hide();
    }

    // ------------------ POP-UP -----------------------------//

    // user pop-up
    $('#user_dialog').dialog({
        autoOpen: false,
        width:400
    });
	
	// Contact form pop-up
	$('#contact_dialog').dialog({
        autoOpen: false,
        width:400
    });

    // Outcome pop-up
    $('#action_alert').dialog({
        autoOpen:false
    });
	// Contact CRUD action outcome pop-up
    $('#actionContact_alert').dialog({
        autoOpen:false
    });

    // ------------------ FETCH -------------------------------//

    // Fetch employees from the employee database table that are managers, and populates the Employee Manager table
    function fetch_manager(){
        $.ajax({
            url:"database/db-fetch_manager.php",
            method:"POST",
            success:function(data){
                $("#employee_manager_data").html(data);
            }
        });
    }
    fetch_manager();

    // Fetch all employees from the employee database table, and populate the Employee html table
    function fetch_employee(){
        $.ajax({
            url:"database/db-fetch_employee.php",
            method:"POST",
            success:function(data){
                $("#employee_data").html(data);
            }
        });
    }
    fetch_employee();

    // Fetch logged in employee details from the employee database table, and populate the Employee html table
    function fetch_employee_loggedIn(){
        $.ajax({
            url:"database/db-fetch_employeeLogged.php",
            method:"POST",
            success:function(data){
                $("#loggedin_employee_data").html(data);
            }
        });
    }
    fetch_employee_loggedIn();

    // Fetch all roles from the Special Role database table, and populate the special role table
    function fetchRole(){
        $.ajax({
            url:"database/db-fetch_role.php",
            method:"POST",
            success:function(data){
                $("#role_data").html(data);
            }
        });
    }
    fetchRole();

    // Fetch employees from the employee database table that can be assigned a special role, and populate the dropdown list in the role form pop-up
    function fetchSpecialRole(){
        $.ajax({
            url:"database/db-fetch_hasSpecialRole.php",
            method:"POST",
            success:function(data){
                $("#hasSpecialRole").html(data);
            }
        });
    }
    fetchSpecialRole();


    // Fetch stats table
    function fetch_stats(){
        $.ajax({
            url:"database/db-fetch_stats.php",
            method:"POST",
            success:function(data){
                $("#stats_data").html(data);
            }
        });
    }
    fetch_stats();

    // ------------- Employee Table --------------------------------------//

    // Validate and then insert to database

    // please note that this is an internal validation that doesn't require user input
    // this is just to make sure that the popup loads the required data and also a framework
    // should we decide to make the add/edit functions popups in the future.
    
    $('#user_form').on('submit', function(event){
        event.preventDefault();

        // Validate Name
        var error_name = '';
        if($('#name').val() == '')
        {
            error_name = 'Name is required';
            $('#error_name').text(error_name);
            $('#name').css('border-color','#cc0000');
        }
        else
        {
            error_name = '';
            $('#error_name').text(error_name);
            $('#name').css('border-color','');
        }

        if(error_name == '')
        {
            $('#form_action').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"database/db-action_employee.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    $('#user_dialog').dialog('close');
                    $('#action_alert').html(data);
                    $('#action_alert').dialog('open');
                    fetch_employee();
                    fetch_employee_loggedIn()
                    fetch_stats();
                    $('#form_action').attr('disabled',false);
                }
            });
        }
    });

    // Fetch selected employee, populate fields in pop-up, and update employee details in database
    $(document).on('click','.update', function(){
        var id = $(this).attr("id");
        var action = 'fetch_single';
        $.ajax({
            url:"database/db-action_employee.php",
            method:"POST",
            data:{id:id, action:action},
            dataType:"json",
            success:function(data){
                $('#role_dialog').dialog('close');
                $('#contact_dialog').dialog('close');
                $('#name').val(data.name);
                $('#status').val(data.status);
                $('#comment').val(data.comment);

                $('#action').val('update');
                $('#hidden_id').val(id);
                $('#form_action').val('Update');
                $('#user_dialog').dialog('open');
                hideForEdit();
            }
        });
    });

    // ------------- Special Role Table--------------------------------------//

    // role pop-up
    $('#role_dialog').dialog({
        autoOpen: false,
        width:400
    });

    // Role CRUD action outcome pop-up 
    $('#actionRole_alert').dialog({
        autoOpen:false
    });

    // Add Role button clicked
    $("#assign_role").click(function(){
        $('#user_dialog').dialog('close');
        $('#contact_dialog').dialog('close');
        $('#actionRole_alert').dialog('close');
        $("#roleName").prop("disabled",false);
        $('#role_dialog').dialog('option', 'title', 'New Role Assignment');
        $('#actionRole').val('insertRole');
        $('#form_actionRole').val("Assign Role");
        $('#role_dialog').dialog('open');
        fetchSpecialRole();
    });

    // Assign a role 
    $('#role_form').on('submit', function(event){
        event.preventDefault();

        // Validate Role Name (not really needed)
        var error_roleName = '';
        if($('#roleName').val() == '')
        {
            error_roleName = 'Role Name is required';
            $('#error_roleName').text(error_roleName);
            $('#roleName').css('border-color','#cc0000');
        }
        else
        {
            error_roleName = '';
            $('#error_roleName').text(error_roleName);
            $('#roleName').css('border-color','');
        }

        if(error_roleName == '')
        {
            $('#form_actionRole').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"database/db-action_role.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    $('#role_dialog').dialog('close');
                    $('#actionRole_alert').html(data);
                    $('#actionRole_alert').dialog('open'); //Alerts
                    fetchRole();
                    $('#form_actionRole').attr('disabled',false);
                }
            });
        }
    });

     // Update an existing role assignment
     $(document).on('click','.update_role', function(){
        var roleID = $(this).attr("id");
        var actionRole = 'fetch_singleRole';
        $.ajax({
            url:"database/db-action_role.php",
            method:"POST",
            data:{roleID:roleID, actionRole:actionRole},
            dataType:"json",
            success:function(data){
                $('#user_dialog').dialog('close');
                $('#contact_dialog').dialog('close');
                $('#actionRole_alert').dialog('close')
                $('#roleName').val(data.roleName);
                $('#hasSpecialRole').val(data.assignedTo);

                $('#role_dialog').dialog('option', 'title', 'Update Role Assignment');
                $('#actionRole').val('updateRole');
                $('#hidden_roleID').val(roleID);
                $('#form_actionRole').val('Update Role');
                $('#role_dialog').dialog('open');
                $("#roleName").prop("disabled",true);
            }
        });
    });

    // Delete an existing role from the Role table
    $('#deleteRole_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var roleID = $(this).data('roleID');
				var actionRole = 'deleteRole';
				$.ajax({
					url:"database/db-action_role.php",
					method:"POST",
					data:{roleID:roleID, actionRole:actionRole},
					success:function(data)
					{
						$('#deleteRole_confirmation').dialog('close');
						$('#actionRole_alert').html(data);
						//$('#actionRole_alert').dialog('open'); //Role Deleted Alert
                        fetchRole();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete_role', function(){
		var roleID = $(this).attr("id");
        $('#user_dialog').dialog('close');
        $('#contact_dialog').dialog('close');
        $('#actionRole_alert').dialog('close')
		$('#deleteRole_confirmation').data('roleID', roleID).dialog('open');
	});
	
	
	 // --------------- Contact Table --------------------------------------

    // Fetch contacts from the Contact database table that are managers, and populate the Contact table
    function fetchContact(){
        $.ajax({
            url:"database/db-fetch_contact.php",
            method:"POST",
            success:function(data){
                $("#contact_data").html(data);
            }
        });
    }
    fetchContact();

    // --------------- INSERT -----------------------------------------

    // Add Contact button clicked
    $("#add_contact").click(function(){
        $('#user_dialog').dialog('close');
        $('#role_dialog').dialog('close');
        clearContact();
        $('#contact_dialog').dialog('option', 'title', 'Add New Contact');
        $('#actionContact').val('insertContact');
        $('#form_actionContact').val("Add Contact");
        $('#contact_dialog').dialog('open');
    });

    // Insert new contact into Contact table
    $('#contact_form').on('submit', function(event){
        event.preventDefault();

        // Validate Contact Name
        var error_contactName = '';
        if($('#contactName').val() == '')
        {
            error_contactName = 'Contact Name is required';
            $('#error_contactName').text(error_contactName);
            $('#contactName').css('border-color','#cc0000');
        }
        else
        {
            error_contactName = '';
            $('#error_contactName').text(error_contactName);
            $('#contactName').css('border-color','');
        }

        // Validate Contact Local
        var error_contactLocal = '';
        if($('#contactLocal').val() == '')
        {
            error_contactLocal = 'Contact Local number is required';
            $('#error_contactLocal').text(error_contactLocal);
            $('#contactLocal').css('border-color','#cc0000');
        }
        else
        {
            error_contactLocal = '';
            $('#error_contactLocal').text(error_contactLocal);
            $('#contactLocal').css('border-color','');
        }

         // Validate Contact Cell
         var error_contactCell = '';
         if($('#contactCell').val() == '')
         {
             error_contactCell = 'Contact Cell number is required';
             $('#error_contactCell').text(error_contactCell);
             $('#contactCell').css('border-color','#cc0000');
         }
         else
         {
             error_contactCell = '';
             $('#error_contactCell').text(error_contactCell);
             $('#contactCell').css('border-color','');
         }

        if(error_contactName == '' && error_contactLocal == '' && error_contactCell == '' )
        {
            $('#form_actionContact').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"database/db-action_contact.php",
                method:"POST",
                data:form_data,
                success:function(data)
                {
                    $('#contact_dialog').dialog('close');
                    $('#actionContact_alert').html(data);
                    $('#actionContact_alert').dialog('open');
                    fetchContact();
                    $('#form_actionContact').attr('disabled',false);
                }
            });
        }
    });

    // ------------------ UPDATE -----------------------------------

    // Update existing contact in the Contact table
    $(document).on('click','.update_contact', function(){
        var contactID = $(this).attr("id");
        var actionContact = 'fetch_singleContact';
        $.ajax({
            url:"database/db-action_contact.php",
            method:"POST",
            data:{contactID:contactID, actionContact:actionContact},
            dataType:"json",
            success:function(data){
                $('#user_dialog').dialog('close');
                $('#role_dialog').dialog('close');
                $('#actionRole_alert').dialog('close')
                $('#contactName').val(data.contactName);
                $('#contactLocal').val(data.contactLocal);
                $('#contactCell').val(data.contactCell);
                $('#contact_dialog').dialog('option', 'title', 'Update Existing Contact');
                $('#actionContact').val('updateContact');
                $('#hidden_contactID').val(contactID);
                $('#form_actionContact').val('Update Contact');
                $('#contact_dialog').dialog('open');
            }
        });
    });

    // ------------------------- DELETE --------------------------------

    // Delete an existing contact from the Contact table
    $('#deleteContact_confirmation').dialog({
		autoOpen:false,
		modal: true,
		buttons:{
			Ok : function(){
				var contactID = $(this).data('contactID');
				var actionContact = 'deleteContact';
				$.ajax({
					url:"database/db-action_contact.php",
					method:"POST",
					data:{contactID:contactID, actionContact:actionContact},
					success:function(data)
					{
						$('#deleteContact_confirmation').dialog('close');
						$('#actionContact_alert').html(data);
						//$('#actionContact_alert').dialog('open'); //Action confirmation Disabled
                        fetchContact();
					}
				});
			},
			Cancel : function(){
				$(this).dialog('close');
			}
		}	
	});
	
	$(document).on('click', '.delete_contact', function(){
		var contactID = $(this).attr("id");
        $('#user_dialog').dialog('close');
        $('#role_dialog').dialog('close');
        $('#actionRole_alert').dialog('close')
		$('#deleteContact_confirmation').data('contactID', contactID).dialog('open');
	});


  

});