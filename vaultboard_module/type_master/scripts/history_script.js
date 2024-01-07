const historyTable = document.querySelector("#history-table tbody");
const prevButton = document.querySelector("#prevButton");
const nextButton = document.querySelector("#nextButton");

const itemsPerPage = 10; // Number of items to show per page
// const numberOfPage = data.length / itemsPerPage;
let currentPage = 1; // Current page number
let data = []; // Placeholder for the data

function populateHistoryTable() {
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const currentPageData = data.slice(startIndex, endIndex);

  historyTable.innerHTML = "";

  currentPageData.forEach((element, index) => {
    const rowTr = document.createElement("tr");
    const indexTd = document.createElement("td");
    const roomIdTd = document.createElement("td");
    const roomTypeTd = document.createElement("td");
    const visitRoomTd = document.createElement("td");
    const createdTd = document.createElement("td");

    indexTd.textContent = index + startIndex + 1;
    roomIdTd.textContent = element.room_id;
    roomTypeTd.textContent = element.room_type;
    createdTd.textContent = getTimeAgo(element.created_at);

    const visitBtn = document.createElement("button");
    const anchor = document.createElement("a");
    visitBtn.textContent = "View";
    anchor.href = `index.php?page=waiting_room_page&rc=${element.room_id}&ro=1&rt=${element.room_type}`;
    anchor.appendChild(visitBtn);
    visitRoomTd.appendChild(anchor);

    rowTr.appendChild(indexTd);
    rowTr.appendChild(roomIdTd);
    rowTr.appendChild(roomTypeTd);
    rowTr.appendChild(visitRoomTd);
    rowTr.appendChild(createdTd);

    historyTable.appendChild(rowTr);
  });

  // Disable/enable navigation buttons based on the current page
  prevButton.disabled = currentPage === 1;
  nextButton.disabled = currentPage === getTotalPages();
}

function getTimeAgo(datetimeString) {
  const timestamp = new Date(datetimeString).getTime();
  const currentTime = Date.now();
  const timeDifference = currentTime - timestamp;

  const seconds = Math.floor(timeDifference / 1000);
  const minutes = Math.floor(seconds / 60);
  const hours = Math.floor(minutes / 60);
  const days = Math.floor(hours / 24);
  const months = Math.floor(days / 30);
  const years = Math.floor(months / 12);

  if (seconds < 60) {
    return "Just now";
  } else if (minutes < 60) {
    return minutes === 1 ? "1 minute ago" : `${minutes} minutes ago`;
  } else if (hours < 24) {
    return hours === 1 ? "1 hour ago" : `${hours} hours ago`;
  } else if (days < 30) {
    return days === 1 ? "1 day ago" : `${days} days ago`;
  } else if (months < 12) {
    return months === 1 ? "1 month ago" : `${months} months ago`;
  } else {
    return years === 1 ? "1 year ago" : `${years} years ago`;
  }
}

function init() {
  $.ajax({
    type: "post",
    url: "functions/history_functions.php?function_name=get_history",
    data: {
      user_id: current_student.id,
    },
    success: function (res) {
      data = JSON.parse(res);
      renderTable();
    },
  });
}

function goToPage(page) {
  if (page < 1 || page > getTotalPages()) {
    return;
  }
  currentPage = page;
  renderTable();
}

function getTotalPages() {
  return Math.ceil(data.length / itemsPerPage);
}

prevButton.addEventListener("click", () => {
  goToPage(currentPage - 1);
});

nextButton.addEventListener("click", () => {
  goToPage(currentPage + 1);
});

function renderTable() {
  populateHistoryTable();
}

// Call init function initially to populate the data and render the table
init();
