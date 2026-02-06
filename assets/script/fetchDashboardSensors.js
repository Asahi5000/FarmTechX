let chart;

async function fetchCurrentSensors() {
  const response = await fetch("../assets/php/api/get-sensors.php");
  const text = await response.text();
  console.log("Raw API response (get-sensors):", text);

  try {
    const data = JSON.parse(text);
if (data.status === "ok") {
  document.getElementById("tempValue").innerText = data.temperature + " °C";
  document.getElementById("ecValue").innerText = data.ec + " mS/cm";
  document.getElementById("tdsValue").innerText = data.tds + " ppm";
  document.getElementById("phValue").innerText = data.ph + " pH";
  document.getElementById("lastUpdate").innerText = "Updated: " + data.created_at;
}

  } catch (err) {
    console.error("❌ JSON parse error in get-sensors:", err);
  }
}

async function fetchSensorHistory() {
  const response = await fetch("../assets/php/api/get-sensors-history.php");
  const result = await response.json();

  if (result.status === "ok") {
    const labels = result.data.map(item => item.created_at);
    const temps = result.data.map(item => item.temperature);
    const ecs = result.data.map(item => item.ec);
    const phs = result.data.map(item => item.ph);



    if (!chart) {
      const ctx = document.getElementById("sensorChart").getContext("2d");
      chart = new Chart(ctx, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "Temperature (°C)",
              data: temps,
              borderColor: "#007bff",
              backgroundColor: "rgba(63, 5, 5, 0.1)",
              fill: true,
              yAxisID: "y"
            },
            {
              label: "EC (mS/cm)",
              data: ecs,
              borderColor: "#28a745",
              backgroundColor: "rgba(40,167,69,0.1)",
              fill: true,
              yAxisID: "y1"
            },
            {
              label: "pH",
              data: phs,
              borderColor: "#ff5733",
              backgroundColor: "rgba(255,87,51,0.1)",
              fill: true,
              yAxisID: "y2"
            },


          ]
        },
        options: {
          responsive: true,
          interaction: { mode: "index", intersect: false },
          plugins: { 
            legend: { 
              display: true,
              labels: {
                font: {
                  size: 16, // bigger font
                  weight: 'bold'
                },
                boxWidth: 30, // bigger color box
                boxHeight: 15, // taller color box
                padding: 20 // more space between items
              }
            } 
          },
          scales: {
            y: { type: "linear", position: "left", title: { display: true, text: "°C" }},
            y1: { type: "linear", position: "right", title: { display: true, text: "EC (mS/cm)" }, grid: { drawOnChartArea: false }},
            y2: { type: "linear", position: "right", title: { display: true, text: "pH" }, grid: { drawOnChartArea: false }, min: 0, max: 14 },

          }
        }
      });
    } else {
      chart.data.labels = labels;
chart.data.datasets[0].data = temps;
chart.data.datasets[1].data = ecs;
chart.data.datasets[2].data = phs;

chart.update();

    }
  }
}

setInterval(() => {
  fetchCurrentSensors();
  fetchSensorHistory();
}, 1000);

fetchCurrentSensors();
fetchSensorHistory();