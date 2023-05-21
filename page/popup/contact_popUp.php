<div class="form-group row" id="contact_dialog">
    <form action="post" id="contact_form">
        <!-- Contact Name -->
        <div class="mb-3">
            <label for="contactName">Contact Name</label>
            <input type="text" name="contactName" id="contactName" class="form-control">
            <span id="error_contactName" class="text-danger"></span>
        </div>
        <!-- Contact Local -->
        <div class="mb-3">
            <label for="contactLocal">Contact Local</label>
            <input type="text" name="contactLocal" id="contactLocal" class="form-control">
            <span id="error_contactLocal" class="text-danger"></span>
        </div>
        <!-- Contact Cell -->
        <div class="mb-3">
            <label for="contactCell">Contact Cell</label>
            <input type="text" name="contactCell" id="contactCell" class="form-control">
            <span id="error_contactCell" class="text-danger"></span>
        </div>
        <!-- Contact Submit -->
        <div>
            <input type="hidden" name="actionContact" id="actionContact" value="insertContact" />
            <input type="hidden" name="hidden_contactID" id="hidden_contactID" />
            <input type="submit" name="form_actionContact" id="form_actionContact" class="btn btn-primary btn-xs shadow" value="Insert Contact" />
        </div>
    </form>
    <div id="actionContact_alert" title="(!) Notice"></div>
    <div id="deleteContact_confirmation" title="Delete Confirmation">
        <p>Are you sure you want to delete this contact?</p>
    </div>
</div>