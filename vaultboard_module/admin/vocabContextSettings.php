<div class="modal fade" id="add-date-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Date</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3" id="message-indicator-context"></div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Context</span>
                <select class="form-select" aria-label="Default select example" id="select-context">
                    <option selected disabled>Select a context</option>
                </select>
            </div>
            <div class='input-group mb-3'>
                <span class="input-group-text" id="basic-addon1">Pick a date</span>
                <input type="date" class="form-control" id="date-container" aria-describedby="basic-addon3" placeholder="Enter Date...">
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add-context-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Context</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3" id="message-indicator-context"></div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Context</span>
                <input type="text" class="form-control" id="context-name-container" aria-describedby="basic-addon3" placeholder="Enter Context Name...">
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="context-banner-file">Upload Banner</label>
                <input type="file" class="form-control" id="context-banner-file">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Title</span>
                <input type="text" class="form-control" id="context-title-container" aria-describedby="basic-addon3" placeholder="Enter Title Name...">
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
    <h1>Vocabulary Context Settings</h1>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-date-modal">Add Date</button>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#add-context-modal">Add Context</button>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Title</th>
                <th scope="col">Banner</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
    const selectContext = document.getElementById("select-context");
    const titleContainer =document.getElementById("title-container");

    $.ajax({
        type: "post",
        url: "functions/admin_context_settings_functions.php?function_name=get_contexts",
        success: function (res) {
            var response = JSON.parse(res);

            response.forEach(context => {
                var optionContainer = document.createElement("option");
                optionContainer.value = context.id;
                optionContainer.textContent = context.name;

                selectContext.appendChild(optionContainer);
            })
        }
    })

    selectContext.addEventListener("change", () => {

    })
</script>