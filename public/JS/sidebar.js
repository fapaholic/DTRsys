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

