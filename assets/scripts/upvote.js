"use strict";

function upvote(forms) {
  forms.forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();

      const formData = new FormData(form);
      if (form.classList.contains("comment-form")) {
        fetch("/app/comments/votes.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((json) => {
            const voteBtn = event.target.querySelector(".vote-btn");
            const buttonStatus = json.status;

            if (buttonStatus === true) {
              voteBtn.style.backgroundColor = "grey";
            } else {
              voteBtn.style.backgroundColor = "var(--main-orange)";
            }

            const voteNumbers = document.querySelectorAll(".number-of-votes");
            voteNumbers.forEach((voteNumber) => {
              if (voteBtn.dataset.id === voteNumber.dataset.id) {
                voteNumber.textContent = json.numberOfVotes;
              }
            });
          });
      } else if (form.classList.contains("post-form")) {
        fetch("/app/posts/votes.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((json) => {
            const voteBtn = event.target.querySelector(".vote-btn");
            const buttonStatus = json.status;

            if (buttonStatus === true) {
              voteBtn.style.backgroundColor = "grey";
            } else {
              voteBtn.style.backgroundColor = "var(--main-orange)";
            }

            const voteNumbers = document.querySelectorAll(".number-of-votes");
            voteNumbers.forEach((voteNumber) => {
              if (voteBtn.dataset.id === voteNumber.dataset.id) {
                voteNumber.textContent = json.numberOfVotes;
              }
            });
          });
      }
    });
  });
}

upvote(document.querySelectorAll(".vote.comment-form"));

upvote(document.querySelectorAll(".vote.post-form"));
