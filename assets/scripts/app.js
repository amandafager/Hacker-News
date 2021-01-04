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

const editCommentBtns = document.querySelectorAll(".edit-comment-btn");
const editForms = document.querySelectorAll(".edit-comment");
const comments = document.querySelectorAll(".comment-text");

editCommentBtns.forEach((editCommentBtn) => {
  editCommentBtn.addEventListener("click", () => {
    editForms.forEach((form) => {
      if (editCommentBtn.dataset.id === form.dataset.id) {
        form.classList.toggle("show-edit");
      }
    });

    comments.forEach((comment) => {
      if (editCommentBtn.dataset.id === comment.dataset.id) {
        comment.classList.toggle("hide-text");
      }
    });
  });
});
