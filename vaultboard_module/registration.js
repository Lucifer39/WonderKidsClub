const usernameContainer = document.getElementById("username");

usernameContainer.addEventListener("input", () => {
  $.ajax({
    type: "POST",
    url: "connection/dependencies.php?function_name=getUsername",
    data: {
      username: usernameContainer.value,
    },
    success: function (res) {
      var response = JSON.parse(res);

      if (response) {
        document.getElementById("username-indicator").textContent = "";
        usernameContainer.style.border = "2px solid green";
      } else {
        document.getElementById("username-indicator").textContent = "username already taken";
        document.getElementById("username-indicator").style.color = "red";
        usernameContainer.style.border = "2px solid red";
      }
    },
  });
});

const emailInput = document.getElementById("email");

emailInput.addEventListener("input", () => {
  if (isValidEmail(emailInput.value)) {
    emailInput.style.border = "2px solid green";
  } else {
    emailInput.style.border = "2px solid red";
  }
});

function isValidEmail(email) {
  // Regular expression pattern for email validation
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  return emailRegex.test(email);
}

/*-----------form--------------*/
const formRegistration = document.getElementById("registration-form");

formRegistration.addEventListener("submit", (event) => {
  event.preventDefault();

  const avatar = formRegistration.elements["avatar"].value;
  const username = formRegistration.elements["username"].value;
  const firstName = formRegistration.elements["first-name"].value;
  const lastName = formRegistration.elements["last-name"].value;
  const email = formRegistration.elements["email"].value;
  const age = formRegistration.elements["age"].value;
  const school = formRegistration.elements["school"].value;
  const classValue = formRegistration.elements["class"].value;
  const password = formRegistration.elements["password"].value;

  // if (
  //   !avatar ||
  //   !username ||
  //   !firstName ||
  //   !lastName ||
  //   !email ||
  //   !age ||
  //   !school ||
  //   !classValue ||
  //   !password
  // ) {
  //   alert("please fill in all the fields fields!");
  //   return;
  // }

  if (!avatar) {
    showPopup("Error", "Please enter your avatar!");
    return;
  }

  if (!username) {
    showPopup("Error", "Please enter your username!");
    return;
  }

  if (!firstName) {
    showPopup("Error", "Please enter your first name!");
    return;
  }

  if (!lastName) {
    showPopup("Error", "Please enter your last name!");
    return;
  }

  if (!email) {
    showPopup("Error", "Please enter your email!");
    return;
  }

  if (!age) {
    showPopup("Error", "Please enter your age!");
    return;
  }

  if (!school) {
    showPopup("Error", "Please enter your school!");
    return;
  }

  if (classValue == "") {
    showPopup("Error", "Please enter your class!");
    return;
  }

  if (!password) {
    showPopup("Error", "Please enter your password!");
    return;
  }

  $.ajax({
    type: "post",
    url: "connection/dependencies.php?function_name=register",
    data: {
      avatar,
      username,
      firstName,
      lastName,
      email,
      age,
      school,
      classValue,
      password,
    },
    success: function (res) {
      var response = JSON.parse(res);

      if (response) {
        showPopup("Account Created", "Your account has been created.");

        setTimeout(() => {
          window.location.href = "./";
        }, 2100);
      }
    },
  });
});

document.getElementById("cancel-btn").addEventListener("click", (event) => {
  event.preventDefault();

  window.location.href = "./";
});
