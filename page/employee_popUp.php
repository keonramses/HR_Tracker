<div class= "form-group row" id="user_dialog" title="Update Status/Comment">
    <form action="post" id="user_form" >
        <!-- Name -->
        <div class="mb-3" id="name_hide">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">
            <span id="error_name" class="text-danger"></span> 
        </div>
        <!-- Status -->
        <div class="mb-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-select">
                    <option value="In">In</option>
                    <option value="Break">Break</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Out">Out</option>
            </select>
        </div>
        <!-- Comment -->
        <div class="mb-3">
            <label for="comment">Comment</label>
            <textarea type="text" name="comment" id="comment" class="form-control"></textarea>
        </div>
        <!-- Submit -->
        <div class="form-group">
            <input type="hidden" name="action" id="action" value="insert" />
			<input type="hidden" name="hidden_id" id="hidden_id" />
			<input type="submit" name="form_action" id="form_action" class="btn btn-primary btn-xs shadow" value="Insert" />
        </div>
    </form>
</div>