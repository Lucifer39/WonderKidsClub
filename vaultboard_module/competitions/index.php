<?php 
require_once('../global/navigation.php');
require_once(ROOT_FOLDER.'global/navbar.php');
include_once ROOT_FOLDER.'connection/conn.php';

$conn = makeConnection();

$viewDisplay = "SELECT * FROM `displaydetails`";
$resultView = mysqli_query($conn,$viewDisplay);

?>
<link rel='stylesheet' type='text/css' href='./style.css' />
<body>

<div class="container">
    <div class="row">
        <div class="row d-flex justify-content-center gy-3 mt-5">
            <?php while($row = mysqli_fetch_assoc($resultView)){ ?>
                <div class="col mt-5">
                    <div style="cursor:pointer;background-color:#00001a;border-radius:10px" class="card shadow cardView compdetail border-0">
                        <a href="fetch_details.php?id=<?php echo $row['id']; ?>" style="text-decoration:none">
                        <div class="d-flex align-items-center">
                            <img src="images/banner/<?php echo $row['banner'] ?>" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body border-top border-3 border-dark bg-white" style="border-radius:0 0 10px 10px">
                            <div class="card-body-container d-flex flex-column justify-content-between">
                                <div style="height:60px;display:flex">
                                    <h5 class="text-start mb-0"><b><?php echo $row['event_name'] ?></b></h5>
                                </div>
                                <h6 class="mb-0"><i class="bi bi-clock-fill"></i><b> 28 days left</b></h6>
                                <h6 class="mt-2 text-secondary">
                                    <?php if($row['reg_fee'] == 0){ ?>
                                    <b><?php echo 'FREE'; ?></b>
                                    <?php }else{ ?>
                                    <i class="bi bi-currency-rupee"></i><b><?php echo $row['reg_fee'] ?></b>
                                    <?php } ?> 
                                </h6>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<button class="open-button shadow" onclick="openForm()" data-bs-toggle="modal" data-bs-target="#competitionupload"><img src="./images/upload.svg" width="50"/>Share Competition Details</button>
<br/><br/><br/>
</body>
<!-- Modal -->
<div class="modal fade" id="competitionupload" tabindex="-1" aria-labelledby="competitionupload" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body justify-content-center p-3">
        <h5 class="text-center mt-2"><b>Everyone deserves an Opportunity <i class="bi bi-stars"></i></b></h5>
        <!-- Oppotunity Upload Button Cards -->
        <div class="container mt-4">
            <div class="row d-flex justify-content-center">
                <div class="col-sm-5">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <img src="images/parents.svg" width="145px"/><br/>
                            <button type="button" class="col-md-6 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#parentsShare" data-bs-dismiss="modal">
                                Parents
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="card shadow border-0">
                        <div class="card-body text-center">
                            <img src="images/org.svg" width="120px"/><br/><br/>
                            <button type="button" class="col-md-6 btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#organizeShare" data-bs-dismiss="modal">
                                Organization
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div><br/><br/>

      </div>
    </div>
  </div>
</div>

<!-- Parents Form Filling Modal -->
<div class="modal fade" id="parentsShare" tabindex="-1" aria-labelledby="parentsShare" aria-hidden="true">
    <div class="modal-dialog modal-lg border-0">
        <div class="modal-content">
            <div class="modal-body">
                <form class="row g-3 p-5" method="post" action="./insert.php" enctype="multipart/form-data">
                    <h4 class="text-center">Parents Opportunity Details</h4>
                    <!-- <input type="hidden" name="parentshare"/> -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="parentname" class="form-label">Parent Name</label>
                            <input type="text" class="form-control shadow" id="parentname" name="parentname">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Contact Number</label>
                            <input type="phone" class="form-control shadow" id="phone" name="phone">
                        </div>
                        <div class="col-md-12">
                            <label for="inputState" class="form-label">Opportunity Category</label>
                            <select id="inputState" class="form-select shadow" name="category">
                                <option selected>Select Category</option>
                                <option>Quizzes</option>
                                <option>Workshop</option>
                                <option>Hackathon</option>
                                <option>Competitions</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="url" class="form-label">URL Upload</label>
                            <input type="text" class="form-control shadow" id="url" name="url">
                        </div>
                        <div class="col-md-6">
                            <label for="pdfattach" class="form-label">PDF Upload</label>
                            <input type="file" class="form-control shadow" accept="application/pdf" id="ppdfattach" name="pdfattach">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button type="button" class="col-md-2 btn btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#competitionupload" data-bs-dismiss="modal">BACK</button>
                        <input type="submit" name="parentshare" class="col-md-2 p-2 btn btn-primary rounded border-0" value="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Organization Form Filling Modal -->
<div class="modal fade" id="organizeShare" tabindex="-1" aria-labelledby="organizeShare" aria-hidden="true">
    <div class="modal-dialog modal-lg border-0">
        <div class="modal-content">
            <div class="modal-body">
                <form class="row g-3 p-5" method="post" action="./insert.php" enctype="multipart/form-data">
                    <h4 class="text-center">Organization Opportunity Details</h4>
                    <input type="hidden" name="orgshare"/>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="orgname" class="form-label">Organization Name</label>
                            <input type="text" class="form-control shadow" id="orgname" name="orgname">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Contact Number</label>
                            <input type="phone" class="form-control shadow" id="phone" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Opportunity Category</label>
                            <select id="category" class="form-select shadow" name="category">
                                <option selected>Select Category</option>
                                <option>Quizzes</option>
                                <option>Workshop</option>
                                <option>Hackathon</option>
                                <option>Competitions</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="banner" class="form-label">Banner of the Event</label>
                            <input type="file" class="form-control shadow" accept="image/*" id="banner" name="banner" required>
                        </div>
                        <div class="col-md-6">
                            <label for="url" class="form-label">URL Upload</label>
                            <input type="text" class="form-control shadow" id="url" name="url">
                        </div>
                        <div class="col-md-6">
                            <label for="pdfattach" class="form-label">PDF Upload</label>
                            <input type="file" class="form-control shadow" accept="application/pdf" id="opdfattach" name="pdfattach">
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control shadow" id="description" name="description"></textarea>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button type="button" class="col-md-2 btn btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#competitionupload" data-bs-dismiss="modal">BACK</button>
                        <button type="submit" class="col-md-2 p-2 btn btn-primary rounded border-0" data-bs-dismiss="modal">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>