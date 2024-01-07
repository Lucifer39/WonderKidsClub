<?php 

    $getid = getID();
    $progress = [];
    if($getid !== ""){
        $student = getCurrentStudent();
        $progress = json_encode(get_progress($student["id"]));
    }else{
        $student = getGuest();
        $progress = json_encode(get_exercise(1));
    }
?>

<script>
    var progress = <?php echo $progress; ?>;
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
    .tooltip-bg {
    background-color: #f5f5f5; /* Set the desired background color */
    color: #000; /* Set the desired text color */
  }
</style>
    <div id="popuplevl" class="popuplevl">
        <div class="popup-content text-dark">
            <h5 class="p-2"><i class="bi bi-arrow-down-circle-fill" style="color:green"></i> Click on the Exercises to Learn</h5>
        </div>
    </div>
    <div class="levels-page-container p-0">
        <div class="row">
        <div id="levels-container"></div>
    </div>
<script src="scripts/levels_scripts.js"></script>
<script>

  // Retrieve the accuracy value from localStorage
  var accuracyValue = localStorage.getItem("accuracyValue");

  // Update the title attribute of the tooltip with the accuracy value
  document.querySelector('[data-bs-toggle="tooltip"]').setAttribute("title", "Accuracy: " + accuracyValue);

  // Initialize the Bootstrap tooltip
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

document.addEventListener("DOMContentLoaded", function() {
    var popup = document.getElementById("popuplevl");

    // Set a timeout to show the popup after 5 seconds
    setTimeout(function() {
        popup.classList.remove("hidden");
    }, 5000);

    // Set a timeout to hide the popup after 10 seconds
    setTimeout(function() {
        popup.classList.add("hidden");
    }, 5000);
});


</script>