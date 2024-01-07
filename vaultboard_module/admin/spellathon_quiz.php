<style>
    .container{
        width: 100%
    }

    #spellathon-quiz-form{
        width: 100%
    }
</style>

<div class="container">
    <h1>Spellathon Quiz</h1>
    <div class="input-group mb-3" id="message-indicator-spellathon"></div>
    <form id="spellathon-quiz-form">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Start on: </span>
            <input type="datetime-local" class="form-control" name="quiz-datetime" id="quiz-datetime">
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="quiz-select">For Group: </label>
            <select class="form-select" id="quiz-select" name="quiz-select">
                <option selected disabled value="">Choose Group...</option>
                <option value="1">1 - Prep</option>
                <option value="2">2 - Classes 1 and 2</option>
                <option value="3">3 - Classes 3, 4 and 5</option>
            </select>
        </div>
        <button class="btn btn-primary" type="submit">Add Quiz</button>
    </form>

    <div class="mb-3" style="width: 100%; border-top: 1px solid grey;">
    <table class="table table-striped table-hover" id="spellathon-rooms">
        <thead>
            <tr>
                <th scope="col">Room id</th>
                <th scope="col">Group</th>
                <th scope="col">Start From</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    </div>
</div>

<script>
    const tableBody =document.querySelector("#spellathon-rooms tbody");

    function populate_room_table(){
    $.ajax({
        type: "post",
        url: "../spellathon/functions/waiting_room_functions.php?function_name=get_rooms",
        success: function(res) {
            var response = JSON.parse(res);
            tableBody.innerHTML = "";

            response.forEach(element => {
                const tr = document.createElement("tr");
                const id_td = document.createElement("td");
                const group_td = document.createElement("td");
                const start_td = document.createElement("td");

                id_td.textContent = element.id;
                group_td.textContent =element.relevance;
                start_td.textContent = element.start_at;

                tr.appendChild(id_td);
                tr.appendChild(group_td);
                tr.appendChild(start_td);

                tableBody.appendChild(tr);
            });
        }
    })
}

populate_room_table();

    const formSpellathon =document.getElementById("spellathon-quiz-form");
    const messageIndicatorSpellathon = document.getElementById("message-indicator-spellathon");

    formSpellathon.addEventListener("submit", (event) => {
        event.preventDefault();

        const quizDateTime = document.getElementById("quiz-datetime").value;
        const quizSelect = document.getElementById("quiz-select").value;

        console.log(quizDateTime);

        if(quizDateTime.trim() == "" || quizSelect.trim() == ""){
            messageIndicator.textContent = "Fill in all the fields!";
            return;
        }

        messageIndicator.textContent = "";
        
        $.ajax({
            type: "post",
            url: "../spellathon/functions/waiting_room_functions.php?function_name=create_room",
            data: {
                start_date_time: quizDateTime,
                class_group: quizSelect
            },
            success: function (res) {
                var response =JSON.parse(res);

                messageIndicatorSpellathon.textContent = response;
                populate_room_table();
            }
        })

    })
</script>