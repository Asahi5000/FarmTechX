    const pumpToggle = document.getElementById('pumpToggle');
    const pumpStatus = document.getElementById('pumpStatus');
    const scheduleForm = document.getElementById('scheduleForm');
    const scheduleTable = document.getElementById('scheduleTable');

    // Pump switch behavior
    pumpToggle.addEventListener('change', ()=>{
      if(pumpToggle.checked){
        pumpStatus.innerText = "Pump is ON";
        pumpStatus.style.color = "green";
      } else {
        pumpStatus.innerText = "Pump is OFF";
        pumpStatus.style.color = "red";
      }
    });

    // Format time to AM/PM
    function formatTime12hr(time24) {
      let [hour, minute] = time24.split(":");
      hour = parseInt(hour);
      const ampm = hour >= 12 ? "PM" : "AM";
      hour = hour % 12 || 12;
      return `${hour}:${minute} ${ampm}`;
    }

    // Add Schedule
    scheduleForm.addEventListener('submit',(e)=>{
      e.preventDefault();
      const valve = document.getElementById('valve').value;
      const time24 = document.getElementById('time').value;
      const duration = document.getElementById('duration').value;
      const ph = parseFloat(document.getElementById('phAuto').value).toFixed(1);

      if(!valve || !time24) return;

      const time = formatTime12hr(time24);

      // Prevent duplicate times
      const exists = Array.from(scheduleTable.rows).some(r => r.cells[1] && r.cells[1].innerText === time);
      if(exists){
        alert("This time slot is already taken!");
        return;
      }

      // Insert row
      if(scheduleTable.rows[0].cells[0].colSpan === 5){
        scheduleTable.innerHTML = "";
      }

      const row = scheduleTable.insertRow();
      row.insertCell(0).innerText = valve;
      row.insertCell(1).innerText = time;
      row.insertCell(2).innerText = duration + " min";
      row.insertCell(3).innerText = ph;
      const actions = row.insertCell(4);
      actions.innerHTML = `
        <button class="action-btn edit" onclick="editRow(this)">Edit</button>
        <button class="action-btn delete" onclick="deleteRow(this)">Delete</button>
      `;

      scheduleForm.reset();
    });

    // Delete row
    function deleteRow(btn){
      const row = btn.parentNode.parentNode;
      row.remove();
      if(scheduleTable.rows.length === 0){
        scheduleTable.innerHTML = `<tr><td colspan="5">No schedules yet</td></tr>`;
      }
    }

    // Edit row
    function editRow(btn){
      const row = btn.parentNode.parentNode;
      const newTime = prompt("Enter new time (HH:MM 24h):", "07:00");
      const newDuration = prompt("Enter new duration (minutes):", row.cells[2].innerText.replace(" min",""));
      const newPh = prompt("Enter new pH level:", row.cells[3].innerText);

      if(newTime){
        row.cells[1].innerText = formatTime12hr(newTime);
      }
      if(newDuration){
        row.cells[2].innerText = newDuration + " min";
      }
      if(newPh){
        row.cells[3].innerText = parseFloat(newPh).toFixed(1);
      }
    }