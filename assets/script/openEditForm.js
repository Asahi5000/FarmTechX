/* ---------- Edit User Modal ---------- */
function openEditForm(id, username) {
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_username").value = username;
    document.getElementById("editForm").style.display = "flex";
}
function closeEditForm() {
    document.getElementById("editForm").style.display = "none";
}

/* ---------- Close if click outside ---------- */
window.onclick = function(event) {

    let editModal = document.getElementById("editForm");
    if (event.target === editModal) closeEditForm();
}