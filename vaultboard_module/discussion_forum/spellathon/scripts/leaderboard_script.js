var leaderboard = document.querySelector("#leaderboard tbody");

function populateLeaderboard() {
  leaderboard_data.forEach((player, index) => {
    const tr = document.createElement("tr");
    const rank_td = document.createElement("td");
    const name_td = document.createElement("td");
    const score_td = document.createElement("td");

    rank_td.textContent = index + 1;
    name_td.textContent = player.name;
    score_td.textContent = player.score;

    tr.appendChild(rank_td);
    tr.appendChild(name_td);
    tr.appendChild(score_td);
    leaderboard.appendChild(tr);
  });
}

populateLeaderboard();
