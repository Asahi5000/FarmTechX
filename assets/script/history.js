document.addEventListener("DOMContentLoaded", () => {
  const tableBody = document.querySelector("#sensorTable tbody");
  const ctx = document.getElementById("sensorChart").getContext("2d");
  const paginationDiv = document.getElementById("pagination");
  const pageSizeSelect = document.getElementById("pageSize");

  let currentFilter = "latest"; 
  let currentStart = null;
  let currentEnd = null;
  let currentPage = 1;
  let currentLimit = parseInt(pageSizeSelect.value);

  // ================= CHART =================
  let sensorChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [],
      datasets: [
        { label: "Temperature (°C)", borderColor: "blue", data: [], fill: false },
        { label: "EC", borderColor: "green", data: [], fill: false },
        { label: "pH", borderColor: "red", data: [], fill: false }
      ]
    },
    options: {
      responsive: true,
      interaction: { mode: 'index', intersect: false },
      plugins: { legend: { position: 'top' } },
      scales: { x: { display: true }, y: { display: true } }
    }
  });

  // ================= FETCH DATA =================
  function fetchData(filter = "latest", start = null, end = null, page = 1, limit = 50) {
    let url = `../assets/php/api/history-data.php?filter=${filter}&page=${page}&limit=${limit}`;
    if (filter === "range" && start && end) {
      url += `&start_date=${start}&end_date=${end}`;
    }

    fetch(url)
      .then(res => res.json())
      .then(result => {
        const data = result.data || [];
        const pagination = result.pagination;

        if (!pagination) return;

        // Update currentPage from API
        currentPage = pagination.currentPage;

        // ================= UPDATE TABLE =================
        tableBody.innerHTML = "";
        data.forEach(row => {
          let tr = document.createElement("tr");
          tr.innerHTML = `
            <td>${row.id}</td>
            <td>${row.temperature}</td>
            <td>${row.ec}</td>
            <td>${row.ph ?? "-"}</td>
            <td>${row.created_at}</td>
          `;
          tableBody.appendChild(tr);
        });

        // ================= UPDATE CHART =================
        sensorChart.data.labels = data.map(r => r.created_at).reverse();
        sensorChart.data.datasets[0].data = data.map(r => r.temperature).reverse();
        sensorChart.data.datasets[1].data = data.map(r => r.ec).reverse();
        sensorChart.data.datasets[2].data = data.map(r => r.ph).reverse();
        sensorChart.update();

        // ================= UPDATE PAGINATION =================
        renderPagination(pagination);
      })
      .catch(err => console.error("Error fetching data:", err));
  }

  // ================= RENDER PAGINATION =================
  function renderPagination(pagination) {
    paginationDiv.innerHTML = "";
    if (!pagination || pagination.totalPages <= 1) return;

    const { startPage, endPage, hasPrev, hasNext, prevPage, nextPage, totalPages, currentPage } = pagination;

    // Previous arrow
    const prevBtn = document.createElement("button");
    prevBtn.textContent = "←";
    prevBtn.className = "page-btn btn btn-outline-primary";
    prevBtn.disabled = !hasPrev;
    if (hasPrev) prevBtn.addEventListener("click", () => fetchData(currentFilter, currentStart, currentEnd, prevPage, currentLimit));
    paginationDiv.appendChild(prevBtn);

    // Page numbers
    for (let i = startPage; i <= endPage; i++) {
      const btn = document.createElement("button");
      btn.textContent = i;
      btn.className = "page-btn btn btn-outline-primary";
      if (i === currentPage) btn.classList.add("active");
      btn.addEventListener("click", () => fetchData(currentFilter, currentStart, currentEnd, i, currentLimit));
      paginationDiv.appendChild(btn);
    }

    // Next arrow
    const nextBtn = document.createElement("button");
    nextBtn.textContent = "→";
    nextBtn.className = "page-btn btn btn-outline-primary";
    nextBtn.disabled = !hasNext;
    if (hasNext) nextBtn.addEventListener("click", () => fetchData(currentFilter, currentStart, currentEnd, nextPage, currentLimit));
    paginationDiv.appendChild(nextBtn);
  }

  // ================= FILTER BUTTON ACTIVE =================
  function setActiveFilterButton(filter) {
    document.querySelectorAll(".filter-btn").forEach(btn => {
      btn.classList.remove("active");
      if (btn.dataset.filter === filter) btn.classList.add("active");
    });
  }

  // ================= EVENT LISTENERS =================
  // Page size selector
  pageSizeSelect.addEventListener("change", () => {
    currentLimit = parseInt(pageSizeSelect.value);
    currentPage = 1;
    fetchData(currentFilter, currentStart, currentEnd, currentPage, currentLimit);
  });

  // Filter buttons
  document.querySelectorAll(".filter-btn").forEach(btn => {
    btn.addEventListener("click", () => {
      currentFilter = btn.dataset.filter;
      currentStart = null;
      currentEnd = null;
      currentPage = 1;
      setActiveFilterButton(currentFilter);
      fetchData(currentFilter, currentStart, currentEnd, currentPage, currentLimit);
    });
  });

  // Date range
  document.getElementById("applyRange").addEventListener("click", () => {
    const start = document.getElementById("start_date").value;
    const end = document.getElementById("end_date").value;
    if (start && end) {
      currentFilter = "range";
      currentStart = start;
      currentEnd = end;
      currentPage = 1;
      setActiveFilterButton(null);
      fetchData(currentFilter, currentStart, currentEnd, currentPage, currentLimit);
    } else {
      // Show Bootstrap modal instead of alert
const missingDateModal = new bootstrap.Modal(document.getElementById('missingDateModal'));
missingDateModal.show();

    }
  });

  // ================= AUTO-REFRESH =================
  setInterval(() => {
    fetchData(currentFilter, currentStart, currentEnd, currentPage, currentLimit);
  }, 100000); // every 100 seconds

  // ================= INITIAL LOAD =================
  fetchData(currentFilter, currentStart, currentEnd, currentPage, currentLimit);
});
