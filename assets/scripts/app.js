//menu
const navbar = document.querySelector(".navbar");
const ham = document.querySelector(".ham");

ham.addEventListener("click", toggleHamburger);

function toggleHamburger() {
  navbar.classList.toggle("show-nav");
  ham.classList.toggle("show-close");
}

const menuLinks = document.querySelectorAll(".nav-items");

menuLinks.forEach(function (menuLink) {
  menuLink.addEventListener("click", toggleHamburger);
});

//Logout

const logout = document.querySelector(".logout-link");
if (logout) {
  logout.addEventListener("click", () => {
    if (!confirm("Are you sure you want to logout?")) {
      return false;
    } else {
      return true;
    }
  });
}

//remove loading of transition
window.addEventListener("load", () => {
  document.body.classList.remove("loading");
});

/*
function saveInput(e) {
  const inputs = document.querySelectorAll(".save").value;
  inputs.forEach((input) => {
    e.preventDefault();
    alert(input);
  });
}

const sumbits = document.querySelectorAll(".btn");
sumbits.forEach((submit) => {
  submit.addEventListener("click", saveInput);
});
*/

/*
const inputImg = document.querySelector(".pro-img");

const value = inputImg.value;
const proImg = document.querySelector(".pro-img-container img");
proImg.src = value;
*/

//console.log(inputImg);

/*
inputImg.addEventListener("change", () => {
 
});
*/
