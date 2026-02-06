<?php
require '../authenticator.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>FarmTechX Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/styles.css" />
    <link rel="stylesheet" href="../assets/css/sensors2.css" />
    <link rel="stylesheet" href="../assets/css/switch2.css" />
    <link rel="stylesheet" href="../assets/css/lowerR-bg.css" />
    <link rel="icon" href="../assets/images/FarmTechX.jpg" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>


<body>
    <div class="main-container">
      <?php include '../assets/php/hamburder-menu.php'; ?>      
      <?php include '../assets/php/sidebar-dashboard.php'; ?>
        
      <main class="main-content">
            
        <div class="content-wrapper">
          <?php include '../assets/php/welcome-card-dashboard.php'; ?>
                
          <section>
            <h2 class="sensors-title">Sensors</h2>
                    
            
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class= "sensor-values">
<div class="cards">
  <div class="card">🌡 Water Temperature: <span id="tempValue">--</span></div>
  <div class="card">💧 Electric Conductivity (EC): <span id="ecValue">--</span></div>
  <div class="card">🧂 Total Dissolved Solids (TDS): <span id="tdsValue">--</span></div>
  <div class="card">🧪 Potential Hydrogen (pH): <span id="phValue">--</span></div>
  <div class="card"><span id="lastUpdate">Updated: --</span></div>
</div>
</div>

            <div class="Graph-title">
              <h2>Sensors Graph</h2>
            </div>

            <canvas id="sensorChart"></canvas>
            
<div class="plot-section">
  <h3 class="plot-title">Probe</h3>
  <h4 class="soil-tester-title">Soil Reading</h4>

<div class="cards">
  <div class="card">💧 EC: <span id="soilecvalue">--</span></div>
  <div class="card">🧪 pH: <span id="soilphvalue">--</span></div>
  <div class="card">🌱 Moisture: <span id="moistureValue">--</span></div>
  <div class="card">🌡 Temperature: <span id="temperatureValue">--</span></div>
  <div class="card"><span id="soillastUpdate">🕒Updated: --</span></div>

<div class="card">
  🌧 Rain Status
  <div class="value" id="rainStatus">--</div>
</div>

<div class="card">
  🌧 Rain Intensity
  <div class="value" id="rainIntensity">--</div>
</div>

<div class="card">
  <!--🕒 Last Update-->
  <div class="value" id="rainlastUpdate">--</div>
</div>

</div>



        
                        
              <!--<button class="add-plot-btn">Add Probe</button> -->
            </div>
          </section>



        <!-- Irrigation Control -->
        <section>
          <h2 class="sensors-title">Irrigation Control</h2>

          <!-- Switch -->
          <div class="switch-container">
            <span class="switch-label">Switch:</span>
            <label class="switch">
              <input type="checkbox" id="modeToggle">
              <span class="slider"></span>
            </label>
          </div>

          <!-- Manual Mode -->
          <div class="section" id="manualMode">
            <h2>Manual Mode</h2>


            <!-- Pump Control -->
            <div class="pump-control">
<!-- Main Water Pump -->
<button id="pumpToggle" onclick="togglePump()">
  <span class="btn-text">Turn Water Pump ON</span>
  <span class="spinner hidden"></span>
</button>

<div>Status: 
  <span id="pumpStatus" style="color: white;">OFF</span>
  <span id="pumpTimer" style="margin-left:10px;color:red;"></span>
</div>

<div class="mainpump-duration">
  <label for="mainPumpDuration">Pump Duration:</label>
  <input type="number" id="mainPumpDuration" min="0" max="120" value="10" step="1"> minutes
  <input type="number" id="mainPumpDurationSec" min="0" max="59" value="0" step="1"> seconds
</div>


<h3>Dosing Pump Controls</h3>

<div class="dosing-panel">

  <div class="dosing-row">
    <span style="color:black;">Duration:</span>
    <input type="number" id="dosingDurationA" value="1" min="0"> min
    <input type="number" id="dosingDurationASec" value="0" min="0" max="59"> sec

    <button id="dosingToggleA" onclick="toggleDosingPump('A')">
      <span class="btn-text">Turn Pump A ON</span>
      <span class="spinner hidden"></span>
    </button>

    <span style="color:black;">Status</span>
    <span id="pumpAStatus" class="pump-status pump-off">OFF</span>
    <span id="pumpATimer" class="pump-timer" style="margin-left:10px;color:red;"></span>
  </div>

  <div class="dosing-row">
    <span style="color:black;">Duration:</span>
    <input type="number" id="dosingDurationB" value="1" min="0"> min
    <input type="number" id="dosingDurationBSec" value="0" min="0" max="59"> sec

    <button id="dosingToggleB" onclick="toggleDosingPump('B')">
      <span class="btn-text">Turn Pump B ON</span>
      <span class="spinner hidden"></span>
    </button>

    <span style="color:black;">Status</span>
    <span id="pumpBStatus" class="pump-status pump-off">OFF</span>
    <span id="pumpBTimer" class="pump-timer" style="margin-left:10px;color:red;"></span>
  </div>

  <div class="dosing-row">
    <span style="color:black;">Duration:</span>
    <input type="number" id="dosingDurationC" value="1" min="0"> min
    <input type="number" id="dosingDurationCSec" value="0" min="0" max="59"> sec

    <button id="dosingToggleC" onclick="toggleDosingPump('C')">
      <span class="btn-text">Turn Pump C ON</span>
      <span class="spinner hidden"></span>
    </button>

    <span style="color:black;">Status</span>
    <span id="pumpCStatus" class="pump-status pump-off">OFF</span>
    <span id="pumpCTimer" class="pump-timer" style="margin-left:10px;color:red;"></span>
  </div>
</div>


            </div>
          </div>





<div class="section" id="automationMode" style="display:none;">
  <h2>Automation Mode</h2>
  <form class="automation-form" id="scheduleForm">

    <label>Select Time:</label>
    <div class="time-select">
      Hour
      <select id="auto_hour" name="hour" required>
        <option value="1">1</option><option value="2">2</option><option value="3">3</option>
        <option value="4">4</option><option value="5">5</option><option value="6">6</option>
        <option value="7">7</option><option value="8">8</option>
        <option value="9">9</option><option value="10">10</option><option value="11">11</option>
        <option value="12">12</option>
      </select>
      Minute
<select id="auto_minute" name="minute" required>
  <!-- Generate options 0-59 -->
  <script>
    for (let i = 0; i < 60; i++) {
      const val = i.toString().padStart(2,'0');
      document.write(`<option value="${val}">${val}</option>`);
    }
  </script>
</select>

      <select id="auto_ampm" name="ampm" required>
        <option value="AM">AM</option>
        <option value="PM">PM</option>
      </select>
    </div>

    <label for="auto_mainPumpDuration">Water Pump Duration (minutes):</label>
    <input type="number" id="auto_mainPumpDuration" name="water_pump_duration" min="1" max="120" step="1" value="10">

    <button type="submit">Add Schedule</button>
  
  </form>

  <table id="scheduleTable">
    <thead>
      <tr>
        <th>Time</th>
        <th>Duration</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>

        </section>


        </div>
        
      </main>
      
    </div>
<img src="../assets/images/lowerR-bg.png" alt="lowerR-bg" class="lowerR-bg">





<script src="../assets/script/dashboardSwitch2.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../assets/script/fetchDashboardSensors.js"></script>

<script src="../assets/script/activeLink.js"></script>
<script src="../assets/script/navClicks.js"></script>
<script src="../assets/script/closeSidebar.js"></script>
<script src="../assets/script/toggleSidebar.js"></script>
 <!-- <script src="../assets/script/addPlot.js"></script>-->
<script src="../assets/script/preventCache.js"></script>
<script src="../assets/script/soil-dashboard.js"></script>



</body>
</html>