<?php 
    $dir = __DIR__;
    require_once($dir . "/functions/leaderboard_functions.php");

    $room_code = $_GET["ri"] ?? 0;

    $leaderboard_data = get_leaderboard($room_code);
?>

<style>
    @charset "UTF-8";
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

h1 {
  font-size:3em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}

/* h2 {
  font-size:1em; 
  font-weight: 300;
  text-align: center;
  display: block;
  line-height:1em;
  padding-bottom: 2em;
  color: #FB667A;
} */

h2 a {
  font-weight: 700;
  text-transform: uppercase;
  color: #FB667A;
  text-decoration: none;
}

.blue { color: #185875; }
.yellow { color: #FFF842; }

.leaderboard-container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: #185875;
}

.leaderboard-container td {
	  font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}

.leaderboard-container {
	  text-align: left;
	  overflow: hidden;
	  width: 80%;
	  margin: 0 auto;
  display: table;
  padding: 0 0 8em 0;
  color: #fff;
  border-radius: 1rem;
  box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
}

.leaderboard-container td, .leaderboard-container th {
	  padding-bottom: 2%;
	  padding-top: 2%;
  padding-left:2%;  
}

/* Background-color of the odd rows */
.leaderboard-container tr:nth-child(odd) {
	  background-color: #323C50;
}

/* Background-color of the even rows */
.leaderboard-container tr:nth-child(even) {
	  background-color: #2C3446;
}

.leaderboard-container th {
	  background-color: #1F2739;
}

.leaderboard-container td:first-child { color: #FB667A; }

.leaderboard-container tr:hover {
   background-color: #464A52;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

@media (max-width: 800px) {
.leaderboard-container td:nth-child(4),
.leaderboard-container th:nth-child(4) { display: none; }
}

.button-container{
    padding: 1rem;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 5rem;
}

.button-container button#prevButton{
    border-radius: 0.5rem 0 0 0.5rem !important;
    padding: 1rem;
}

.button-container button#nextButton{
    border-radius: 0 0.5rem 0.5rem 0 !important;
    padding: 1rem;
}

.button-container button:disabled{
    background: #F0F0F0 !important;
}
</style>

<script>
    var leaderboard_data = <?php echo json_encode($leaderboard_data); ?>;
</script>

<div class="leaderboard-container">
    <h1>Leaderboard</h1>
    <table class="leaderboard-container" id="leaderboard">
        <thead>
            <tr>
                <th scope="col">Rank</th>
                <th scope="col">Student</th>
                <th scope="col">Score</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="scripts/leaderboard_script.js"></script>