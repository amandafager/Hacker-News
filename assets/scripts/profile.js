/*"use strict";

const formImg = document.querySelectorAll(".form-img");

fetch("/app/users/updateProfile.php", {
})
  .then((response) => response.json())
  .then((json) => {
    const img = document.querySelector(".pro-img-container img");
    img.src = json.img;
  });
*/

/*

fetch("/app/users/updateProfile.php", {
  method: "POST",
  body: formData,
})
  .then((response) => response.json())
  .then((json) => {
    const img = document.querySelector(".pro-img-container img");
    img.src = json.img;
  });

formImg.addEventListener("submit", (event) => {
  event.preventDefault();

  const formData = new FormData(formImg);
});

*/
/*
"use strict";

const formBios = document.querySelectorAll(".form-biography");

formBios.forEach((form) => {
  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    fetch("/app/users/updateProfile.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        // We take the response Promise and return it as JSON.
        return response.json();
      })
      .then((json) => {
        const biographyField = event.target.querySelector("textarea");
        console.log(biographyField);
        biographyField.textContent = json.biography;
      });
  });
});
*/
/*
const formEmails = document.querySelectorAll(".form-email");

formEmails.forEach((form) => {
  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    fetch("/app/users/updateProfile.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => {
        // We take the response Promise and return it as JSON.
        return response.json();
      })
      .then((json) => {
        const emailField = event.target.querySelector("input");
        console.log(emailField);
        emailField.value = json.newEmail;
      });
  });
});
*/
