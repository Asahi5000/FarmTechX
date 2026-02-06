/* ---------- Add User Modal ---------- */
function openAddForm() {
    document.getElementById("addForm").style.display = "flex";
}
function closeAddForm() {
    document.getElementById("addForm").style.display = "none";
}

/* ---------- Close if click outside ---------- */
window.onclick = function(event) {
    let addModal = document.getElementById("addForm");

    if (event.target === addModal) closeAddForm();

}
