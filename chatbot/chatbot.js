const botQuestions = [
  {
    id: 0,
    content: `Hello, ${current_student.fullname.split(" ")[0]}!`,
    type: "wait",
    input: "text",
  },
  {
    id: 1,
    content: "How are you doing?",
    type: "wait",
    input: "text",
  },
  {
    id: 2,
    content: "Wow, that's great!",
    type: "instant",
    input: "text",
  },
  {
    id: 3,
    content: "I am an AI chatbot designed to know more about you.",
    type: "instant",
    input: "text",
  },
  {
    id: 4,
    content: "Please select an avatar for your profile.",
    type: "wait",
    input: "avatar_buttons",
  },
  {
    id: 5,
    content: "Please describe yourself in 50 words.",
    type: "wait",
    input: "text",
  },
  {
    id: 6,
    content: "You seem so cool!",
    type: "instant",
    input: "text",
  },
  {
    id: 7,
    content: "Now its your turn to choose adjectives that best suit you from your username.",
    type: "instant",
    input: "text",
  },
  {
    id: 8,
    content: "Choose the best suiting adjective for the letter %%letter%%:",
    type: "wait",
    input: "button",
  },
  {
    id: 9,
    content: "It was so nice knowing you!",
    type: "instant",
    input: "text",
  },
  {
    id: 10,
    content: "This is what your profile looks to your friends!",
    type: "instant",
    input: "text",
  },
  {
    id: 11,
    content: "Do you want to edit anything?",
    type: "wait",
    input: "edit_button",
  },
  {
    id: 12,
    content: "Thank you so much!",
    type: "instant",
    input: "text",
  },
];

const questionRegex =
  /^(?:what|who|where|when|why|how|which|is|are|am|can|could|may|might|shall|should|will|would|do|does|did|done|has|have|had|having)\b/i;

// Get required elements
const chatbotContainer = document.getElementById("chatbot-container");
const chatbotMessages = document.getElementById("chatbot-messages");
const chatbotInput = document.getElementById("chatbot-input");
const userInput = document.getElementById("chatbot-input-text");
const sendButton = document.getElementById("chatbot-send");
const userInputButtons = document.getElementById("chatbot-input-buttons");
const userInputBox = document.getElementById("chatbot-input-box");
const chatbotFooter = document.getElementById("chatbot-footer");

if (adjective_array_php) {
  adjective_array_php.length =
    adjective_array_php?.length > current_student.fullname.split(" ")[0].length
      ? 0
      : adjective_array_php?.length;
}

// let currentQuestionIndex = student_progress?.bio == null && adjective_array_php?.length > 0 ? 3 : 9;
let currentQuestionIndex = 0;
var continuity = false;
if (current_student?.avatar == null) {
  currentQuestionIndex = 3;
} else if (student_progress?.bio == null) {
  currentQuestionIndex = 5;
} else if (
  student_progress?.bio !== null &&
  student_progress?.adjectives == null &&
  (adjective_array_php?.length == null || adjective_array_php?.length == 0)
) {
  currentQuestionIndex = 5;
  continuity = true;
} else if (
  student_progress?.bio !== null &&
  (adjective_array_php?.length == null || adjective_array_php?.length == 0)
) {
  currentQuestionIndex = 10;
} else {
  currentQuestionIndex = 7;
}

var question_count = 0;
console.log(adjective_array_php);

// let currentQuestionIndex = 9;
var name_index = adjective_array_php?.length ? adjective_array_php.length : 0;
var adjective_array = adjective_array_php?.length > 0 ? adjective_array_php : [];
var repeat_flag = false;
var repeat_flag_about = false;

if (adjective_array_php?.length > 0) {
  addMessage("Hey there! Please select the adjectives for the rest of your name.", true);
  incom_message(adjective_array_php);
}
// Function to add a message to the chatbot messages
function addMessage(content, isBot) {
  if (question_count > 5) {
    window.location.reload();
  }

  question_count++;

  const message = document.createElement("div");
  const messageAvatar = document.createElement("div");
  const messageContent = document.createElement("div");
  const userProfile = document.createElement("img");

  messageContent.innerHTML = content;

  messageAvatar.className = "message-avatar";
  messageContent.className = "message-content";
  message.classList.add("message");
  if (isBot) {
    message.classList.add("bot");
    userProfile.src = "assets/robot-icon.svg";

    messageAvatar.appendChild(userProfile);
    message.appendChild(messageAvatar);
    message.appendChild(messageContent);
  } else {
    message.classList.add("user");

    if (!current_student.avatar) {
      userProfile.src = "../assets/images/user.svg";
    } else {
      userProfile.src = `../assets/images/avatars/${current_student.avatar}`;
    }

    messageAvatar.appendChild(userProfile);
    message.appendChild(messageContent);
    message.appendChild(messageAvatar);
  }

  chatbotMessages.appendChild(message);

  scrollToBottom();
}

// Function to handle displaying the next question
function displayNextQuestion() {
  const question = botQuestions[currentQuestionIndex];

  if (currentQuestionIndex < botQuestions.length) {
    if (question.type === "wait") {
      if (question.input === "text") {
        chatbotFooter.style.display = "none";
        if (!repeat_flag_about) {
          if (!continuity) {
            setTimeout(() => addMessage(question.content, true), 500);
            userInputBox.style.display = "flex";
            userInputButtons.style.display = "none";
            userInput.focus();
            sendButton.addEventListener("click", handleUserInput);
            userInput.addEventListener("keypress", (event) => {
              if (event.key === "Enter") {
                handleUserInput();
              }
            });
          } else {
            setTimeout(() => addMessage(question.content, true), 500);
            setTimeout(() => addMessage(student_progress.bio, false), 500);
            currentQuestionIndex++;
            setTimeout(displayNextQuestion, 500);
          }
        } else {
          currentQuestionIndex = 10;
          question_count = 0;
          setTimeout(displayNextQuestion, 500);
        }
      } else if (question.input === "button") {
        if (!repeat_flag && !repeat_flag_about) {
          chatbotFooter.style.display = isMobileDevice() ? "flex" : "none";
          userInputBox.style.display = "none";
          userInputButtons.style.display = "grid";

          // console.log("get adjectives from display next question");
          get_adjectives();
        } else {
          currentQuestionIndex = 10;
          question_count = 0;
          setTimeout(displayNextQuestion, 500);
        }
      } else if (question.input === "edit_button") {
        chatbotFooter.style.display = "none";
        setTimeout(() => addMessage(question.content, true), 500);

        repeat_flag = false;
        repeat_flag_about = false;

        userInputBox.style.display = "none";
        userInputButtons.style.display = "grid";
        userInputButtons.innerHTML = "";

        var edit_buttons = [
          { content: "Avatar", send_to: 4 },
          { content: "Know about me", send_to: 5 },
          { content: "Adjectives to describe me", send_to: 7 },
          { content: "Go back", send_to: 12 },
        ];

        edit_buttons.forEach((element) => {
          const button = document.createElement("button");

          button.textContent = element.content;
          button.className = "adjective-btn-chatbot";

          button.addEventListener("click", () => {
            currentQuestionIndex = element.send_to;

            adjective_array_php = [];
            name_index = 0;
            adjective_array = [];

            if (element.content === "Know about me") {
              repeat_flag = true;
            }

            if (element.content === "Avatar") {
              repeat_flag_about = true;
            }

            if (element.content === "Go back") {
              window.location.href = "../";
            }

            console.log(currentQuestionIndex);

            question_count = 0;
            displayNextQuestion();
          });

          userInputButtons.appendChild(button);
        });
      } else if (question.input == "avatar_buttons") {
        chatbotFooter.style.display = "none";
        setTimeout(() => addMessage(question.content, true), 500);

        userInputBox.style.display = "none";
        userInputButtons.style.display = "grid";
        userInputButtons.innerHTML = "";

        $.ajax({
          type: "get",
          url: "functions/chatbot_functions.php?function_name=get_avatars",
          success: function (res) {
            var response = JSON.parse(res);

            response.forEach((element) => {
              const button = document.createElement("button");
              button.className = "adjective-btn-chatbot";

              const buttonImage = document.createElement("img");
              buttonImage.src = `../assets/images/avatars/${element.filename}`;

              button.appendChild(buttonImage);

              button.addEventListener("click", () => {
                const messageImg = document.createElement("img");
                messageImg.src = `../assets/images/avatars/${element.filename}`;
                messageImg.className = "avatar-message-img";

                $.ajax({
                  type: "post",
                  url: "functions/chatbot_functions.php?function_name=set_avatar",
                  data: {
                    user_id: current_student.id,
                    avatar: element.filename,
                  },
                  success: function (res) {
                    setTimeout(() => addMessage(messageImg.outerHTML, false), 500);

                    // window.location.reload();

                    question_count = 0;
                    currentQuestionIndex++;
                    setTimeout(displayNextQuestion, 500);
                  },
                });
              });

              userInputButtons.appendChild(button);
            });
          },
        });
      }
    } else if (question.type === "instant") {
      chatbotFooter.style.display = "none";
      if (!repeat_flag && !repeat_flag_about && question.id !== 7) {
        setTimeout(() => addMessage(question.content, true), 500);
      }

      if (question.id == 10) {
        setTimeout(() => showProfile(), 500);
      } else {
        currentQuestionIndex++;
        // console.log(currentQuestionIndex);

        question_count = 0;
        setTimeout(displayNextQuestion, 500);
      }
    }
  } else {
    chatbotFooter.style.display = "none";
    chatbotInput.style.display = "none";
  }
}

function get_adjectives() {
  $.ajax({
    type: "post",
    url: "functions/chatbot_functions.php?function_name=get_adjectives",
    data: {
      alphabet: current_student.fullname.split(" ")[0][name_index],
    },
    success: function (res) {
      var response = JSON.parse(res);
      populate_button_input(response);
    },
  });
}

function populate_button_input(adjectives) {
  if (
    name_index < current_student.fullname.split(" ")[0].length &&
    isNaN(current_student.fullname.split(" ")[0][name_index])
  ) {
    setTimeout(
      () =>
        addMessage(
          botQuestions[currentQuestionIndex].content.replace(
            "%%letter%%",
            current_student.fullname.split(" ")[0][name_index].toUpperCase()
          ),
          true
        ),
      500
    );

    // console.log(adjectives);
    let current_adjectives = [];
    var messageContent = "";
    userInputButtons.innerHTML = "";
    adjectives.forEach((element, index) => {
      // document.querySelector(".tooltip-inner").style.display = "none";
      var adjective = element.word.split("-");
      // messageContent += "<strong>" + adjective[0] + "</strong> - " + adjective[1] + "<br>";
      // setTimeout(() => addMessage(adjective[0], true), 500);

      if (!current_adjectives.includes(adjective[0].trim())) {
        var buttonContent = document.createElement("button");

        buttonContent.disabled = false;
        buttonContent.textContent = adjective[0];
        buttonContent.className = "adjective-btn-chatbot";

        buttonContent.setAttribute("type", "button");
        buttonContent.setAttribute("data-bs-toggle", "tooltip");

        if (index == 0 || index == 6) {
          buttonContent.setAttribute("data-bs-placement", "right");
        } else {
          buttonContent.setAttribute("data-bs-placement", "left");
        }
        buttonContent.setAttribute("data-bs-custom-class", "custom-tooltip");
        buttonContent.setAttribute("data-bs-title", adjective[1]);
        buttonContent.setAttribute("title", adjective[1]);
        buttonContent.setAttribute("data-state", "tooltip");

        let currentState = buttonContent.getAttribute("data-state");

        if (isMobileDevice()) {
          buttonContent.addEventListener("click", () => {
            if (currentState == "tooltip") {
              const tooltip = new bootstrap.Tooltip(buttonContent); // Create a new tooltip instance
              tooltip.show();
              currentState = "function";
            } else if (currentState == "function") {
              adjective_func(buttonContent);
            }
            // Initialize the Bootstrap tooltip
          });
        } else {
          const tooltip = new bootstrap.Tooltip(buttonContent); // Create a new tooltip instance
          buttonContent.addEventListener("mouseenter", () => {
            tooltip.show();
          });
          buttonContent.addEventListener("click", () => {
            adjective_func(buttonContent);
          });
          buttonContent.addEventListener("mouseleave", () => {
            tooltip.hide();
          });
        }

        userInputButtons.appendChild(buttonContent);
        current_adjectives.push(adjective[0].trim());
      }
    });

    // setTimeout(() => addMessage(messageContent, true), 500);
  } else {
    name_index++;

    if (name_index >= current_student.fullname.split(" ")[0].length) {
      $.ajax({
        type: "post",
        url: "functions/chatbot_functions.php?function_name=create_bio_about",
        data: {
          student_id: parseInt(current_student.id),
          content: adjective_array.join(","),
          type: "adjectives",
        },
        success: function (res) {
          var temp_message = "";
          adjective_array.forEach((element, index) => {
            temp_message +=
              current_student.fullname.split(" ")[0][index].toUpperCase() +
              " - " +
              element +
              "<br>";
          });

          setTimeout(() => addMessage(temp_message, true), 500);
          currentQuestionIndex++;
          setTimeout(displayNextQuestion, 500);
        },
      });
    }

    setTimeout(get_adjectives, 1000);
  }
}

function adjective_func(buttonContent) {
  buttonContent.disabled = true;
  adjective_array.push(buttonContent.textContent);

  $.ajax({
    type: "post",
    url: "functions/chatbot_functions.php?function_name=updateIncompleteAdjectives",
    data: {
      student_id: current_student.id,
      adjectives: adjective_array.join(","),
    },
  });

  name_index++;
  setTimeout(() => addMessage(buttonContent.textContent, false), 500);

  if (name_index < current_student.fullname.split(" ")[0].length) {
    incom_message(adjective_array);
    setTimeout(get_adjectives, 1000);
    setTimeout(() => window.location.reload(), 1000);
  } else {
    $.ajax({
      type: "post",
      url: "functions/chatbot_functions.php?function_name=create_bio_about",
      data: {
        student_id: parseInt(current_student.id),
        content: adjective_array.join(","),
        type: "adjectives",
      },
      success: function (res) {
        var temp_message = "";
        var offset_ind = 0;
        adjective_array.forEach((element, index) => {
          if (!isNaN(current_student.fullname.split(" ")[0][index])) {
            temp_message += current_student.fullname.split(" ")[0][offset_ind] + "<br>";
            offset_ind++;
          }

          temp_message +=
            current_student.fullname.split(" ")[0][offset_ind].toUpperCase() +
            " - " +
            element +
            "<br>";

          offset_ind++;
        });

        setTimeout(() => addMessage(temp_message, true), 500);
        currentQuestionIndex++;
        setTimeout(displayNextQuestion, 500);
      },
    });
  }
}

function showProfile() {
  const parentDiv = document.createElement("div");
  parentDiv.className = "profile-parent-container";

  const headerDiv = document.createElement("div");
  headerDiv.className = "profile-header-container";

  const profilePic = document.createElement("img");
  profilePic.className = "profile-pic-header";

  const headerNameDiv = document.createElement("h6");
  headerNameDiv.className = "profile-header-name";
  headerNameDiv.textContent = current_student.fullname;

  const headerAdjectives = document.createElement("div");
  headerAdjectives.className = "profile-header-adjectives";

  const aboutContainerHeader = document.createElement("h6");
  aboutContainerHeader.className = "profile-about-header";
  aboutContainerHeader.textContent = "About";

  const aboutContainerContent = document.createElement("div");
  aboutContainerContent.className = "profile-about-content";

  $.ajax({
    type: "post",
    url: "functions/chatbot_functions.php?function_name=get_user_avatar",
    data: {
      user_id: current_student.id,
    },
    success: function (res1) {
      var response1 = JSON.parse(res1);

      if (!response1.avatar) {
        profilePic.src = "../assets/images/user.svg";
      } else {
        profilePic.src = `../assets/images/avatars/${response1.avatar}`;
      }

      $.ajax({
        type: "post",
        url: "functions/chatbot_functions.php?function_name=get_user_profile_progress",
        data: {
          user_id: current_student.id,
        },
        success: function (res) {
          var response = JSON.parse(res);

          const colors = [
            "#FF5733", // Red
            "#3498DB", // Blue
            "#2ECC71", // Green
            "#FFA500", // Orange
            "#9B59B6", // Purple
            "#FF6B81", // Pink
            "#8B4513", // Brown
          ];
          // Function to generate a random color from the colors array
          function getRandomColor() {
            const randomIndex = Math.floor(Math.random() * colors.length);
            return colors[randomIndex];
          }

          const words = response?.adjectives ? response?.adjectives.split(",") : "";

          for (let word of words) {
            const randomColor = getRandomColor();
            const spanElement = document.createElement("span");
            spanElement.style.color = randomColor;
            spanElement.textContent = word;
            headerAdjectives.appendChild(spanElement);
            headerAdjectives.appendChild(document.createTextNode(", "));
          }

          headerAdjectives.lastChild?.remove();

          aboutContainerContent.textContent = response.bio;

          headerDiv.appendChild(profilePic);
          headerDiv.appendChild(headerNameDiv);
          headerDiv.appendChild(headerAdjectives);

          headerDiv.appendChild(aboutContainerHeader);
          headerDiv.appendChild(aboutContainerContent);

          parentDiv.appendChild(headerDiv);

          addMessage(parentDiv.outerHTML, true);

          currentQuestionIndex++;
          // console.log(currentQuestionIndex);

          setTimeout(displayNextQuestion, 500);
        },
      });
    },
  });
}

// Function to handle user input
function handleUserInput() {
  const answer = userInput.value.trim();
  setTimeout(() => addMessage(answer, false), 500);
  userInput.value = "";
  sendButton.removeEventListener("click", handleUserInput);

  if (questionRegex.test(answer) || answer == "") {
    setTimeout(
      () => addMessage("I am sorry but I am not designed to answer any questions.", true),
      500
    );
    currentQuestionIndex = 5;
    setTimeout(displayNextQuestion, 1000);
    return;
  }

  //   userInputBox.style.display = "none";
  else if (currentQuestionIndex == 5) {
    $.ajax({
      type: "post",
      url: "functions/chatbot_functions.php?function_name=create_bio_about",
      data: {
        student_id: parseInt(current_student.id),
        content: answer,
        type: "bio",
      },
      success: function (res) {
        currentQuestionIndex++;
        setTimeout(displayNextQuestion, 500);
      },
    });
  }

  // currentQuestionIndex++;
  // setTimeout(displayNextQuestion, 500);
}

// Start the chatbot by displaying the first question
displayNextQuestion();

function scrollToBottom() {
  chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
}

function incom_message(adj) {
  var temp_message = "";
  var offset_ind = 0;
  adj.forEach((element, index) => {
    if (!isNaN(current_student.fullname.split(" ")[0][index])) {
      temp_message += current_student.fullname.split(" ")[0][offset_ind] + "<br>";
      offset_ind++;
    }

    temp_message +=
      current_student.fullname.split(" ")[0][offset_ind].toUpperCase() + " - " + element + "<br>";

    offset_ind++;
  });

  setTimeout(() => addMessage(temp_message, true), 500);
}

function isMobileDevice() {
  return window.matchMedia("(max-width: 641px)").matches;
}
