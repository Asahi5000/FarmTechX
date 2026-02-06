<!-- Edit User Modal -->
<div id="editForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditForm()">&times;</span>
        <h3>Edit User</h3>
        <form method="POST" action="../assets/php/action/edit-user-action.php">
            <input type="hidden" name="id" id="edit_id">

            <label>Name</label>
            <input type="text" name="name" id="edit_name" required><br>

            <label>Username</label>
            <input type="text" name="username" id="edit_username" required><br>

            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password"><br>

            <button type="submit" name="edit_user">Update</button>
            <button type="button" onclick="closeEditForm()">Cancel</button>
        </form>
    </div>
</div>
