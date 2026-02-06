// ===== API URLs =====
const soilAPI = "http://192.168.1.11/FarmTechX/assets/php/api/soil-read.php";
const rainAPI = "http://192.168.1.11/FarmTechX/assets/php/api/rain-read.php";

// ===== Load Soil Data =====
async function loadSoilData() {
  try {
    const res = await fetch(`${soilAPI}?t=${Date.now()}`);
    if (!res.ok) throw new Error("Network error " + res.status);
    const data = await res.json();

    document.getElementById("soilecvalue").innerText = data.ec ?? "--";
    document.getElementById("soilphvalue").innerText = data.ph ?? "--";
    document.getElementById("moistureValue").innerText = data.moisture ?? "--";
    document.getElementById("temperatureValue").innerText = data.temperature ?? "--";
    document.getElementById("soillastUpdate").innerText =
      "Updated: " + (data.updated_at ?? "--");

  } catch (err) {
    console.error("Soil API error:", err);

    document.getElementById("soilecvalue").innerText = "--";
    document.getElementById("soilphvalue").innerText = "--";
    document.getElementById("moistureValue").innerText = "--";
    document.getElementById("temperatureValue").innerText = "--";
    document.getElementById("soillastUpdate").innerText = "Updated: --";
  }
}

// ===== Load Rain Data =====
async function loadRainData() {
  try {
    const res = await fetch(`${rainAPI}?t=${Date.now()}`);
    if (!res.ok) throw new Error("Network error " + res.status);
    const data = await res.json();

    document.getElementById("rainStatus").innerText =
      data.is_raining == 1 ? "YES" : "NO";

    document.getElementById("rainIntensity").innerText =
      data.intensity ?? "--";

    document.getElementById("rainlastUpdate").innerText =
      "Updated: " + (data.created_at ?? "--");

  } catch (err) {
    console.error("Rain API error:", err);

    document.getElementById("rainStatus").innerText = "--";
    document.getElementById("rainIntensity").innerText = "--";
    document.getElementById("rainlastUpdate").innerText = "Updated: --";
  }
}

// ===== Initial Load =====
loadSoilData();
loadRainData();

// ===== Auto Refresh Every 2 Seconds =====
setInterval(() => {
  loadSoilData();
  loadRainData();
}, 2000);
