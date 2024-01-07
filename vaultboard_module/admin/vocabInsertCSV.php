<!-- Include Papa Parse library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>


<div class="container my-5">
    <h1 class="text-center">Upload CSV File</h1>
    <div class="input-group mb-3">
        <select class="select-form" id="select-universe-csv">
            <!-- <option value="" selected disabled>Select Universe</option> -->
            <option value="words" selected>Words</option>
            <!-- <option value="idioms">Idioms</option>
            <option value="simile">Simile</option>
            <option value="metaphor">Metaphor</option>
            <option value="hyperbole">Hyperbole</option> -->
        </select>
    </div>
    <form id="csvForm" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <input type="file" name="csvFile" id="csvFile" class="form-control" accept=".csv">
            <button type="button" class="btn btn-primary" onclick="processCSV(event)">Upload</button>
        </div>
    </form>
    <div id="result" class="text-center font-weight-bold"></div>
    <a id="downloadLink" download="output.csv" style="display: none;">
        <button class="btn btn-primary" disabled>
            Download Processed CSV
        </button>
    </a>
</div>

<script>
    const selectUniverse = document.getElementById("select-universe-csv");
    function processCSV(event) {
        event.preventDefault();

         // Check if an universe is selected
         if (selectUniverse.value === "") {
            $("#result").text("Select an universe first.");
            return;
        }

        // Get the uploaded CSV file
        const fileInput = document.getElementById("csvFile");
        const file = fileInput.files[0];

        // Check if a file is selected
        if (!file) {
            $("#result").text("Please select a CSV file.");
            return;
        }

         
        const csvForm = $('#csvForm')[0];
        const formData = new FormData(csvForm);

        $.ajax({
            url: 'functions/process_csv.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                data =JSON.parse(data);
                const resultDiv = $('#result');
                resultDiv.html(data.message);

                if (data.downloadLink) {
                    const downloadLink = $('#downloadLink');
                    downloadLink.attr('href', "outputs/" + data.downloadLink);
                    
                    // Show the download button
                    downloadLink.css('display', 'block');
                    
                    // Enable the button within the download link
                    downloadLink.find('button').removeAttr('disabled');
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
}
  
</script>
