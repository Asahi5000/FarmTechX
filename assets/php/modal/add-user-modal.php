<!-- Add User Modal -->
<div id="addForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddForm()">&times;</span>
        <h3>Add New User</h3>
        <form method="POST" action="../assets/php/action/add-user-action.php">
            <label>Role</label>
            <select name="role" required>
                <option value="Admin">Admin</option>
                <option value="Staff">Staff</option>
            </select><br>

            <label>Name</label>
            <input type="text" name="name" required><br>

            <label>Username</label>
            <input type="text" name="username" required><br>

            <label>Password</label>
            <input type="password" name="password" required><br>

            <button type="submit" name="add_user">Save</button>
            <button type="button" onclick="closeAddForm()">Cancel</button>
        </form>
    </div>
</div>
