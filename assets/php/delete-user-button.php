<!-- DELETE BUTTON (hidden for default Admin and for Staff role) -->
<?php
$defaultAdmin = ($row['role'] === 'Admin' && strtolower($row['username']) === 'admin');

if ($_SESSION['role'] === 'Admin' && !$defaultAdmin): ?>
    <a href="javascript:void(0)" 
       onclick="openDeleteForm(<?php echo $row['id']; ?>, '<?php echo addslashes($row['username']); ?>')">
       <i class='bx bxs-trash'></i>
    </a>
<?php endif; ?>
