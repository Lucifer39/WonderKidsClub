<div class="container">
    <h1>Insert Questions</h1>
    <div class="input-group mb-3" id="message-indicator"></div>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Universe</span>
        <select class="form-select" aria-label="Default select example" id="select-universe">
            <option selected disabled>Select a universe</option>
            <option value="words">Words</option>
            <option value="idioms">Idioms</option>
            <option value="simile">Simile</option>
            <option value="metaphor">Metaphor</option>
            <option value="hyperbole">Hyperbole</option>
        </select>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text" id="select-elements">Id</span>
        <input class="form-control" list="datalistOptions" id="select-option-id" placeholder="Type to search...">
        <datalist id="datalistOptions">
            <!-- <option value="1">San Francisco</option>
            <option value="2">Los Angeles</option>
            <option value="Seattle">
            <option value="Los Angeles">
            <option value="Chicago"> -->
        </datalist>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon3">Question</span>
        <input type="text" class="form-control" id="question-container" aria-describedby="basic-addon3" placeholder="Type your question...">
    </div>
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input mt-0" name="answer" type="radio" id="radio-option-1" value="" aria-label="Radio button for following text input">
        </div>
        <input type="text" class="form-control" aria-label="" id="text-option-1" placeholder="Option 1">
    </div>
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input mt-0" name="answer" type="radio" id="radio-option-2" value="" aria-label="Radio button for following text input">
        </div>
        <input type="text" class="form-control" aria-label="" id="text-option-2" placeholder="Option 2">
    </div>
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input mt-0" name="answer" type="radio" id="radio-option-3" value="" aria-label="Radio button for following text input">
        </div>
        <input type="text" class="form-control" aria-label="" id="text-option-3" placeholder="Option 3">
    </div>
    <div class="input-group">
        <div class="input-group-text">
            <input class="form-check-input mt-0" name="answer" type="radio" id="radio-option-4" value="" aria-label="Radio button for following text input">
        </div>
        <input type="text" class="form-control" aria-label="" id="text-option-4" placeholder="Option 4">
    </div>
    <div class="input- mb-3 mt-3">
    <button type="button" id="submit-btn" class="btn btn-primary">Submit</button>
    </div>
</div>

<script>
    var universe = "";
    var id = "";
    var options = [];
    var answer = "";
    var question = "";
    const messageIndicator = document.getElementById("message-indicator");
    const datalistContainer = document.getElementById("datalistOptions");
    const submitBtn = document.getElementById("submit-btn");


    document.getElementById("select-universe").addEventListener("change", (event) => {
        universe =event.target.value;
    });

    document.getElementById("select-option-id").addEventListener("input", (event) => {
        var option = event.target.value;

        id =option;

        if(universe == ""){
            messageIndicator.textContent = "Select a universe first";
            messageIndicator.style.color = "red";
        }

        else {
            if(option.length >= 4){
                $.ajax({
                    type: "post",
                    url: "functions/admin_add_questions.php?function_name=get_datalist_options",
                    data: {
                        universe,
                        subst: option
                    },
                    success: function (res) {
                        var response = JSON.parse(res);
                        datalistContainer.innerHTML = "";

                        response.forEach(element => {
                            const optionContainer = document.createElement("option");
                            optionContainer.value = element.id;
                            optionContainer.textContent = element.option;
                            datalistContainer.appendChild(optionContainer);
                        });
                    }
                })
            }
        }
    })

    for(var i = 1; i <= 4; i++){

        (function (index) {
            document.getElementById(`text-option-${index}`).addEventListener("blur", (event) => {
                document.getElementById(`radio-option-${index}`).value = event.target.value;
                options[index - 1] = event.target.value;
            });

            document.getElementById(`radio-option-${index}`).addEventListener("change",(event) => {
                answer = event.target.value;

                // alert(answer);
            })
        })(i);
    }

    document.getElementById("question-container").addEventListener("blur", (event) => {
        question = event.target.value;
    })

    submitBtn.addEventListener("click", () => {
        if(universe == "" || id == "" || question == "" || options.length < 4 || answer == ""){
            messageIndicator.textContent = "All fields must be filled";
            messageIndicator.style.color = "red";

            console.log("options", options);
            console.log("universe", universe);
            console.log("id", id);
            console.log("question", question);
            console.log("answer", answer);
            return;
        }
        else{
            $.ajax({
                type: "post",
                url: "functions/admin_add_questions.php?function_name=insert_questions",
                data: {
                    universe,
                    id,
                    question,
                    options: options.join(","),
                    answer
                },
                success: function (res) {
                    var response =JSON.parse(res);

                    if(response){
                        messageIndicator.textContent = "Question uploaded successfully";
                        messageIndicator.style.color = "green";
                    }
                    else{
                        messageIndicator.textContent = "Error uploading question!";
                        messageIndicator.style.color = "red";
                    }
                }
            })
        }
    })
</script>