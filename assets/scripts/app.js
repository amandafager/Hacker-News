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

//remove loading of transition
window.addEventListener("load", () => {
  document.body.classList.remove("loading");
});

const editCommentBtns = document.querySelectorAll(".edit-comment-btn");
const editForms = document.querySelectorAll(".edit-comment-form");
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

const back = document.querySelector(".go-back");

console.log(back);
if (back) {
  back.addEventListener("click", (e) => {
    e.preventDefault();
    window.history.back();
  });
}

//Logout
const body = document.querySelector("body");
const modalBox = document.querySelector(".modal");
const modalContent = document.querySelector(".modal-dialog .modal-content");
const logout = document.querySelector(".logout-link");
const noBtn = document.querySelector(".modal-btn-no");
const closeBtn = document.querySelector(".closebtn");

const modalQuestion = document.querySelector(".modal-question");
const modalForm = document.querySelector(".modal-form");

function toggleModal() {
  modalBox.classList.toggle("show-modal");
  modalContent.classList.toggle("show-modal-content");
  /*body.classList.toggle("body-modal-open");*/
}

if (logout) {
  logout.addEventListener("click", (e) => {
    e.preventDefault();
    toggleModal();
    modalQuestion.textContent = "Logout?";
    modalForm.action = "/app/users/logout.php";
  });

  closeBtn.addEventListener("click", (e) => {
    e.preventDefault();
    toggleModal();
  });

  noBtn.addEventListener("click", (e) => {
    e.preventDefault();
    toggleModal();
  });
}

const deletePostBtns = document.querySelectorAll(".delete-btn");
const modalInput = document.querySelector(".modal-form .input");

deletePostBtns.forEach((deletePostBtn) => {
  deletePostBtn.addEventListener("click", () => {
    console.log(deletePostBtn);
    modalQuestion.textContent = "Delete your post?";
    modalForm.action = "app/posts/delete.php";
    let postId = deletePostBtn.value;
    modalInput.value = postId;
    toggleModal();
  });
});
