const contextContainer = document.getElementById("context-container");
// var data = [];
var currentPage = 1;
var elementsPerPage = 5;

function populateContextContainer(pageData) {
  contextContainer.innerHTML = "";

  pageData.forEach((element) => {
    const contextDiv = document.createElement("div");
    const contextContent = document.createElement("div");
    const overlayContainer = document.createElement("div");
    const contextTitle = document.createElement("h1");
    const contextSubtitle = document.createElement("p");

    contextTitle.style.textAlign = "center";
    contextSubtitle.style.textAlign = "center";

    contextTitle.textContent = element.context_title;
    contextSubtitle.textContent = element.context_subtitle;

    contextDiv.className = "context-div";
    contextContent.className = "context-content";
    overlayContainer.className = "overlay";
    contextDiv.style.backgroundImage = `url(assets/banners/${element.context_banner})`;

    contextContent.appendChild(contextTitle);
    contextContent.appendChild(contextSubtitle);
    contextDiv.appendChild(overlayContainer);
    contextDiv.appendChild(contextContent);

    const anchor = document.createElement("a");
    anchor.href = `details.php?context_id=${element.context_id}`;
    anchor.appendChild(contextDiv);

    contextContainer.appendChild(anchor);
  });
}

function renderPage(new_data) {
  const startIndex = (currentPage - 1) * elementsPerPage;
  const endIndex = startIndex + elementsPerPage;
  const pageData = new_data.slice(startIndex, endIndex);

  populateContextContainer(pageData);
  updatePaginationButtons();
}

// function get_contexts() {
//   $.ajax({
//     type: "post",
//     url: "functions/getters.php?function_name=get_contexts",
//     success: function (res) {
//       data = JSON.parse(res);
//       renderPage(data); // Render the initial page
//     },
//   });
// }

renderPage(data);

function updatePaginationButtons() {
  const totalPages = Math.ceil(data.length / elementsPerPage);

  const prevButton = document.getElementById("prev-button");
  prevButton.disabled = currentPage === 1;

  const nextButton = document.getElementById("next-button");
  nextButton.disabled = currentPage === totalPages;
}

function goToPage(page) {
  currentPage = page;
  renderPage(data);
}

// document.getElementById("search-input").addEventListener("input", (event) => {
//   var searchTerm = event.target.value.toLowerCase();

//   var new_data = data.filter((element) => element.context_name.toLowerCase().includes(searchTerm));

//   data = new_data; // Update the data based on the search filter
//   currentPage = 1; // Reset to the first page
//   renderPage();
// });

document.getElementById("search-input").addEventListener("input", (event) => {
  var searchTerm = event.target.value.toLowerCase();

  var filteredData;

  if (searchTerm.trim() === "") {
    filteredData = data; // Use the original data when the search term is empty
  } else {
    filteredData = data.filter((element) =>
      element.context_name.toLowerCase().includes(searchTerm)
    );
  }

  // data = filteredData;

  currentPage = 1; // Reset to the first page
  renderPage(filteredData);
});

document.getElementById("prev-button").addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderPage(data);
  }
});

document.getElementById("next-button").addEventListener("click", () => {
  const totalPages = Math.ceil(data.length / elementsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderPage(data);
  }
});

get_contexts();
