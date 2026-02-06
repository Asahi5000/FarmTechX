<!-- Delete User Modal -->
<div id="deleteForm" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeDeleteForm()">&times;</span>
        <h3>Delete User</h3>
        <p id="delete_message">Are you sure you want to delete this user?</p>

        <form method="POST" action="../assets/php/action/delete-user-action.php">
            <!-- User ID will be inserted by JS -->
            <input type="hidden" name="delete_id" id="delete_id">

            <div class="modal-actions">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <button type="button" class="btn btn-secondary" onclick="closeDeleteForm()">Cancel</button>
            </div>
        </form>
    </div>
</div>


