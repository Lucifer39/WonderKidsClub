<script src="../assets/js/popper.min.js"></script>
<script src="../assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script> 
<script src="https://demo.webslesson.info/select-box-with-search-box-in-bootstrap-5/library/dselect.js"></script>
<script src="../assets/js/teacher-custom.js"></script> 


<?php if($page == 'group.php') { ?>
<script>
    $(document).on("change","input[name=grpcheck]",function(){var a=$(this).data("id");$.ajax({method:"POST",url:"actAjax",data:{grpAct_active:a}}).done(function(){location.reload()})}),
    $(document).on("change","input[name=grpcheck]:checked",function(){var a=$(this).data("id");$.ajax({method:"POST",url:"actAjax",data:{grpAct_inactive:a}}).done(function(){location.reload()})});

        $(document).ready(function() {
			// Set up the copy button click event
			$('.copylink').click(function() {
				// Copy the link to the clipboard

				var tempInput = document.createElement("input");
				tempInput.value = $(this).data('link');
				document.body.appendChild(tempInput);
				tempInput.select();
				document.execCommand("copy");
				document.body.removeChild(tempInput);

				// Change the button text to "Copied"
                $(".agn-url").children('span').text('Copy Url');
                $(".agn-pass").children('span').text('Copy Password');
				$(this).children('span').text('Copied');
			});
		});
</script>
<?php } ?>
<?php if($page == 'assign-group.php') { ?>
<script>
    $(document).on("click",".clickList li",function(){$(this).children(".sublist").removeClass("hide"),$(this).addClass("open")}),$(document).on("click",".clickList li.open",function(){$(this).children(".sublist").addClass("hide"),$(this).removeClass("open")}),
    $(document).on("change","input[name=grpcheck]",function(){var a=$(this).data("id");$.ajax({method:"POST",url:"actAjax",data:{agrpAct_active:a}}).done(function(){location.reload()})}),
    $(document).on("change","input[name=grpcheck]:checked",function(){var a=$(this).data("id");$.ajax({method:"POST",url:"actAjax",data:{agrpAct_inactive:a}}).done(function(){location.reload()})});

	
	var select_box_element = document.querySelector('#assigngrp');

    dselect(select_box_element, {
        search: true
    });
</script>
<?php } ?>
<?php if($page == 'grp_students.php') { ?>
	<script>
	$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({method:"POST",url:"actAjax",data:{del_tchusr:a}}).done(function(){location.reload()})}),
$(document).on("change","input[name=grpcheck]",function(){var a=$(this).data("id");$.ajax({method:"POST",url:"actAjax",data:{tchusr_active:a}}).done(function(){location.reload()})}),
$(document).on("change","input[name=grpcheck]:checked",function(){var a=$(this).data("id");$.ajax({method:"POST",url:"actAjax",data:{tchusr_inactive:a}}).done(function(){location.reload()})});
</script>
<?php } ?>
<?php if($page == 'profile.php') { ?>
<script>
   $(document).on("click",".dropdown-item",function(){"0"==$(this).data("dselect-value")?$(".others").removeClass("hide"):$(".others").addClass("hide")});
   var select_box_element = document.querySelector('#school'); dselect(select_box_element, {search: true});     
</script>
<?php } ?>
<?php if($page == 'performance.php') { ?>
  <script src="../assets/js/jquery.tablesorter.min.js" integrity="sha512-qzgd5cYSZcosqpzpn7zF2ZId8f/8CHmFKZ8j7mU4OUXTNRd5g+ZHBPsgKEwoqxCtdQvExE5LprwwPAgoicguNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
	$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tbody tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
$(document).ready(function() {
        $("#myTable").tablesorter({
            sortList: [[0, 1]] // Sort the first column (index 0) in descending order (1)
        });
    });
</script>
<?php } ?>