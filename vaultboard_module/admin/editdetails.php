
<!-- Admin Enter Details Form -->
<div class="container mt-3 rounded">
    <form class="row g-3 p-5 border" method="post" action="" enctype="multipart/form-data">
        <h5 class="text-center"><b>Admin Enter Details Page</b></h5>
        <h4 class="text-center"></h4>
        <input type="hidden" name="admindisplaydetails"/>
        <div class="row g-3">
            <div class="col-md-4">
                <label for="eventname" class="form-label">Event Name</label>
                <input type="text" class="form-control shadow" id="eventname" name="eventname">
            </div>
            <div class="col-md-4">
                <label for="orgname" class="form-label">Organized By</label>
                <input type="text" class="form-control shadow" id="orgname" name="orgname">
            </div>
            <div class="col-md-4">
                <label for="contact" class="form-label">Contact Number</label>
                <input type="phone" class="form-control shadow" id="contact" name="contact">
            </div>
            <div class="col-md-4">
                <label for="category" class="form-label">Opportunity Category</label>
                <select id="category" class="form-select shadow" name="category">
                    <option selected>Select Category</option>
                    <option>Quizzes</option>
                    <option>Workshops</option>
                    <option>Hackathon</option>
                    <option>Competitions</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="rfee" class="form-label">Registration Fee</label>
                <input type="text" class="form-control shadow" id="rfee" name="rfee">
            </div>
            <div class="col-md-4">
                <label for="prize" class="form-label">Prizes</label>
                <textarea type="text" class="form-control shadow" id="prize" name="prize" rows="1"></textarea>
            </div>
            <div class="col-md-4">
                <label for="startdate" class="form-label">Start Date</label>
                <input type="text" class="form-control shadow" id="startdate" name="startdate"
                placeholder="Start Date"
                onfocus="(this.type='date')"
                onblur="(this.type='text')">
            </div>
            <div class="col-md-4">
                <label for="enddate" class="form-label">End Date</label>
                <input type="text" class="form-control shadow" id="enddate" name="enddate"
                    placeholder="End Date"
                    onfocus="(this.type='date')"
                    onblur="(this.type='text')">
            </div>
            <div class="col-md-4">
                <label for="rdate" class="form-label">Add Stages</label>
                <button type="button" class="form-control border-0 btn-primary addmore"
                    style="border-radius:10px;"><b>Add +</b></button>
            </div>
            <div class="row" id="stageid"></div>
            <div class="col-md-4">
                <label for="url" class="form-label">URL Upload</label>
                <input type="text" class="form-control shadow" id="url" name="url">
            </div>
            <div class="col-md-4">
                <label for="pdfattach" class="form-label">PDF Upload</label>
                <input type="file" class="form-control shadow" accept="application/pdf" id="ppdfattach" name="pdfattach">
            </div>
            <div class="col-md-4">
                <label for="banner" class="form-label">Banner Upload</label>
                <input type="file" class="form-control shadow"  id="banner" name="banner">
            </div>
        </div>
        <div class="mt-5 text-center">
            <input type="submit" class="col-md-4 p-2 btn-primary rounded" name="submit-edit" value="SUBMIT">
        </div>
    </form>
</div>
<script>
    // by clicking on the add+ button we can add stages for that particular event
    $(".addmore").on('click', function() {
        // var count = $('$sigma-id div').length - 1;
        var data = "<div class='input-group col-md-12 rounded' style='margin-top:10px'><input type='text' class='rounded col-md-4 form-control' name='stagename[]' placeholder='Stage Name'/>";
        data += "<input type='date' class='rounded col-md-3 form-control' name='sdate[]' placeholder='Start Date'/><input type='date' class='rounded col-md-3 form-control' name='edate[]' placeholder='End Date'/><button class='remCF btn btn-outline-danger m-3 rounded'>Remove</button></div>";
        $('#stageid').append(data);
    });
    $("#stageid").on("click",'.remCF',function(){
        $(this).closest('div').remove(); 
    });
</script>

<?php 
if(isset($_POST["submit-edit"])) {
        if(!empty($_FILES['banner']['name'])){
            $eventname=$_POST['eventname'] ?? '';
            $orgname=$_POST['orgname'] ?? '';
            $phone = $_POST['contact'] ?? '';
            $category = $_POST['category'] ?? '';
            $fee=$_POST['rfee'] ?? 0;
            $prize=$_POST['prize'] ?? '';
            $startdate=$_POST['startdate'] ?? '';
            $enddate=$_POST['enddate'] ?? '';
            $url = $_POST['url'] ?? '';

            $stagename = $_POST['stagename'] ?? [];
            $sdate = $_POST['sdate'] ?? '';
            $edate = $_POST['edate'] ?? '';

            $dir_ed = dirname(__DIR__);
            $uploadDir = "$dir_ed/competitions/images/pdfupload/";
            $fileName = basename($_FILES["pdfattach"]["name"]);
            $targetPath = $uploadDir. $fileName;

            $uploadBanner = "$dir_ed/competitions/images/banner/";
            $banner = basename($_FILES["banner"]["name"]);
            $targetBanner = $uploadBanner. $banner;


            if(move_uploaded_file($_FILES["pdfattach"]["tmp_name"], $targetPath) 
            || move_uploaded_file($_FILES["banner"]["tmp_name"], $targetBanner)){
                $conn = makeConnection();
                    $sql="INSERT INTO `displaydetails` (`banner`,`event_name`, `organized_by`, `contact_no`, `opportunity`, `reg_fee`, `prizes`, `start_date`, `end_date`, `url`, `pdf`) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "sssssssssss", $banner,$eventname,$orgname,$phone,$category,$fee,$prize,$startdate,$enddate,$url,$fileName);
                    if(mysqli_stmt_execute($stmt)){
                        $did = mysqli_insert_id($conn);
                        foreach($stagename as $id=>$val){
                            // Get files upload path
                            $stage = $stagename[$id];
                            $start = $sdate[$id];
                            $end = $edate[$id];
                            // inserting stages for that particular event if any
                            $stage = "INSERT INTO `stagestable`(`name`, `startdate`, `enddate`, `did`) VALUES ('$stage','$start','$end','$did')";
                            if(mysqli_query($conn, $stage)){
                                echo "Submitted";
                            }else{
                                echo "error";
                            }
                        }
                    } else{
                        echo "error";
                    }
            }
        }else{
            echo '<script>
                    alert("Please upload the Banner for the Event")
                </script>';
        }
}
?>