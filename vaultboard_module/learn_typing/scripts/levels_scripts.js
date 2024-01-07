const levels = {};
var count_ongoing = 0;

// Group data by level
progress.forEach((item) => {
  if (!levels[item.level_name]) {
    levels[item.level_name] = {};
  }

  if (!levels[item.level_name][item.skill_name]) {
    levels[item.level_name][item.skill_name] = [];
  }

  levels[item.level_name][item.skill_name].push(item);
});

const levelsContainer = document.getElementById("levels-container");
// Create the fixed UL element
const ul = document.createElement("ul");
ul.classList.add("applicationStatus");

for (const levelName in levels) {
  
  // Create the level name LI element
  const levelLI = document.createElement("li");
  levelLI.classList.add("applicationStatusGood");

  const imglevel = document.createElement('img');
  imglevel.src="images/sign.png";
  imglevel.style.width = "33px";

  levelLI.appendChild(imglevel);

  const levelNameSpan = document.createElement("span");
  levelNameSpan.textContent = " "+levelName;
  levelLI.appendChild(levelNameSpan);
  levelLI.style.cursor = 'pointer';

    levelLI.addEventListener("click", () => {
    const levelLIs = ul.querySelectorAll("li");
    
    levelLIs.forEach((li) => {
      li.classList.remove("activelevel");
    });
  
    const isActive = levelLI.classList.contains("activelevel");
    if (!isActive) {
      levelLI.classList.add("activelevel");
    }
    
    // Hide all level details
    const levelDivs = levelsContainer.querySelectorAll(".level-details");
    levelDivs.forEach((div) => {
      div.style.display = "none";
    });

    const levelDetails = levelsContainer.querySelector(`#${levelName}-details`);
    levelDetails.style.display = isActive ? "none" : "block";

    // Show the clicked level details
    // const levelDetails = levelsContainer.querySelector(`#${levelName}-details`);
    // levelDetails.style.display = "block";
  });

  // Append the level name LI element to the UL
  ul.appendChild(levelLI);

  const firstLevelLI = ul.querySelector("li");
  firstLevelLI.classList.add("activelevel");

  const levelDiv = document.createElement("div");
  levelDiv.classList.add("level-details");
  levelDiv.id = `${levelName}-details`;
  levelDiv.style.display = "none";
  
  // const skillRowDiv = document.createElement("div");
  // skillRowDiv.classList.add("text-dark", "g-4", "mt-5");

  for (const skillName in levels[levelName]) {
    const skillDiv = document.createElement("div");
    skillDiv.classList.add("skill","p-4");

    // Create the card element
    const cardDiv = document.createElement("div");
    cardDiv.classList.add("card", "bg-img", "border-0", "shadow");
    
    // Create the card body element
    const cardBodyDiv = document.createElement("div");
    cardBodyDiv.classList.add("card-body");
    
    // Create the card border text element
    const cardBorderTextDiv = document.createElement("div");
    cardBorderTextDiv.classList.add("card-border-text");
    cardBorderTextDiv.setAttribute("data-content", skillName);
    
    // Create the text center element
    const textCenterDiv = document.createElement("div");
    textCenterDiv.classList.add("row","ps-5","pe-5");

    // Create the table element
    const table = document.createElement("table");
    table.classList.add("table", "mt-5");

    // Create the table header row
    const thead = document.createElement("thead");
    thead.classList.add("text-center","h6","bg-light","rounded");
    const headerRow = document.createElement("tr");

    const groupBtnHeader = document.createElement("th");
    groupBtnHeader.textContent = "Exercises";

    const groupDescHeader = document.createElement("th");
    groupDescHeader.textContent = "About";

    const alphabetsHeader = document.createElement("th");
    alphabetsHeader.textContent = "Alphabets";

    // Append the table headers to the header row
    headerRow.appendChild(groupBtnHeader);
    headerRow.appendChild(groupDescHeader);
    headerRow.appendChild(alphabetsHeader);

    // Append the header row to the table header
    thead.appendChild(headerRow);

    // Append the table header to the table
    table.appendChild(thead);

    // Create the table body
    const tbody = document.createElement("tbody");
    tbody.classList.add("mt-3");
    
    // Generate the group buttons
    for (let i = 0; i < levels[levelName][skillName].length; i++) {
      const item = levels[levelName][skillName][i];
      const row = document.createElement("tr");

      // Create table cells for group button, group description, and alphabets
      const groupBtnCell = document.createElement("td");
      const groupDescCell = document.createElement("td");
      const alphabetsCell = document.createElement("td");

      const anchor = document.createElement("a");
      anchor.href = "#";

      const groupButton = document.createElement("a");
      // groupButton.href = "index.php?page=play&group_id=" + item.group_id;
      groupButton.classList.add("btn", "border-0", "btn-dark", "p-3", "h4", "group");
      groupButton.textContent = item.group_name;
      
      groupButton.dataset.status = item.status;
      
      const imgicon = document.createElement("i");
      imgicon.classList.add("bi","bi-star-fill","text-warning");

      // Determine the star icon based on exercise position and skill count
      const skillCount = levels[levelName][skillName].length;
      if (skillCount === 1) {
        // Skill has only one exercise: filled star
        imgicon.classList.remove("bi-star");
        imgicon.classList.add("bi-star-fill");
      } else if (i === 0) {
        // First exercise: empty star
        imgicon.classList.remove("bi-star-fill", "bi-star-half");
        imgicon.classList.add("bi-star");
      } else if (i === skillCount - 1) {
        // Last exercise: fill star
        imgicon.classList.remove("bi-star");
        imgicon.classList.add("bi-star-fill");
      } else {
        // Middle exercises: half star
        imgicon.classList.remove("bi-star", "bi-star-fill");
        imgicon.classList.add("bi-star-half");
      }

      const groupDesc = document.createElement("h5");
      groupDesc.classList.add("group-desc");
      groupDesc.textContent = item.para;
      
      const groupAlphabets = document.createElement("div");
      groupAlphabets.classList.add("group-desc","bubble");
      
      const groupinnerAlphabets = document.createElement("div");
      groupinnerAlphabets.classList.add("bubble1"); 
      
      const grouptextAlphabets = document.createElement("h6");
      grouptextAlphabets.classList.add("text-center"); 
      grouptextAlphabets.textContent = item.alphabets;
      
      if (item.status === "not started") {
        groupButton.disabled = true;
        groupButton.href = "#";
        skillDiv.appendChild(groupButton);
      } else {
        groupButton.href = "index.php?page=play&group_id=" + item.group_id + "&group_name=" + item.group_name;
        count_ongoing++;
        anchor.appendChild(groupButton);
        skillDiv.appendChild(anchor);
      }
      
      
      // textCenterDiv.appendChild(groupButton);
      // textCenterDiv.appendChild(groupDesc);
      groupinnerAlphabets.appendChild(grouptextAlphabets);
      groupAlphabets.appendChild(groupinnerAlphabets);
      // textCenterDiv.appendChild(groupAlphabets);

      groupBtnCell.appendChild(groupButton);
      groupDesc.appendChild(imgicon);
      groupDescCell.appendChild(groupDesc);
      alphabetsCell.appendChild(groupAlphabets);

      // Append the table cells to the row
      row.appendChild(groupBtnCell);
      row.appendChild(groupDescCell);
      row.appendChild(alphabetsCell);

      // Append the row to the table body
      tbody.appendChild(row);
    }
    
    table.appendChild(tbody);

    // Append the elements to their respective parents
    cardBodyDiv.appendChild(cardBorderTextDiv);
    cardBodyDiv.appendChild(table);
    // cardBodyDiv.appendChild(textCenterDiv);

    cardDiv.appendChild(cardBodyDiv);

    // Append the table to the skillDiv
    // skillDiv.appendChild(table);
    

    skillDiv.appendChild(cardDiv);
    // skillRowDiv.appendChild(skillDiv);
    levelDiv.appendChild(skillDiv);
    
  }
  
  // Append the levelDiv to the levelsContainer
  levelsContainer.appendChild(levelDiv);
}
// Insert the fixed UL at the top of the levelsContainer
levelsContainer.insertBefore(ul, levelsContainer.firstChild);

const firstLevelDiv = levelsContainer.querySelector(".level-details");
firstLevelDiv.style.display = "block";