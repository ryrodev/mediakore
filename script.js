const hamburger = document.querySelector(".hamburger");
const navMenu = document.querySelector(".nav-menu");
const submitpost = document.querySelector(".submitpost");
const indexmain = document.querySelector(".indexmain");

const themeButton = document.getElementById('themeButton');
const body = document.body;

let isDarkMode = false;

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active");
  navMenu.classList.toggle("active");
  submitpost.classList.toggle("active");
  indexmain.classList.remove("active");
})

document.querySelectorAll(".nav-link").forEach(n => n.addEventListener("click", () => {
  hamburger.classList.remove("active");
  navMenu.classList.remove("active");
  submitpost.classList.remove("active");
  indexmain.classList.remove("active");
}))


document.addEventListener("DOMContentLoaded", function () {
  const searchIcon = document.getElementById("searchIcon");
  const searchBox = document.getElementById("searchBox");

  searchIcon.addEventListener("click", function () {
      searchBox.classList.toggle("active");
  });
});

//nav-item clicavel
function navigateToCategory(categoryId) {
  window.location.href = 'categoria.php?id=' + categoryId;
}
