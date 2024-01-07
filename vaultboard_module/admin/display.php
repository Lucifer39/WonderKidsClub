<?php
include_once('./nav.php');

include '../connection/conn.php';

$conn = makeConnection();

$parent = "SELECT * FROM `parentsshare`";
$resultparent = mysqli_query($conn,$parent);

$organization = "SELECT * FROM `organizationshare`";
$resultorg = mysqli_query($conn,$organization);

?>

<h4 class="text-center mt-2">Details of Oppportunity shared by Parents</h4>
<div class="container p-4">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Category</th>
                <th>URL</th>
                <th>Upload Date</th>
                <th>File Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($resultparent)){ ?>
            <tr>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['contact_no'] ?></td>
                <td><?php echo $row['category'] ?></td>
                <td><a href="<?php echo $row['url'] ?>" target="_blank"><?php echo $row['url'] ?></a></td>
                <td><?php echo $row['upload_date'] ?></td>
                <td><button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showpdf" data-bs-file="<?php echo $row['file_upload'] ?>">VIEW PDF</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<h4 class="text-center mt-4">Details of Oppportunity shared by Organization</h4>
<div class="container p-4">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Organization Name</th>
                <th>Contact Number</th>
                <th>Category</th>
                <th>Description</th>
                <th>Banner</th>
                <th>URL</th>
                <th>Upload Date</th>
                <th>File Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($resultorg)){ ?>
            <tr>
                <td><?php echo $row['org_name'] ?></td>
                <td><?php echo $row['contact'] ?></td>
                <td><?php echo $row['category'] ?></td>
                <td><?php echo $row['description'] ?></td>
                <td><img src="images/banner/<?php echo $row['banner'] ?>" width="50%"></td>
                <td><a href="<?php echo $row['url'] ?>" target="_blank"><?php echo $row['url'] ?></a></td>
                <td><?php echo $row['upload_date'] ?></td>
                <td><button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#showpdf" data-bs-file="<?php echo $row['file_upload'] ?>">VIEW PDF</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
		$('#showpdf').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget);
			var file = button.data('bs-file');
        
            // Set the source of the iframe
            var iframe = $(this).find('iframe');
            iframe.attr('src', 'images/pdfupload/' + file);
		});
    });
</script>
<!-- appoint person  -->
<div class="modal fade" id="showpdf" tabindex="-1" aria-labelledby="showpdf" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body">
          <h5 class="modal-title" id="exampleModalLabel">VIEW</h5>
            <iframe src="" width="100%" height="600px"></iframe>
        </div>
    </div>
  </div>
</div>