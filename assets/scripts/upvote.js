"use strict";

const forms = document.querySelectorAll(".vote");

forms.forEach((form) => {
  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    fetch("/app/posts/votes.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((json) => {
        const voteBtn = event.target.querySelector(".vote-btn");
        voteBtn.textContent = json.buttonText;

        const voteNumbers = document.querySelectorAll(".number-of-votes");
        voteNumbers.forEach((voteNumber) => {
          if (voteBtn.dataset.id === voteNumber.dataset.id) {
            voteNumber.textContent = json.numberOfVotes;
          }
        });
      });
  });
});
