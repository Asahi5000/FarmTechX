<!-- EDIT BUTTON (only for Admin users, including default admin) -->
<?php if ($_SESSION['role'] === 'Admin'): ?>
    <a href="javascript:void(0)" 
       onclick="openEditForm('<?php echo $row['id']; ?>',
                             '<?php echo $row['username']; ?>',
                             '<?php echo $row['role']; ?>')">
        <i class='bx bxs-edit'></i>
    </a>
<?php endif; ?>
