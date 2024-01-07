// let input_container = document.getElementById("sentence-count-input");
// input_container.style.display = "none";
let createButton = document.getElementById("create-room-btn");

createButton.addEventListener("click", () => {
  // let sentence_count = input_container.value;
  var currentDate = new Date();
  var formattedDate = moment(currentDate).format("YYYY-MM-DD HH:mm:ss");
  var sentence_count = 1;

  $.ajax({
    type: "POST",
    url: "functions/room_generation.php?function_name=createRoom",
    data: {
      max_sentences: sentence_count,
      type,
      created_at: formattedDate,
    },
    success: function (res) {
      // console.log(JSON.parse(res));
      var respo = JSON.parse(res);
      console.log(respo);
      window.location.href = `index.php?page=waiting_room_page&rc=${respo}&ro=1&rt=${type}`;
    },
  });
});
