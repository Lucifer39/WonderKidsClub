<style>
    .container-competition-admin{
        height: 80vh;
        width: 100%;
        overflow: scroll;
    }

    .action-buttons-competition{
        background-color: transparent;
        border: none;
        font-size: 1.15rem;
    }
</style>
<script>
    function handleDeleteCompetition(comp_id) {
        $.ajax({
            type: "post",
            url: "functions/competition_functions?function_name=deleteCompetition",
            data: {
                competition: "displaydetails",
                comp_id
            },
            success: function(res) {
                // console.log(JSON.parse(res));
                window.location.reload();
            }
        })
    }

    function populateModalCompetition(comp_id, org_name, contact, category, description, url) {
        document.getElementById("orgnameAdmin").value = org_name;
        document.getElementById("phoneAdmin").value = contact;
        document.getElementById("categoryAdmin").value = category;
        document.getElementById("urlAdmin").value = url;
        document.getElementById("descriptionAdmin").value = description;
        document.getElementById("comp_id").value = comp_id;
    }

    function editCompetitionAdmin() {
        $.ajax({
            type: "post",
            url: "functions/competition_functions.php?function_name=editCompetitionAdmin",
            data: {
                orgname: document.getElementById("orgnameAdmin").value,
                contact: document.getElementById("phoneAdmin").value,
                category: document.getElementById("categoryAdmin").value,
                url: document.getElementById("urlAdmin").value,
                desc: document.getElementById("descriptionAdmin").value,
                comp_id: document.getElementById("comp_id").value
            },
            success: function(res) {
                window.location.reload();
            }
        })
    }
</script>

<div class="modal fade" id="organizeShareAdmin" tabindex="-1" aria-labelledby="organizeShare" aria-hidden="true">
    <div class="modal-dialog modal-lg border-0">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row g-3 p-5">
                    <h4 class="text-center">Organization Opportunity Details</h4>
                    <input type="hidden" id="comp_id"/>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="orgname" class="form-label">Organization Name</label>
                            <input type="text" class="form-control shadow" id="orgnameAdmin" name="orgname">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Contact Number</label>
                            <input type="phone" class="form-control shadow" id="phoneAdmin" name="phone">
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label">Opportunity Category</label>
                            <select id="categoryAdmin" class="form-select shadow" name="category">
                                <!-- <option selected>Select Category</option> -->
                                <option value="Quizzes">Quizzes</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Hackathon">Hackathon</option>
                                <option value="Competitions">Competitions</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="url" class="form-label">URL Upload</label>
                            <input type="text" class="form-control shadow" id="urlAdmin" name="url">
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control shadow" id="descriptionAdmin" name="description"></textarea>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button type="button" class="col-md-2 btn btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#competitionuploadAdmin" data-bs-dismiss="modal">BACK</button>
                        <button class="col-md-2 p-2 btn btn-primary rounded border-0" onclick="editCompetitionAdmin()">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="">
<div class="row">
    <h4 class="mt-2"><b>Details of Oppportunity shared by Admin</b></h4>
    <div class="col-12 col-lg-12 col-xxxl-10 d-flex">
        <div class="card flex-fill container-competition-admin">
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Organization Name</th>
                        <th>Contact No.</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Banner</th>
                        <th>URL</th>
                        <th>File Upload</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($adDesc as $admDesc) {
                    ?>
                    <tr>
                        <td><?php echo $admDesc['organized_by'] ?></td>
                        <td><?php echo $admDesc['contact_no'] ?></td>
                        <td><?php echo $admDesc['opportunity'] ?></td>
                        <td><?php echo $admDesc['event_name'] ?></td>
                        <td><img src="../competitions/images/banner/<?php echo $admDesc['banner'] ?>" width="50%"></td>
                        <td><a href="<?php echo $admDesc['url'] ?>" target="_blank"><?php echo $admDesc['url'] ?></a></td>
                        <td>
                        <?php if($admDesc["pdf"] !== '') {?>
                        <button class="btn btn-outline-secondary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#showpdf" 
                            data-bs-file="<?php echo $admDesc['pdf'] ?>">
                                VIEW PDF
                            </button>
                            <?php } ?></td>
                        <td>
                            <button onclick="handleDeleteCompetition(<?php echo ($admDesc['id']); ?>)" class="action-buttons-competition"><i class="bi bi-trash"></i></button>
                            <button type="button" 
                                data-bs-toggle="modal" 
                                data-bs-target="#organizeShareAdmin" 
                                data-bs-dismiss="modal" 
                                onclick="populateModalCompetition(<?php echo $admDesc['id'] . ' , `' 
                                                                        . $admDesc['organized_by'] . '` , `'
                                                                        . $admDesc['contact_no'] . '` , `'
                                                                        . $admDesc['opportunity'] . '` , `'
                                                                        . $admDesc['event_name'] . '` , `'
                                                                        . $admDesc['url'] . '`'; ?>)"
                                class="action-buttons-competition">
                                    <i class="bi bi-pencil-square"></i>
                            </button>
                        </td>
                    </tr>
                    <?php 
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

