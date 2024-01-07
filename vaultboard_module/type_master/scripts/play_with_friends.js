let inputContainer = document.getElementById("room-code-input");
let inputButton = document.getElementById("room-button");

inputContainer.addEventListener("input", () => {
  if (inputContainer.value.length > 0) {
    inputButton.disabled = false;
  } else {
    inputButton.disabled = true;
  }
});

inputButton.addEventListener("click", () => {
  window.location.href = `index.php?page=waiting_room_page&rc=${inputContainer.value}&ro=0&rt=${type}`;
});
