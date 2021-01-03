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

/*function goBack() {
  window.history.back();
}
const back = document.querySelector(".go-back");
back.addEventListener("click", goBack);
*/
/*
const voteBtns = document.querySelectorAll(".vote-btn");

voteBtns.forEach((voteBtn) => {
  if (voteBtn.textContent === "Upvote") {
    voteBtn.style.backgroundColor = "blue";
  }
});
*/
