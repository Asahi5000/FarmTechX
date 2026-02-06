document.addEventListener("DOMContentLoaded", () => {
  // ====== CONFIG ======
  const serverIP = "192.168.1.11"; 
  const pumpPHP = `http://${serverIP}/FarmTechX/assets/php/api/pump-control.php`;
  const dosingPumpPHP = `http://${serverIP}/FarmTechX/assets/php/api/dosing-pump.php`;
  const addSchedulePHP = `http://${serverIP}/FarmTechX/assets/php/api/add-schedule.php`;
  const getSchedulePHP = `http://${serverIP}/FarmTechX/assets/php/api/get-schedule.php`;
  const deleteSchedulePHP = `http://${serverIP}/FarmTechX/assets/php/api/delete-schedule.php`;

  // ====== ELEMENTS ======
  const modeToggle = document.getElementById('modeToggle');
  const manualMode = document.getElementById('manualMode');
  const automationMode = document.getElementById('automationMode');
  const scheduleForm = document.getElementById("scheduleForm");
  const scheduleTableBody = document.querySelector("#scheduleTable tbody");

  const autoHour = document.getElementById("auto_hour");
  const autoMinute = document.getElementById("auto_minute");
  const autoAMPM = document.getElementById("auto_ampm");
  const autoDuration = document.getElementById("auto_mainPumpDuration");

  const pumpButton = document.getElementById("pumpToggle");
  const pumpStatusEl = document.getElementById("pumpStatus");
  const pumpTimerEl = document.getElementById("pumpTimer");
  const mainPumpDurationInput = document.getElementById("mainPumpDuration");
  const mainPumpDurationSecInput = document.getElementById("mainPumpDurationSec");

  const dosingPumps = { A:false, B:false, C:false };
  const dosingElements = {};
  ['A','B','C'].forEach(p => {
    dosingElements[p] = {
      button: document.getElementById(`dosingToggle${p}`),
      status: document.getElementById(`pump${p}Status`),
      timer: document.getElementById(`pump${p}Timer`),
      durationInput: document.getElementById(`dosingDuration${p}`),
      durationSecInput: document.getElementById(`dosingDuration${p}Sec`)
    };
  });

  let pumpOn = false;
  let scheduleToDelete = null;

  // ====== UTILS ======
  function getTotalSeconds(minInput, secInput) {
    return (parseInt(minInput.value)||0)*60 + (parseInt(secInput.value)||0);
  }

  function startCountdownFromEndTime(endTimeMs, timerEl, onEnd) {
    clearInterval(timerEl._interval);
    const formatTime = sec => `${String(Math.floor(sec/60)).padStart(2,'0')}:${String(sec%60).padStart(2,'0')}`;
    timerEl._interval = setInterval(() => {
      const remaining = Math.max(Math.floor((endTimeMs-Date.now())/1000),0);
      timerEl.innerText = remaining>0 ? formatTime(remaining) : "";
      if (remaining <= 0) { 
        clearInterval(timerEl._interval); 
        onEnd?.(); 
      }
    }, 1000);
  }

  // ====== MODAL ======
// ====== MODAL ======
function showModal(message, onConfirm) {
  // Create overlay
  const modalOverlay = document.createElement("div");
  modalOverlay.style = `
    position: fixed; top:0; left:0; width:100%; height:100%;
    background: rgba(0,0,0,0.4); display:flex; justify-content:center; align-items:center;
    z-index: 9999;
  `;

  // Modal box
  const modalBox = document.createElement("div");
  modalBox.style = `
    background: #fff; color:#333; padding: 20px; border-radius: 10px; text-align:center;
    min-width: 320px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); font-family: Arial, sans-serif;
  `;

  const msg = document.createElement("p");
  msg.innerText = message;
  msg.style.marginBottom = "20px";
  msg.style.fontSize = "16px";

  // Buttons container
  const btnContainer = document.createElement("div");
  btnContainer.style = "display:flex; justify-content:center; gap:10px;";

  // Confirm button (green)
  const btnConfirm = document.createElement("button");
  btnConfirm.innerText = "Ok";
  btnConfirm.style = `
    background-color: #28a745; color: white; border:none; padding:8px 16px;
    border-radius:5px; cursor:pointer; font-weight:bold;
  `;
  btnConfirm.addEventListener("mouseenter", () => btnConfirm.style.opacity = 0.8);
  btnConfirm.addEventListener("mouseleave", () => btnConfirm.style.opacity = 1);

  // Cancel button (white with green border)
  const btnCancel = document.createElement("button");
  btnCancel.innerText = "Cancel";
  btnCancel.style = `
    background-color: #fff; color: #28a745; border: 2px solid #28a745;
    padding:8px 16px; border-radius:5px; cursor:pointer; font-weight:bold;
  `;
  btnCancel.addEventListener("mouseenter", () => btnCancel.style.opacity = 0.8);
  btnCancel.addEventListener("mouseleave", () => btnCancel.style.opacity = 1);

  btnConfirm.addEventListener("click", () => {
    onConfirm();
    document.body.removeChild(modalOverlay);
  });

  btnCancel.addEventListener("click", () => document.body.removeChild(modalOverlay));

  btnContainer.appendChild(btnConfirm);
  btnContainer.appendChild(btnCancel);
  modalBox.appendChild(msg);
  modalBox.appendChild(btnContainer);
  modalOverlay.appendChild(modalBox);
  document.body.appendChild(modalOverlay);
}

// Simple alert using modal
function showAlert(message) {
  showModal(message, () => {});
}


  // ====== PUMPS ======
  async function togglePump() {
    const totalSeconds = getTotalSeconds(mainPumpDurationInput, mainPumpDurationSecInput);
    pumpButton.disabled = true;
    pumpButton.querySelector('.spinner')?.classList.remove('hidden');
    try {
      await fetch(`${pumpPHP}?state=${pumpOn?"OFF":"ON"}&duration=${totalSeconds}`);
      await loadAllPumps();
    } catch(e){
      console.error("Main pump toggle error:", e);
      showAlert("Pump toggle failed. Check server connection.");
    } finally {
      pumpButton.disabled = false;
      pumpButton.querySelector('.spinner')?.classList.add('hidden');
    }
  }

  async function toggleDosingPump(pump) {
    const el = dosingElements[pump];
    const totalSeconds = getTotalSeconds(el.durationInput, el.durationSecInput);
    el.button.disabled = true;
    el.button.querySelector('.spinner')?.classList.remove('hidden');
    try {
      await fetch(`${dosingPumpPHP}?pump=${pump}&state=${dosingPumps[pump]?"OFF":"ON"}&duration=${totalSeconds}`);
      await loadAllPumps();
    } catch(e){
      console.error(`Pump ${pump} toggle error:`, e);
      showAlert(`Pump ${pump} toggle failed`);
    } finally {
      el.button.disabled = false;
      el.button.querySelector('.spinner')?.classList.add('hidden');
    }
  }

  async function loadAllPumps() {
    try {
      // Main Pump
      const pumpRes = await fetch(pumpPHP);
      const pumpData = await pumpRes.json();
      pumpOn = pumpData.state==="ON";
      pumpStatusEl.innerText = pumpData.state;
      pumpStatusEl.classList.toggle("pump-on", pumpOn);
      pumpStatusEl.classList.toggle("pump-off", !pumpOn);
      pumpButton.querySelector('.btn-text').innerText = pumpOn?"Turn Water Pump OFF":"Turn Water Pump ON";
      clearInterval(pumpTimerEl._interval);
      if(pumpOn && pumpData.end_time){
        startCountdownFromEndTime(new Date(pumpData.end_time).getTime(), pumpTimerEl, async()=>{
          await fetch(`${pumpPHP}?state=OFF`);
          loadAllPumps();
        });
      } else pumpTimerEl.innerText = "";

      // Dosing Pumps
      const dosingRes = await fetch(dosingPumpPHP);
      const dosingData = await dosingRes.json();
      dosingData.forEach(p => {
        const el = dosingElements[p.pump];
        dosingPumps[p.pump] = p.state==="ON";
        el.status.innerText = p.state;
        el.status.classList.toggle("dosingpump-on", dosingPumps[p.pump]);
        el.status.classList.toggle("dosingpump-off", !dosingPumps[p.pump]);
        el.button.querySelector('.btn-text').innerText = dosingPumps[p.pump]?`Turn Pump ${p.pump} OFF`:`Turn Pump ${p.pump} ON`;

        clearInterval(el.timer._interval);
        if(dosingPumps[p.pump] && p.end_time){
          startCountdownFromEndTime(new Date(p.end_time).getTime(), el.timer, async ()=>{
            await fetch(`${dosingPumpPHP}?pump=${p.pump}&state=OFF`);
            loadAllPumps();
          });
        } else el.timer.innerText = "";
      });

    } catch(e){ console.error("Error loading pumps:", e); }
  }

  // ====== SCHEDULES ======
  async function loadSchedules() {
    try {
      const res = await fetch(getSchedulePHP);
      const data = await res.json();
      const schedules = Array.isArray(data.data) ? data.data : [];
      scheduleTableBody.innerHTML = '';
      schedules.forEach(schedule => {
        const tr = document.createElement("tr");
        const timeText = `${schedule.hour}:${String(schedule.minute).padStart(2,'0')} ${schedule.ampm}`;
        tr.innerHTML = `
          <td>${timeText}</td>
          <td>${schedule.duration} min</td>
          <td><button class="btn btn-danger deleteBtn">Delete</button></td>
        `;
        tr.querySelector(".deleteBtn").addEventListener("click", () => {
          showModal(`Delete schedule at ${timeText}?`, () => deleteSchedule(schedule.id));
        });
        scheduleTableBody.appendChild(tr);
      });
    } catch(err) {
      console.error("Error loading schedules:", err);
    }
  }

  async function deleteSchedule(id) {
    try {
      const formData = new URLSearchParams();
      formData.append("id", id);
      const res = await fetch(deleteSchedulePHP, {
        method: "POST",
        body: formData
      });
      const data = await res.json();
      if(data.success) {
        showAlert("Schedule deleted successfully");
        loadSchedules();
      } else {
        showAlert("Failed to delete schedule");
      }
    } catch(err) {
      console.error("Delete schedule error:", err);
    }
  }

  // ====== AUTOMATION FORM ======
  scheduleForm.addEventListener("submit", async e => {
    e.preventDefault();
    let hour = parseInt(autoHour.value);
    const minute = parseInt(autoMinute.value);
    const ampm = autoAMPM.value;
    if(ampm==="PM" && hour<12) hour+=12;
    if(ampm==="AM" && hour===12) hour=0;
    const duration = parseInt(autoDuration.value);

    try {
      const formData = new URLSearchParams();
      formData.append("hour", hour);
      formData.append("minute", minute);
      formData.append("ampm", ampm);
      formData.append("duration", duration);

      const res = await fetch(addSchedulePHP, {
        method: "POST",
        body: formData
      });
      const data = await res.json();
      if(data.success){
        showAlert("Schedule added successfully!");
        scheduleForm.reset();
        loadSchedules();
      } else {
        showAlert("Failed to add schedule: " + data.message);
      }
    } catch(err) {
      console.error("Add schedule error:", err);
      showAlert("Error adding schedule");
    }
  });

  // ====== AUTOMATION / MANUAL TOGGLE ======
  function showAutomation(){ manualMode.style.display="none"; automationMode.style.display="block"; }
  function showManual(){ manualMode.style.display="block"; automationMode.style.display="none"; }

  const savedMode = localStorage.getItem("mode")||"manual";
  savedMode==="automation"?showAutomation():showManual();
  modeToggle.checked = savedMode==="automation";

  modeToggle.addEventListener("change", async()=>{
    localStorage.setItem("mode",modeToggle.checked?"automation":"manual");
    if(modeToggle.checked){
      showAutomation();
      await fetch(`${pumpPHP}?state=OFF`);
      ['A','B','C'].forEach(p=>fetch(`${dosingPumpPHP}?pump=${p}&state=OFF`));
      loadAllPumps();
    }else{
      showManual();
      clearInterval(pumpTimerEl._interval);
      ['A','B','C'].forEach(p=>clearInterval(dosingElements[p].timer._interval));
    }
  });

  // ====== EVENTS ======
  pumpButton.addEventListener("click", togglePump);
  ['A','B','C'].forEach(p=>dosingElements[p].button.addEventListener("click",()=>toggleDosingPump(p)));
  setInterval(()=>{ if(!modeToggle.checked) loadAllPumps(); },2000);

  // Initial load
  loadAllPumps();
  loadSchedules();

  // ====== EXPOSE FUNCTIONS ======
  window.toggleDosingPump = toggleDosingPump;
  window.togglePump = togglePump;
});
