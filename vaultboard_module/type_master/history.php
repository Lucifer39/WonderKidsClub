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

.container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: #185875;
}

.container td {
	  font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}

.container {
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

.container td, .container th {
	  padding-bottom: 2%;
	  padding-top: 2%;
  padding-left:2%;  
}

/* Background-color of the odd rows */
.container tr:nth-child(odd) {
	  background-color: #323C50;
}

/* Background-color of the even rows */
.container tr:nth-child(even) {
	  background-color: #2C3446;
}

.container th {
	  background-color: #1F2739;
}

.container td:first-child { color: #FB667A; }

.container tr:hover {
   background-color: #464A52;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

@media (max-width: 800px) {
.container td:nth-child(4),
.container th:nth-child(4) { display: none; }
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

<div class="container-mid">
    <h1>History</h1>
    <div class="history-table">
        <table class="container" id="history-table">
            <thead>
                <tr>
                    <th scope="col">Sr.No.</th>
                    <th scope="col">Room Id</th>
                    <th scope="col">Room Type</th>
                    <th scope="col"></th>
                    <th scope="col">Created On</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <div class="button-container">
            <button id="prevButton">Prev</button>
            <button id="nextButton">Next</button>
        </div>
    </div>

<script src="scripts/history_script.js"></script>