const contextDetailsSection = document.getElementById("context-details-section");
const carousel = document.getElementById("carousel");
const countContainer = document.getElementById("nav-button-count");
var count = 1;
var data_length = 0;

function populateDetails() {
  $.ajax({
    type: "post",
    url: "functions/getters.php?function_name=get_context",
    data: { context_id },
    success: function (res) {
      var response = JSON.parse(res);

      const contextTitleSection = document.createElement("h1");
      const contextSubtitleSection = document.createElement("p");
      const contextDescriptionSection = document.createElement("div");

      contextTitleSection.textContent = response.context_title;
      contextSubtitleSection.textContent = response.context_subtitle;
      contextDescriptionSection.textContent = response.context_description;

      contextDetailsSection.appendChild(contextTitleSection);
      contextDetailsSection.appendChild(contextSubtitleSection);
      contextDetailsSection.appendChild(contextDescriptionSection);
    },
  });
}

populateDetails();

function moveToSelected(element) {
  if (element == "next") {
    var selected = $(".selected").next();
    count <= data_length && count++;
    count <= data_length && populateCount();
  } else if (element == "prev") {
    var selected = $(".selected").prev();
    count > 0 && count--;
    count > 0 && populateCount();
  } else {
    var selected = element;
  }

  var next = $(selected).next();
  var prev = $(selected).prev();
  var prevSecond = $(prev).prev();
  var nextSecond = $(next).next();

  $(selected).removeClass().addClass("selected");

  $(prev).removeClass().addClass("prev");
  $(next).removeClass().addClass("next");

  $(nextSecond).removeClass().addClass("nextRightSecond");
  $(prevSecond).removeClass().addClass("prevLeftSecond");

  $(nextSecond).nextAll().removeClass().addClass("hideRight");
  $(prevSecond).prevAll().removeClass().addClass("hideLeft");
}

// Eventos teclado
$(document).keydown(function (e) {
  switch (e.which) {
    case 37: // left
      moveToSelected("prev");
      break;

    case 39: // right
      moveToSelected("next");
      break;

    default:
      return;
  }
  e.preventDefault();
});

$("#carousel div").click(function () {
  moveToSelected($(this));
});

$("#prev").click(function () {
  moveToSelected("prev");
});

$("#next").click(function () {
  moveToSelected("next");
});

function populateCarousel() {
  $.ajax({
    type: "post",
    url: "functions/getters.php?function_name=get_context_words",
    data: {
      context_id,
    },
    success: function (res) {
      var response = JSON.parse(res);

      carousel.innerHTML = "";
      data_length = response.length;
      populateCount();

      response.forEach((element, index) => {
        const carouselDiv = document.createElement("div");
        const carouselWord = document.createElement("div");
        const carouselMeaning = document.createElement("div");

        carouselWord.textContent = element.content;
        carouselMeaning.textContent = element.meaning;

        carouselWord.className = "carousel-word";
        carouselMeaning.className = "carousel-meaning";

        carouselDiv.appendChild(carouselWord);
        carouselDiv.appendChild(carouselMeaning);

        if (index == 0) {
          carouselDiv.className = "selected";
        } else if (index == 1) {
          carouselDiv.className = "next";
        } else if (index == 2) {
          carouselDiv.className = "nextRightSecond";
        } else if (index > 2) {
          carouselDiv.className = "hideRight";
        }

        carousel.appendChild(carouselDiv);
      });
    },
  });
}

populateCarousel();

function populateCount() {
  countContainer.textContent = `${count} of ${data_length}`;
}
