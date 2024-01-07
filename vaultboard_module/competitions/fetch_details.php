<?php
require_once('../global/navigation.php');
require_once(ROOT_FOLDER.'global/navbar.php');
include_once ROOT_FOLDER.'connection/conn.php';

$conn = makeConnection();

$cardId = $_GET['id'];

$display = "SELECT * FROM `displaydetails` WHERE id='$cardId'";
$result = mysqli_query($conn,$display);

$stages = "SELECT * FROM `stagestable` WHERE did='$cardId'";
$stageresult = mysqli_query($conn,$stages);
?>

<link rel='stylesheet' type='text/css' href='./style.css' />
<body class="bg-light">
<?php if (mysqli_num_rows($result) > 0) { $row = mysqli_fetch_assoc($result); ?>
    <div class="mt-4">
        <div class="container text-center mt-5 p-0">
            <div class="card mb-3 shadow border-0" style="margin-top:80px;border-radius:20px">
                <div class="d-flex justify-content-evenly align-items-center">
                    <div style="width: 500px">
                        <img src="images/banner/<?php echo $row['banner'] ?>" class="card-img-topdes" alt="...">
                    </div><br/>
                    <div class="text-start p-5">
                        <h5 class="card-title"><b><?php echo $row['event_name'] ?></b></h5>
                        <h5 class="text-muted"><b>Category: <?php echo $row['opportunity'] ?></b></h6>
                        <hr class="mt-3 border-2 border-secondary border-bottom"/>
                        <h6 class="text-muted"><i class="bi bi-calendar2-event-fill text-warning" style="font-size:20px"></i><b> <?php echo date('j F, Y', strtotime($row['start_date'])) ?></b></h6>
                        <h6 class="text-muted"><i class="bi bi-geo-alt-fill text-danger" style="font-size:20px"></i><b> <?php echo $row['organized_by'] ?></h5>
                        <h6 class="text-muted"><i class="bi bi-hourglass-split" style="font-size:20px"></i><b> Registrations till <?php echo date('j F, Y', strtotime($row['end_date'])) ?></b></h6yle=>
                        <!-- <h6 class="text-muted"><i class="bi bi-telephone-fill text-info" style="font-size:20px"></i><b> <?php echo $row['contact_no'] ?></b></h6> -->
                        <div class="d-flex justify-content-start mt-3">
                            <h5 class="mt-2" style="margin-right:10px"><b><i class="bi bi-currency-rupee"></i><?php echo $row['reg_fee'] ?></b></h5>
                            <button class="btn btn-info shadow">REGISTER</button>
                        </div>
                        <hr class="mt-4 border-2 border-secondary border-bottom"/>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="container">
                        <div class="row g-3">  
                            <?php if (mysqli_num_rows($stageresult) > 0) { ?>
                                <h4 class="mt-5 text-start"><img src="./images/timeline.png"> <b>Stages and Timelines</b></h4>
                                 <div class="card shadow rounded text-start">
                                    <div class="card-body p-3">
                                        <?php $i=1; 
                                        while($stager = mysqli_fetch_assoc($stageresult)){ ?> 
                                            <div class="p-2">
                                                <h5 style="font-size:18px"><ul><li><b>Round <?php echo $i ?>: </b><?php echo $stager['name'] ?></li></ul></h5>
                                                <div class="row g-3">
                                                    <div class="col-md-2">
                                                        <div class="d-flex align-items-center p-1 border-2 border-dark border-end">
                                                            <h5 class="ms-2" style="font-size:16px"><b>Start Date<br/><span class="text-muted"><?php echo $stager['startdate'] ?></span></b></h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="d-flex align-items-center p-1">
                                                            <h5 class="ms-2" style="font-size:16px"><b>End Date<br/><span class="text-muted"><?php echo $stager['enddate'] ?></span></b></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                            $i++;
                                        }?>
                                    </div>
                                </div>
                            <?php }
                            $prizes = $row['prizes'];
                            $prizeArray = explode('/', $prizes);
                            ?>
                            <h4 class="mt-5 text-start"><img src="./images/medal.png"> <b>Prizes & Awards</b></h4>
                            <div class="container mt-2">
                                <div class="row">
                                <?php foreach ($prizeArray as $prize) { ?>
                                    <div class="col-sm-4">
                                        <div class="card shadow rounded">
                                            <div class="card-body">
                                                <h6 class="card-title"><b><?php echo $prize ?></b></h6>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                            <h4 class="mt-5 text-start"><img src="./images/pdf.png"/> <b>PDF Attachment</b></h4>
                            <iframe src="images/pdfupload/<?php echo $row['pdf'] ?>" height="450px"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }else{?>
    <h4>No record found</h4>
<?php } ?>
</body>