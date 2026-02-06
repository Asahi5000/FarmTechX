<?php
require '../authenticator.php';
require '../config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>FarmTechX Admin History</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/history.css" />
    <link rel="stylesheet" href="../assets/css/lowerR-bg.css" />
    <link rel="icon" href="../assets/images/FarmTechX.jpg" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
  body { font-family: Arial, sans-serif; padding: 20px; }
  table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
  th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
  .pagination { display: flex; gap: 5px; flex-wrap: wrap; }
  .pagination button { padding: 5px 10px; cursor: pointer; }
  .pagination button.active { background-color: #007BFF; color: white; }
  .pagination button:disabled { opacity: 0.5; cursor: not-allowed; }
</style>
</head>

<body>
    <div class="main-container">
        <?php include '../assets/php/hamburder-menu.php'; ?>    
        <?php include '../assets/php/sidebar-history.php'; ?>
        
    <main class="main-content">
      <div class="content-wrapper">
        <?php include '../assets/php/welcome-card-history.php'; ?>

<!-- Filters -->
<div class="filter-bar mb-3" novalidate>
  <button class="btn filter-btn" data-filter="day">Today</button>
  <button class="btn filter-btn" data-filter="week">This Week</button>
  <button class="btn filter-btn" data-filter="month">This Month</button>

  <input type="date" id="start_date" class="form-control">
  <input type="date" id="end_date" class="form-control">

  <button class="btn" id="applyRange">Apply Range</button>
</div>



        <!-- Graph -->
        <div class="card mb-3">
          <div class="card-body">
            <canvas id="sensorChart" height="100"></canvas>
          </div>
        </div>

        <!-- Table -->
        <div class="card">
          <div class="card-body">
            <div>
  <label for="pageSize">Records per page:</label>
  <select id="pageSize">
    <option value="50" selected>50</option>
    <option value="100">100</option>
    <option value="200">200</option>
    <option value="500">500</option>
  </select>
   <div id="pagination" class="mt-3 d-flex justify-content-center align-items-center"></div>
</div>
            <table class="table table-striped" id="sensorTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Temperature (°C)</th>
                  <th>EC</th>
                  <th>pH</th>
                  <th>Recorded At</th>
                </tr>
              </thead>
              <tbody></tbody>

            </table>
                         

          </div>
        </div>
      </div>
    </main>
    </div>




    
<img src="../assets/images/lowerR-bg.png" alt="lowerR-bg" class="lowerR-bg">



<script src="../assets/script/activeLink.js"></script>
<script src="../assets/script/navClicks.js"></script>
<script src="../assets/script/closeSidebar.js"></script>
<script src="../assets/script/toggleSidebar.js"></script>
<script src="../assets/script/preventCache.js"></script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (required for modals, dropdowns, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your JS file -->
<script src="assets/js/history.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="../assets/script/history.js"></script>
<script>
document.getElementById('applyRange').addEventListener('click', function() {
  const startDate = document.getElementById('start_date').value;
  const endDate = document.getElementById('end_date').value;

  if (!startDate || !endDate) {
    // Show modal instead of browser alert
    const myModal = new bootstrap.Modal(document.getElementById('dateModal'));
    myModal.show();
  } else {
    // Proceed with applying date range
    console.log("Applying range:", startDate, "to", endDate);
    // Add your actual range logic here
  }
});
</script>

<!-- Missing Date Modal -->
<div class="modal fade" id="missingDateModal" tabindex="-1" aria-labelledby="missingDateLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="missingDateLabel">Incomplete Date Range</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Please select both start and end dates.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>