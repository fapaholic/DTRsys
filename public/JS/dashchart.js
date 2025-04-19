let list = document.querySelectorAll(".navigation li");

// Function to handle hover state
function hoverLink() {
  list.forEach((item) => {
    if (!item.classList.contains("selected")) {
      item.classList.remove("hovered");
    }
  });
  this.classList.add("hovered");
}

// Function to handle leaving hover
function leaveLink() {
  list.forEach((item) => {
    if (!item.classList.contains("selected")) {
      item.classList.remove("hovered");
    }
  });
}

// Function to handle click and set selected state
function selectLink() {
  list.forEach((item) => {
    item.classList.remove( "hovered");
  });
}

// Add event listeners for hover and click
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

window.addEventListener("load", () => {
  const currentPath = window.location.pathname; // Get the current URL path
  console.log(currentPath)
  list.forEach((item) => {
    const link = item.querySelector("a"); // Find the <a> inside the <li>
    if (link && link.getAttribute("href") === currentPath) {
      item.classList.add("selected");
    }
  });
});

const ctx = document.getElementById('attendanceChart').getContext('2d');

new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
    datasets: [
      {
        label: 'Present',
        data: [98, 95, 97, 99, 96, 94, 93],
        borderColor: '#2ecc71',
        backgroundColor: 'rgba(46, 204, 113, 0.0)',
        tension: 0.4,
        fill: true,
      },
      {
        label: 'Absent',
        data: [22, 25, 23, 21, 24, 26, 27],
        borderColor: '#e74c3c',
        backgroundColor: 'rgba(231, 76, 60, 0.0)',
        tension: 0.4,
        fill: true,
      },
      {
        label: 'Late',
        data: [3, 2, 4, 3, 5, 3, 2],
        borderColor: '#f39c12',
        backgroundColor: 'rgba(243, 156, 18, 0.0)',
        tension: 0.4,
        fill: true,
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        grid: {
          display: false
        }
      },
      y: {
        beginAtZero: true,
        grid: {
          color: '#ecf0f1'
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
      }
    }
  }
});