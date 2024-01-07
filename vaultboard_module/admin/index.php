<?php
include_once('../global/navigation.php');
include(ROOT_FOLDER."global/head.php");
require_once(ROOT_FOLDER."connection/dependencies.php");

$desc = getCurrentAdmin();

if(!$desc) {
	if(isset($_GET["data"]) && isset($_GET["iv"])) {
		$encodedEncryptedNumber = $_GET["data"];
		$data = base64_decode(urldecode($encodedEncryptedNumber));
		$iv = urldecode($_GET["iv"]);
		$encryptedNumber = $data;
		$decryptedNumber = openssl_decrypt($encryptedNumber, 'aes-256-cbc', SECRET_KEY, 0, $iv);
		if ($decryptedNumber !== false) {
			setID($decryptedNumber);
			setRootID($decryptedNumber);
			setGuest("");

			$desc = getCurrentAdmin();
		} else {
			header("Location: ". ROOT_FOLDER);
			exit;
		}
	}
}

$parentsdesc = getCompetitionParents();
$orgsdesc = getCompetitionOrg();
$adDesc = getCompetitionAdmin();

?>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

	<style>
		.container-competition {
			height: 200px;
			overflow-y: scroll;
			width: 100%;
		}
	</style>
	<script>
		function populateParentsModal(comp_id, org_name, contact, category, url) {
			document.getElementById("orgnameParent").value = org_name;
			document.getElementById("phoneParent").value = contact;
			document.getElementById("categoryParent").value = category;
			document.getElementById("urlParent").value = url;
			document.getElementById("comp_id_parent").value = comp_id;
		}

		function populateOrganizationModal(comp_id, org_name, contact, category, url, desc) {
			document.getElementById("orgnameOrg").value = org_name;
			document.getElementById("phoneOrg").value = contact;
			document.getElementById("categoryOrg").value = category;
			document.getElementById("urlOrg").value = url;
			document.getElementById("descOrg").value = desc;
			document.getElementById("comp_id_org").value = comp_id;
		}
		
		function handleDeleteCompetitionOthers(comp_id ,competition) {
			$.ajax({
				type: "post",
				url: "functions/competition_functions?function_name=deleteCompetition",
				data: {
					competition,
					comp_id
				},
				success: function(res) {
					// console.log(JSON.parse(res));
					window.location.reload();
				}
			})
		}

		function editCompetitionParents() {
			$.ajax({
				type: "post",
				url: "functions/competition_functions.php?function_name=editCompetitionParents",
				data: {
					orgname: document.getElementById("orgnameParent").value,
					contact: document.getElementById("phoneParent").value,
					category: document.getElementById("categoryParent").value,
					url: document.getElementById("urlParent").value,
					comp_id: document.getElementById("comp_id_parent").value
				},
				success: function(res) {
					window.location.reload();
				}
			})
		}

		function editCompetitionOrg() {
			$.ajax({
				type: "post",
				url: "functions/competition_functions.php?function_name=editCompetitionOrg",
				data: {
					orgname: document.getElementById("orgnameOrg").value,
					contact: document.getElementById("phoneOrg").value,
					category: document.getElementById("categoryOrg").value,
					url: document.getElementById("urlOrg").value,
					desc: document.getElementById("descOrg").value,
					comp_id: document.getElementById("comp_id_org").value
				},
				success: function(res) {
					window.location.reload();
				}
			})
		}
	</script>
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
					<span class="align-middle">Wonderkids</span>
				</a>
				<ul class="sidebar-nav">
					<li class="sidebar-item active" id="competitionsdisplay">
						<a class="sidebar-link" href="./">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Competitions</span>
						</a>
					</li>
					<li class="sidebar-item" id="competitionsdisplayadmin">
						<a class="sidebar-link" href="#">
							<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Admin Competitions</span>
						</a>
					</li>
					<li class="sidebar-item" id="editadmin">
						<a class="sidebar-link" href="#">
							<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Edit Competitions</span>
						</a>
					</li>

					<?php
						if($desc["isAdmin"] == "1") {
					?>
					<li class="sidebar-item" id="vocab-admin">
						<a class="sidebar-link" href="#">
							<i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Vocabulary Form Questions</span>
						</a>
					</li>
					<li class="sidebar-item" id="vocab-admin-insert-questions">
						<a class="sidebar-link" href="#">
							<i class="align-middle"data-feather="book"></i> <span class="align-middle">Vocabulary Insert Questions</span>
						</a>
					</li>

					<li class="sidebar-item" id="vocab-context-settings">
						<a class="sidebar-link" href="#">
							<i class="align-middle"data-feather="tool"></i> <span class="align-middle">Vocabulary Context Settings</span>
						</a>
					</li>

					<li class="sidebar-item" id="vocab-question-csv">
						<a class="sidebar-link" href="#">
							<i class="align-middle"data-feather="tool"></i> <span class="align-middle">Vocabulary CSV Question Upload</span>
						</a>
					</li>
					<li class="sidebar-item" id="spellathon-quiz">
						<a class="sidebar-link" href="#">
							<i class="align-middle"data-feather="tool"></i> <span class="align-middle">Spellathon Quiz Settings</span>
						</a>
					</li>
					<li class="sidebar-item" id="toggle-sections">
						<a class="sidebar-link" href="#">
							<i class="align-middle"data-feather="tool"></i> <span class="align-middle">Toggle Sections</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="<?php echo ROOT_DOMAIN_URL . "controlgear/dashboard.php" ?>">
							<i class="align-middle"data-feather="share"></i> <span class="align-middle">Wonderkids Admin</span>
						</a>
					</li>

					<?php 
						}
					?>
					<li class="sidebar-item">
						<a class="sidebar-link" href="<?php echo GLOBAL_URL ?>connection/logout.php">
							<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
								</div>
							</div>
						</li>
						<li class="nav-item">
							<a class="nav-link d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="Charles Hall" /> <span class="text-dark"><?php echo $desc['fullname'] ?></span>
							</a>
						</li>
					</ul>
				</div>
			</nav>

			<div class="modal fade" id="organizeShareParents" tabindex="-1" aria-labelledby="organizeShare" aria-hidden="true">
				<div class="modal-dialog modal-lg border-0">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row g-3 p-5">
								<h4 class="text-center">Organization Opportunity Details</h4>
								<input type="hidden" id="comp_id_parent"/>
								<div class="row g-3">
									<div class="col-md-6">
										<label for="orgname" class="form-label">Name</label>
										<input type="text" class="form-control shadow" id="orgnameParent" name="orgname">
									</div>
									<div class="col-md-6">
										<label for="phone" class="form-label">Contact Number</label>
										<input type="phone" class="form-control shadow" id="phoneParent" name="phone">
									</div>
									<div class="col-md-6">
										<label for="category" class="form-label">Opportunity Category</label>
										<select id="categoryParent" class="form-select shadow" name="category">
											<!-- <option selected>Select Category</option> -->
											<option value="Quizzes">Quizzes</option>
											<option value="Workshop">Workshop</option>
											<option value="Hackathon">Hackathon</option>
											<option value="Competitions">Competitions</option>
										</select>
									</div>
									<div class="col-md-6">
										<label for="url" class="form-label">URL Upload</label>
										<input type="text" class="form-control shadow" id="urlParent" name="url">
									</div>
								</div>
								<div class="mt-5 text-center">
									<button type="button" class="col-md-2 btn btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#competitionuploadAdmin" data-bs-dismiss="modal">BACK</button>
									<button class="col-md-2 p-2 btn btn-primary rounded border-0" onclick="editCompetitionParents()">SUBMIT</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal fade" id="organizeShareOrganization" tabindex="-1" aria-labelledby="organizeShare" aria-hidden="true">
				<div class="modal-dialog modal-lg border-0">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row g-3 p-5">
								<h4 class="text-center">Organization Opportunity Details</h4>
								<input type="hidden" id="comp_id_org"/>
								<div class="row g-3">
									<div class="col-md-6">
										<label for="orgname" class="form-label">Name</label>
										<input type="text" class="form-control shadow" id="orgnameOrg" name="orgname">
									</div>
									<div class="col-md-6">
										<label for="phone" class="form-label">Contact Number</label>
										<input type="phone" class="form-control shadow" id="phoneOrg" name="phone">
									</div>
									<div class="col-md-6">
										<label for="category" class="form-label">Opportunity Category</label>
										<select id="categoryOrg" class="form-select shadow" name="category">
											<!-- <option selected>Select Category</option> -->
											<option value="Quizzes">Quizzes</option>
											<option value="Workshop">Workshop</option>
											<option value="Hackathon">Hackathon</option>
											<option value="Competitions">Competitions</option>
										</select>
									</div>
									<div class="col-md-6">
										<label for="url" class="form-label">URL Upload</label>
										<input type="text" class="form-control shadow" id="urlOrg" name="url">
									</div>
									<div class="col-md-6">
										<label for="desc" class="form-label">Description</label>
										<input type="text" class="form-control shadow" id="descOrg" name="desc">
									</div>
								</div>
								<div class="mt-5 text-center">
									<button type="button" class="col-md-2 btn btn-outline-primary rounded" data-bs-toggle="modal" data-bs-target="#competitionuploadAdmin" data-bs-dismiss="modal">BACK</button>
									<button class="col-md-2 p-2 btn btn-primary rounded border-0" onclick="editCompetitionOrg()">SUBMIT</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<main class="content" style="overflow-y: scroll">
				<div class="container-fluid p-0" id="competitionupload">
					<div class="row">
                        <h4 class="mt-2"><b>Details of Oppportunity shared by Parents</b></h4>
						<div class="col-12 col-lg-12 col-xxxl-10 d-flex">
							<div class="card flex-fill container-competition">
								<table class="table table-hover my-0">
									<thead>
										<tr>
                                            <th>Name</th>
                                            <th>Contact No.</th>
                                            <th>Category</th>
                                            <th>URL</th>
                                            <th class="d-xl-table-cell">Upload Date</th>
                                            <th class="d-none d-xl-table-cell">File Upload</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($parentsdesc as $parentdesc) { ?>
                                        <tr>
                                            <td><?php echo $parentdesc['name'] ?></td>
                                            <td><?php echo $parentdesc['contact_no'] ?></td>
                                            <td><?php echo $parentdesc['category'] ?></td>
                                            <td><a href="<?php echo $parentdesc['url'] ?>" target="_blank"><?php echo $parentdesc['url'] ?></a></td>
                                            <td><?php echo $parentdesc['upload_date'] ?></td>
                                            <td><button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showpdf" data-bs-file="<?php echo $parentdesc['file_upload'] ?>">VIEW PDF</button></td>
											<td>
												<button onclick="handleDeleteCompetitionOthers(<?php echo ($parentdesc['id']); ?>, 'parentsshare')" class="action-buttons-competition"><i class="bi bi-trash"></i></button>
												<button type="button" 
													data-bs-toggle="modal" 
													data-bs-target="#organizeShareParents" 
													data-bs-dismiss="modal" 
													onclick="populateParentsModal(<?php echo $parentdesc['id'] . ' , `' 
																							. $parentdesc['name'] . '` , `'
																							. $parentdesc['contact_no'] . '` , `'
																							. $parentdesc['category'] . '` , `'
																							. $parentdesc['url'] . '`'; ?>)"
													class="action-buttons-competition">
														<i class="bi bi-pencil-square"></i>
												</button>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                    <div class="row">
                        <h4 class="mt-2"><b>Details of Oppportunity shared by Organization</b></h4>
						<div class="col-12 col-lg-12 col-xxxl-10 d-flex">
							<div class="card flex-fill container-competition">
								<table class="table table-hover my-0">
									<thead>
										<tr>
                                            <th>Organization Name</th>
                                            <th>Contact No.</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Banner</th>
                                            <th>URL</th>
                                            <th>Upload Date</th>
                                            <th>File Upload</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($orgsdesc as $orgdesc) { ?>
                                        <tr>
                                            <td><?php echo $orgdesc['org_name'] ?></td>
                                            <td><?php echo $orgdesc['contact'] ?></td>
                                            <td><?php echo $orgdesc['category'] ?></td>
                                            <td><?php echo $orgdesc['description'] ?></td>
                                            <td><img src="images/banner/<?php echo $orgdesc['banner'] ?>" width="50%"></td>
                                            <td><a href="<?php echo $orgdesc['url'] ?>" target="_blank"><?php echo $orgdesc['url'] ?></a></td>
                                            <td><?php echo $orgdesc['upload_date'] ?></td>
                                            <td><button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showpdf" data-bs-file="<?php echo $orgdesc['file_upload'] ?>">VIEW PDF</button></td>
											<td>
												<button onclick="handleDeleteCompetitionOthers(<?php echo ($orgdesc['id']); ?>, 'organizationshare')" class="action-buttons-competition"><i class="bi bi-trash"></i></button>
												<button type="button" 
													data-bs-toggle="modal" 
													data-bs-target="#organizeShareOrganization" 
													data-bs-dismiss="modal" 
													onclick="populateOrganizationModal(<?php echo $orgdesc['id'] . ' , `' 
																							. $orgdesc['org_name'] . '` , `'
																							. $orgdesc['contact'] . '` , `'
																							. $orgdesc['category'] . '` , `'
																							. $orgdesc['description'] . '` , `'
																							. $orgdesc['url'] . '`'; ?>)"
													class="action-buttons-competition">
														<i class="bi bi-pencil-square"></i>
												</button>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
				</div>
                <div class="container-fluid p-0" id="admineditcompetittion" style="display:none">
                    <?php require_once('editdetails.php') ?>
                </div>
				<div class="container-fluid p-0" id="vocabulary-form-questions" style="display:none">
                    <?php require_once('../vocabulary_module/vocab_admin_page.php') ?>
                </div>
				<div class="container-fluid p-0" id="vocabulary-insert-questions" style="display:none">
					<?php require_once('vocabInsertQuestions.php'); ?>
				</div>
				<div class="container-fluid p-0" id="vocabulary-context-container" style="display:none">
					<?php require_once('vocabContextSettings.php'); ?>
				</div>
				<div class="container-fluid p-0" id="vocabulary-question-csv-container" style="display:none">
					<?php require_once('vocabInsertCSV.php'); ?>
				</div>
				<div class="container-fluid p-0" id="spellathon-quiz-container" style="display:none">
					<?php require_once('spellathon_quiz.php'); ?>
				</div>
				<div class="container-fluid p-0" id="competition-admin-container" style="display:none">
					<?php require_once('competitionAdmin.php'); ?>
				</div>
				<div class="container-fluid p-0" id="toggle-sections-container" style="display:none">
					<?php require_once('sectionEnable.php'); ?>
				</div>
			</main>
		</div>
	</div>

	<script src="js/app.js"></script>
    <script>
        $( ".sidebar-nav .sidebar-item" ).bind( "click", function(event) {
            var clickedItem = $( this );
            $(".sidebar-nav .sidebar-item").each( function() {
                    $( this ).removeClass( "active" );
            });
            clickedItem.addClass( "active" );
        });

        $('#competitionsdisplay').on('click',function(){
            $('#servicesDiv').hide();
            $('#admineditcompetittion').show();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
        });
        $('#editadmin').on('click',function(){
            $('#competitionupload').hide();
            $('#admineditcompetittion').show();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
        });
		$('#vocab-admin').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').show();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
		});
		$('#vocab-admin-insert-questions').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').show();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
		});
		$('#vocab-context-settings').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').show();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
		});
		$('#vocab-question-csv').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').show();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
		});
		$('#spellathon-quiz').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').show();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container.php').hide();
		});
		$('#competitionsdisplayadmin').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').show();
			$('#toggle-sections-container.php').hide();
		});
		$('#toggle-sections').on('click', () => {
			$('#competitionupload').hide();
            $('#admineditcompetittion').hide();
			$('#vocabulary-form-questions').hide();
			$('#vocabulary-insert-questions').hide();
			$('#vocabulary-context-container').hide();
			$('#vocabulary-question-csv-container').hide();
			$('#spellathon-quiz-container').hide();
			$('#competition-admin-container').hide();
			$('#toggle-sections-container').show();
		});

        $(document).ready(function() {
            $('#showpdf').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var file = button.data('bs-file');
            
                // Set the source of the iframe
                var iframe = $(this).find('iframe');
                iframe.attr('src', '../competitions/images/pdfupload/' + file);
            });
        });
    </script>
    <!-- appoint person  -->
    <div class="modal fade" id="showpdf" tabindex="-1" aria-labelledby="showpdf" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>PDF</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="" width="100%" height="600px"></iframe>
                </div>
            </div>
        </div>
    </div>

</body>

</html>