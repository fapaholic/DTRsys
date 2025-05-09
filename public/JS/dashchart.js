let list = document.querySelectorAll(".navigation li");

// Hover behavior
function hoverLink() {
  list.forEach((item) => {
    if (!item.classList.contains("selected")) {
      item.classList.remove("hovered");
    }
  });
  this.classList.add("hovered");
}

function leaveLink() {
  list.forEach((item) => {
    if (!item.classList.contains("selected")) {
      item.classList.remove("hovered");
    }
  });
}

function selectLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
}

list.forEach((item) => {
  item.addEventListener("mouseover", hoverLink);
  item.addEventListener("mouseleave", leaveLink);
  item.addEventListener("click", selectLink);
});

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
};

// Highlight selected nav item
window.addEventListener("load", () => {
  const currentPath = window.location.pathname;
  console.log(currentPath);
  list.forEach((item) => {
    const link = item.querySelector("a");
    if (link && link.getAttribute("href") === currentPath) {
      item.classList.add("selected");
    }
  });
});

// Attendance Chart
document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById('attendanceChart').getContext('2d');

  new Chart(ctx, {
      type: 'line',
      data: {
          labels: labels,
          datasets: [
              {
                  label: 'On Time',
                  data: onTimeData,
                  borderColor: '#2ecc71',
                  backgroundColor: 'rgba(46, 204, 113, 0.2)',
                  borderWidth: 2,
                  tension: 0.4,
                  fill: true,
                  pointRadius: 4,
                  pointHoverRadius: 6
              },
              {
                  label: 'Late',
                  data: lateData,
                  borderColor: '#f39c12',
                  backgroundColor: 'rgba(243, 156, 18, 0.2)',
                  borderWidth: 2,
                  tension: 0.4,
                  fill: true,
                  pointRadius: 4,
                  pointHoverRadius: 6
              },
              {
                  label: 'Absent',
                  data: absentData,
                  borderColor: '#e74c3c',
                  backgroundColor: 'rgba(231, 76, 60, 0.2)',
                  borderWidth: 2,
                  tension: 0.4,
                  fill: true,
                  pointRadius: 4,
                  pointHoverRadius: 6
              }
          ]
      },
      options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
              x: {
                  title: {
                      display: true,
                      text: 'Day of the Week',
                      font: {
                          size: 14
                      }
                  },
                  ticks: {
                      font: {
                          size: 12
                      }
                  }
              },
              y: {
                  beginAtZero: true,
                  title: {
                      display: true,
                      text: 'Number of Employees',
                      font: {
                          size: 14
                      }
                  },
                  ticks: {
                      stepSize: 1,
                      font: {
                          size: 12
                      }
                  }
              }
          },
          plugins: {
              legend: {
                  labels: {
                      font: {
                          size: 14
                      }
                  }
              },
              tooltip: {
                  enabled: true,
                  mode: 'index',
                  intersect: false
              }
          },
          interaction: {
              mode: 'nearest',
              axis: 'x',
              intersect: false
          }
      }
  });
});
