    const modeToggle = document.getElementById('modeToggle');
    const modeLabel = document.getElementById('modeLabel');
    const manualMode = document.getElementById('manualMode');
    const automationMode = document.getElementById('automationMode');
    const scheduleForm = document.getElementById('scheduleForm');
    const scheduleTable = document.getElementById('scheduleTable').querySelector('tbody');

    // Switch Mode
    modeToggle.addEventListener('change', () => {
      if (modeToggle.checked) {
        manualMode.style.display = 'none';
        automationMode.style.display = 'block';
        modeLabel.innerText = "Automation";
        document.querySelectorAll('.valve').forEach(v => v.classList.remove('on'));
      } else {
        manualMode.style.display = 'block';
        automationMode.style.display = 'none';
        modeLabel.innerText = "Manual";
      }
    });

    // Manual Valve Toggle
    function toggleValve(el){
      el.classList.toggle('on');
    }

    // Add Automation Schedule
    scheduleForm.addEventListener('submit', (e)=>{
      e.preventDefault();
      const valve = document.getElementById('valve').value;
      let time = document.getElementById('time').value;
      const ph = document.getElementById('phAuto').value;

      if(!valve || !time) return;

      // Convert to 12hr AM/PM
      let [hour, minute] = time.split(":");
      hour = parseInt(hour);
      const ampm = hour >= 12 ? "PM" : "AM";
      hour = hour % 12 || 12;
      time = `${hour}:${minute} ${ampm}`;

      // Prevent duplicate time for different valves
      const exists = Array.from(scheduleTable.rows).some(r => r.cells[1].innerText === time);
      if(exists){ alert("This time slot is already taken!"); return; }

      const row = scheduleTable.insertRow();
      row.insertCell(0).innerText = valve;
      row.insertCell(1).innerText = time;
      row.insertCell(2).innerText = ph;
      const actions = row.insertCell(3);
      actions.innerHTML = `<button class="action-btn edit" onclick="editRow(this)">Edit</button>
                           <button class="action-btn" onclick="deleteRow(this)">Delete</button>`;
      scheduleForm.reset();
    });

    function editRow(btn){
      const row = btn.parentElement.parentElement;
      document.getElementById('valve').value = row.cells[0].innerText;
      document.getElementById('time').value = row.cells[1].innerText;
      document.getElementById('phAuto').value = row.cells[2].innerText;
      row.remove();
    }
    function deleteRow(btn){
      btn.parentElement.parentElement.remove();
    }