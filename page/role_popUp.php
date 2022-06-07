<div class="form-group row" id="role_dialog" title="Update Role Data">
    <form action="post" id="role_form">
        <!-- Role -->
        <div class="mb-3">
            <label for="roleName">Role</label>
            <select name="roleName" id="roleName" class="form-select">
                <option value="Coordinator">Coordinator</option>
                <option value="First Aid Officer">First Aid Officer</option>
                <option value="Inventory Manager">Inventory Manager</option>
                <option value="Key Holder">Key Holder</option>
                <option value="Supervisor">Supervisor</option>
            </select>
        </div>
        <!-- Has Special Role -->
        <div class="mb-3">
            <label for="hasSpecialRole">Assign To</label>
            <select name="hasSpecialRole" id="hasSpecialRole" class="form-select"></select>
        </div>
        <!-- Submit -->
        <div>
            <input type="hidden" name="actionRole" id="actionRole" value="assignRole" />
			<input type="hidden" name="hidden_roleID" id="hidden_roleID" />
			<input type="submit" name="form_actionRole" id="form_actionRole" class="btn btn-primary btn-xs shadow" value="Insert Role" />
        </div>
    </form>
    <div id="actionRole_alert" title="(!) Notice"></div>
    <div id="deleteRole_confirmation" title="(!) Remove Role Assignment">
        <p>Are you sure you want to remove this role assignment?</p>
    </div>
</div>