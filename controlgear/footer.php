<?php $link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

if($page == 'footer.php' || $page == 'footer') {
include( "../config/config.php" );
header('Location:'.$baseurl.'controlgear/dashboard');	
}
if(($_SESSION['id'])) { ?>
</div>
    </div>
    <footer class="footer-fixed">
      <div class="container-fluid">
        <div class="footer"> &copy; 2022, EdTech | All rights reserved. </div>
      </div>
    </footer>
<?php } else { ?>
<footer class="pt-4 pb-4">
  <div class="container-fluid text-center">
    <div class="col-lg-12 col-md-12 col-sm-12 footer"> &copy; 2022, EdTech | All rights reserved. </div>
  </div>
</footer>
<?php } ?>
<?php if (in_array($page, ['schoolManagement.php', 'subjectList.php', 'classList.php', 'blogCategories.php', 'topicList.php', 'questionList.php'])) { 

if (in_array($page, ['questionList.php'])) { 
  $headName = 'remarks';
} else {
  $headName = 'name';
} 
  
?>
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit/Update <?php echo $headName; ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <form id="form" action="" method="post" enctype="multipart/form-data" class="submit-form">
                <input type="hidden" name="bookId" id="bookId" value=""/>
                <div class="row">
                  <div class="col-md-12 form-group">
                    <label class="label">Edit <?php echo $headName; ?> <span class="required">*</span></label>
                    <?php if($page =='questionList.php') { ?>
                    <textarea rows="5" name="catname" id="catname" class="form-control"></textarea> 
                    <?php } else { ?>
                      <input type="text" name="catname" id="catname" value="" class="form-control"> 
                    <?php } ?>
                  </div>
                  <?php if($page =='schoolManagement.php') { ?>
                    <div class="col-md-12 form-group">
                    <label class="label">Short Name <span class="required">*</span></label>
                    <input type="text" name="stname" id="stname" value="" class="form-control"> 
                  </div>
                  <?php } ?>
                  <div class="col-md-12 form-group text-left">
                    <button type="submit" id='update' name='update' class="btn btn-primary custom-btn">Update</button>
                  </div>
                </div>
              </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<?php if($page == "userQueries.php"){ 
  if(isset($_POST["reply"])) {
    $reply = $_POST["reply-text"];
    $query_id = $_POST["query-id"];

    $reply_sql = mysqli_query($conn, "UPDATE user_queries SET reply = '$reply' , updated_at = NOW() WHERE id = $query_id");
    $replyrow = mysqli_fetch_array($reply_sql);
  }
  ?>
  <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">  
    <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          Reply From Admin
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5 class="title">Reply for User <span class="user-id-reply"></span></h5>
        <form action="" method="post" class="p-2">
          <input type="hidden" id="query-id" name="query-id">
          <div class="input-group mb-2">
            <textarea name="reply-text" id="" cols="30" rows="10" placeholder="Type your reply here..." class="w-100"></textarea>
          </div>
          <div class="input-group mb-2">
            <input type="submit" name="reply" class="btn btn-primary custom-btn" value="Submit">
          </div>
         </form>
      </div>
    </div>
  </div>
</div>
<?php } ?>
</body>
<script src="<?php echo $baseurl; ?>assets/js/popper.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/bootstrap-4.4.1/js/bootstrap.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/bootstrap-select/js/bootstrap-select.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/perfectscrollbar/perfect-scrollbar.jquery.js"></script>
<script src="<?php echo $baseurl; ?>assets/datatables/datatables.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/admin-custom.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery-ui.min.js"></script>
<script src="<?php echo $baseurl; ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script>

	
	
$(document).on('change','.custom-file-input',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            });		
	
$(document).ready(function () {
    $('#Passform').validate({
      rules: {
		oldPassword: {
          required: true
          //minlength: 8
        },
        userPassword: {
          required: true,
          minlength: 8
        },
        userCnfPassword: {
          required: true,
          equalTo: "#userPassword"
        },		  
  },
	messages: {
		oldPassword: {
          required: 'Please enter Old Password.'
          //minlength: 'Password must be at least 8 characters long',
        },
        userPassword: {
          required: 'Please enter New Password.',
          minlength: 'Password must be at least 8 characters long',
        },
        userCnfPassword: {
          required: 'Please enter Confirm New Password',
          equalTo: 'Password Do not Match',
        },
      },
		errorPlacement: function (error, element) {
            element.parents(".form-group").find(".error").append(error);
},
      submitHandler: function (form) {
        form.submit();
      }
    });
  });	
	
<?php if($page == 'blogPost.php' || $page == 'editblogPost.php') { ?>
  $(document).ready(function(){$("#blogPost").dataTable({bProcessing:!0,sAjaxSource:"../ajax/blogPostAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})}),$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_blogPost:a},success:function(a){location.reload()}})}),$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogPost_active:a},success:function(a){location.reload()}})}),$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogPost_inactive:a},success:function(a){location.reload()}})});

<?php } elseif($page == 'propertyDetails.php' || $page == 'editpropertyDetails.php') { ?>
$(document).ready(function(){$("#pptDetails").dataTable({bProcessing:!0,sAjaxSource:"../ajax/pptDetailsAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})}),$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_pptDetails:a},success:function(a){location.reload()}})}),$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{pptDetails_active:a},success:function(a){location.reload()}})}),$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{pptDetails_inactive:a},success:function(a){location.reload()}})});
$(document).on("click",".deleteMaster",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{del_Master:o},success:function(o){location.reload()}})});	
	
$(document).ready(function(){

        // Initialize sortable
        $( "#sortable" ).sortable();
		});  
		// Save order
	    $(document).on("click","#submit",function(){
            var imageids_arr = [];
            // get image ids order
            $('#sortable li').each(function(){
                var id = $(this).data('id');
                
                imageids_arr.push(id);
            });

            // AJAX request
            $.ajax({
                url: 'deleteAjax',
                type: 'post',
                data: {imageids: imageids_arr},
    success:function(data)
    {
     //location.reload();
    }
            });
        }); 
		  
		  
	  
	$(document).on('click', '.front_remove_img', function(){
	var file_id = $(this).data("id");
	var image_id = $(this).data("image");	
  if(confirm("Are you sure you want to remove it?"))
  {
   $.ajax({
    url:"deleteAjax",
    method:"POST",
    data:{'prodid':file_id, 'remove_prodimg':image_id},
    success:function(data)
    {
     location.reload();
    }
   });
  }
 });	
	
$(document).on('click', '#addkeyhighlights', function(){
    $('#addkeyhighlightsdiv').append('<div class="form-group"><div class="form-row"><div class="col col-10"><input type="text" name="keylights[]" id="keylights" class="form-control"></div><div class="col col-2"><a href="javascript:void(0);" class="delete-btn btn btn-primary custom-btn form-control mt-0"><i class="fa fa-minus"></i></a></div></div></div>');
});	
	
$(document).on('click', '#addnearloc', function(){
    $('#addnearlocdiv').append('<div class="form-group"><div class="form-row"><div class="col col-10"><input type="text" name="nearloc[]" id="nearloc" class="form-control"></div><div class="col col-2"><a href="javascript:void(0);" class="delete-btn btn btn-primary custom-btn form-control mt-0"><i class="fa fa-minus"></i></a></div></div></div>');
});	
	
$(document).on('click', '#addfp', function(){
    $('#addfpdiv').append('<div class="form-group form-row"><div class="col col-5"><input type="text" name="fpheading[]" id="fpheading" class="form-control"></div><div class="col col-5"><div class="custom-file"><input type="file" class="custom-file-input" id="fpimage" name="fpimage[]"><label class="custom-file-label form-control" for="fpimage">Upload Image file only</label></div></div><div class="col col-2"><a href="javascript:void(0);" class="delete-btn btn btn-primary custom-btn form-control mt-0"><i class="fa fa-minus"></i></a></div></div>');
});		
$(document).on('click', '.delete-btn', function(){$(this).parents('.form-group').remove();});	
	
$(document).on('click', '.delete-highlights', function(){var prod_id = $(this).data("id");if(confirm("Are you sure you want to remove it?")){$.ajax({url:"deleteAjax",method:"POST",data:{'delete_highlights':prod_id},success:function(data){location.reload();}});}});
	
$(document).on('click', '.delete-nearby', function(){var prod_id = $(this).data("id");if(confirm("Are you sure you want to remove it?")){$.ajax({url:"deleteAjax",method:"POST",data:{'delete_nearby':prod_id},success:function(data){location.reload();}});}});
													 
$(document).on('click', '.delete-fp', function(){var prod_id = $(this).data("id");if(confirm("Are you sure you want to remove it?")){$.ajax({url:"deleteAjax",method:"POST",data:{'delete_fp':prod_id},success:function(data){location.reload();}});}});
	
	
<?php } elseif($page == 'blogCategories.php') { ?>
$(document).ready(function(){$("#blogCategories").dataTable({bProcessing:!0,sAjaxSource:"../ajax/blogCategoriesAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})}),$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_blogCat:a},success:function(a){location.reload()}})}),$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogCat_active:a},success:function(a){location.reload()}})}),$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogCat_inactive:a},success:function(a){location.reload()}})});	
<?php } ?>

<?php if($page == 'propertyAmenities.php') { ?>
$(document).ready(function(){$("#propertyAmenities").dataTable({bProcessing:!0,sAjaxSource:"../ajax/propertyAmenitiesAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})}),$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_propertyAmenities:a},success:function(a){location.reload()}})}),$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{propertyAmenities_active:a},success:function(a){location.reload()}})}),$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{propertyAmenities_inactive:a},success:function(a){location.reload()}})});
<?php } elseif($page == 'propertyType.php' || $page == 'editpropertyType.php') { ?>
  $(document).ready(function(){$("#datatableList").dataTable({bProcessing:!0,sAjaxSource:"../ajax/propertyTypeAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})})
<?php } elseif($page == 'propertyCategories.php' || $page == 'editpropertyCategories.php') { ?>
  $(document).ready(function(){$("#datatableList").dataTable({bProcessing:!0,sAjaxSource:"../ajax/pptCategoriesAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})})
<?php } elseif($page == 'propertyLocation.php' || $page == 'editpropertyLocation.php') { ?>
  $(document).ready(function(){$("#datatableList").dataTable({bProcessing:!0,sAjaxSource:"../ajax/pptLocAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})})
<?php } elseif($page == 'propertyDeveloper.php' || $page == 'editpropertyDeveloper.php') { ?>
  $(document).ready(function(){$("#datatableList").dataTable({bProcessing:!0,sAjaxSource:"../ajax/pptDevAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})})
<?php } ?>  
<?php if($page == 'propertyType.php' || $page == 'editpropertyType.php' || $page == 'propertyCategories.php' || $page == 'editpropertyCategories.php' || $page == 'propertyLocation.php' || $page == 'editpropertyLocation.php' || $page == 'propertyDeveloper.php' || $page == 'editpropertyDeveloper.php') { ?>
  $(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_pptType:a},success:function(a){location.reload()}})}),
  $(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{pptType_active:a},success:function(a){location.reload()}})}),
  $(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{pptType_inactive:a},success:function(a){location.reload()}})}),
  $(document).on("click",".deleteImg",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_pptTypeImg:o},success:function(o){location.reload()}})})
  $(document).on("click",".deleteLogo",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_pptTypeLogo:o},success:function(o){location.reload()}})})
<?php } ?>
<?php if($page == 'servicesType.php' || $page == 'editservicesType.php') { ?>
  $(document).ready(function(){$("#datatableList").dataTable({bProcessing:!0,sAjaxSource:"../ajax/servicesTypeAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})}),$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_blogCat:a},success:function(a){location.reload()}})}),$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogCat_active:a},success:function(a){location.reload()}})}),$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogCat_inactive:a},success:function(a){location.reload()}})});	

  $(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_serType:a},success:function(a){location.reload()}})}),
  $(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{serType_active:a},success:function(a){location.reload()}})}),
  $(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{serType_inactive:a},success:function(a){location.reload()}})}),
  $(document).on("click",".deleteImg",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_serTypeImg:o},success:function(o){location.reload()}})})
  $(document).on("click",".deleteLogo",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_serTypeLogo:o},success:function(o){location.reload()}})})
<?php } ?>

<?php 
$allowedPages = array(
  'copyright.php', 'tnc.php', 'disclaimer.php', 'privacy.php', 'about.php',
  'propertyType.php', 'editpropertyType.php', 'propertyLocation.php', 'editpropertyLocation.php',
  'propertyDeveloper.php', 'editpropertyDeveloper.php', 'blogPost.php', 'editblogPost.php',
  'propertyDetails.php', 'editpropertyDetails.php', 'propertyCategories.php', 'editpropertyCategories.php',
  'homepage.php', 'servicesType.php', 'editservicesType.php', 'homeFaqs.php', 'homeBanner.php'
);

if (in_array($page, $allowedPages)) {
?>
  tinymce.init({selector:'textarea#editor',width:"100%",height:"250",menubar:'false',plugins:"textcolor spellchecker link media code hr searchreplace table lists image code",toolbar:"styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | forecolor backcolor | link table hr | undo redo | image | code", image_title: true,
  automatic_uploads: true,
  file_picker_types: 'image',
  file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.onchange = function () {
      var file = this.files[0];
      var reader = new FileReader();
      reader.onload = function () {
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };

    input.click();
  },
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'});
<?php } ?>


<?php if($page == 'homepage.php') { ?>   
$(".proType").on('click', 'option', function() {
    if ($(".proType option:selected").length > 8) {
        $(this).removeAttr("selected");
        alert('You can select only 8 only');
    }
}); 
$(".proType2").on('click', 'option', function() {
    if ($(".proType2 option:selected").length > 8) {
        $(this).removeAttr("selected");
        alert('You can select only 2 only');
    }
}); 
$(".locType").on('click', 'option', function() {
    if ($(".locType option:selected").length > 5) {
        $(this).removeAttr("selected");
        alert('You can select only 5 only');
    }
}); 
$(document).ready(function(){$( ".sortable" ).sortable();});
$(document).on('click','#tabs1form',function(){var imageids_arr = [];
$('.tabs1form .re-tag').each(function(){var id = $(this).data('id'); imageids_arr.push(id);});
$.ajax({url:"deleteAjax",type:"post",data: {proType: imageids_arr},
success:function(data){}});return data; });
$(document).on('click','#tabs3form',function(){var imageids_arr = [];
$('.tabs3form .re-tag').each(function(){var id = $(this).data('id'); imageids_arr.push(id);});
$.ajax({url:"deleteAjax",type:"post",data: {proType2: imageids_arr},
success:function(data){}});return data; });
$(document).on('click','#tabs4form',function(){var imageids_arr = [];
$('.tabs4form .re-tag').each(function(){var id = $(this).data('id'); imageids_arr.push(id);});
$.ajax({url:"deleteAjax",type:"post",data: {proType3: imageids_arr},
success:function(data){}});return data; });

$(document).on("click",".deleteImg",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_homeImg:o},success:function(o){location.reload()}})});

<?php } elseif($page == 'about.php' || $page == 'privacy.php') { ?>
  $(document).on("click",".deleteImg",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_pageImg:o},success:function(o){location.reload()}})});  
  <?php } elseif($page == 'contact.php') { ?>
  $(document).on("click",".deleteImg",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_contactImg:o},success:function(o){location.reload()}})});  

  
<?php } ?>

<?php if($page == 'leads.php') { ?>
  $(document).ready(function(){$("#datatableList").dataTable({bProcessing:!0,sAjaxSource:"../ajax/LeadsAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})})
  $(document).on("click",".delete",function(){ var row = $(this).closest('tr'); var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_cntLeads:a},success:function(a){row.remove();}})})
<?php } ?>


//New Work
$(document).on('click', '.edit', function(){
  $('#bookId').val($(this).data('id'));
	$('#catname').val($(this).data('name'));
  $('#stname').val($(this).data('short'));
	$('#editmodal').modal('show');	    
});

setTimeout(function() {$(".msg,.msg1").hide();}, 3000);

$(document).on("click",".deleteImg",function(){var o=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_tyPost:o},success:function(o){location.reload()}})})
  

<?php if($page == 'topicList.php') { ?>
$(function(){
  $('.noSpacesField').bind('input', function(){
    $(this).val(function(_, v){
     return v.replace(/\s+/g, '');
    });
  });
});

var Password = {
 
 _pattern : /[a-zA-Z0-9_\-\+\.]/,
 
 
 _getRandomByte : function()
 {
   if(window.crypto && window.crypto.getRandomValues) 
   {
     var result = new Uint8Array(1);
     window.crypto.getRandomValues(result);
     return result[0];
   }
   else if(window.msCrypto && window.msCrypto.getRandomValues) 
   {
     var result = new Uint8Array(1);
     window.msCrypto.getRandomValues(result);
     return result[0];
   }
   else
   {
     return Math.floor(Math.random() * 256);
   }
 },
 
 generate : function(length)
 {
   return Array.apply(null, {'length': length})
     .map(function()
     {
       var result;
       while(true) 
       {
         result = String.fromCharCode(this._getRandomByte());
         if(this._pattern.test(result))
         {
           return result;
         }
       }        
     }, this)
     .join('');  
 }    
   
};

$(document).on('click','.eye-off', function () {
  $(this).children('img').attr('src', '../assets/images/eye.svg');
  $(this).addClass('eye-on');
  $("#tp_pass").attr('type','text'); 
});
$(document).on('click','.eye-on', function () {
  $(this).children('img').attr('src', '../assets/images/eye-off.svg');
  $(this).removeClass('eye-on');
  $("#tp_pass").attr('type','password'); 
});
<?php } ?>

<?php if($page == 'schoolManagement.php') { ?>
$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/schoolManagementAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#ids').on('change', function(){table.column(1).search(this.value).draw();});
$('#school').on('change', function(){table.column(2).search(this.value).draw();});
$('#status').on('change', function(){table.column(3).search(this.value).draw();});
});

$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_schoolList:a},success:function(a){location.reload()}})});
$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{schoolList_active:a},success:function(a){location.reload()}})});
$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{schoolList_inactive:a},success:function(a){location.reload()}})});

var checkedCheckboxes = [];
var selectedSchool = "";

$(document).on("change", "#destination-school", function(){
  selectedSchool = $(this).val();
  console.log(selectedSchool);
});

$(document).on("change", '.school-checkbox', function() {
    const dataId = $(this).data('id');

    if ($(this).is(':checked')) {
      // If the checkbox is checked, add the data-id to the array
      checkedCheckboxes.push(dataId);
    } else {
      // If the checkbox is unchecked, remove the data-id from the array
      const index = checkedCheckboxes.indexOf(dataId);
      if (index !== -1) {
        checkedCheckboxes.splice(index, 1);
      }
    }

  });

  $(document).on('click', '#merge-btn', function(){
    if(checkedCheckboxes.length == 0 || selectedSchool == "") {
      alert("Select schools");
      return;
    }

    $.ajax({
      type: "post",
      url: "../ajax/mergeSchoolAjax",
      data: {
        duplicates: checkedCheckboxes.filter(school => school !== selectedSchool),
        school: selectedSchool,
      },
      success: function(res){
        window.location.reload();
      }
    });
  });
<?php } elseif($page == 'homeBanner.php') { ?>
$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/homeBannerAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
});
$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_heroB:a},success:function(a){location.reload()}})});
$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{heroB_active:a},success:function(a){location.reload()}})});
$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{heroB_inactive:a},success:function(a){location.reload()}})});

<?php } elseif($page == 'topicList.php') { ?>
  $(document).ready(function(){
$("#datalisttpc").dataTable({bProcessing:!0,sAjaxSource:"../ajax/topicListAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalisttpc').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#clsName').on('change', function(){table.column(1).search(this.value).draw();});
$('#topicName').on('change', function(){table.column(2).search(this.value).draw();});
$('#tpcstatus').on('change', function(){table.column(3).search(this.value).draw();});
});

$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/subtopicListAjax.php",bPaginate:!0,order:[[1,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#clssName').on('change', function(){table.column(1).search(this.value).draw();});
$('#subtopicName').on('change', function(){table.column(2).search(this.value).draw();});
$('#createdby').on('change', function(){table.column(3).search(this.value).draw();});
});

$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "tpsubtps_active" : "tpsubtps_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});


<?php } elseif($page == 'subjectList.php') { ?>
$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/subjectListAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#topicName').on('change', function(){table.column(1).search(this.value).draw();});
$('#subtopicName').on('change', function(){table.column(2).search(this.value).draw();});
$('#createdby').on('change', function(){table.column(3).search(this.value).draw();});
});
$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "subject_active" : "subject_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});
<?php } elseif($page == 'classList.php') { ?>
$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/classListAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#topicName').on('change', function(){table.column(1).search(this.value).draw();});
$('#subtopicName').on('change', function(){table.column(2).search(this.value).draw();});
$('#createdby').on('change', function(){table.column(3).search(this.value).draw();});
});
$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "class_active" : "class_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});

<?php } elseif($page == 'registeredStudents.php') { ?>
$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/studentsAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#userSearch').on('change', function(){table.column(0).search(this.value).draw();});
$('#fullnameSearch').on('change', function(){table.column(1).search(this.value).draw();});
$('#emailSearch').on('change', function(){table.column(2).search(this.value).draw();});
$('#contactSearch').on('change', function(){table.column(3).search(this.value).draw();});
$('#clsSearch').on('change', function(){table.column(4).search(this.value).draw();});
$('#schSearch').on('change', function(){table.column(5).search(this.value).draw();});
$('#statusSearch').on('change', function(){table.column(6).search(this.value).draw();});
$('#dateSearch').on('change', function(){table.column(7).search(this.value).draw();});
});

$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "stusers_active" : "stusers_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});
<?php } elseif($page == 'registeredTeachers.php') { ?>
$(document).ready(function(){
// $("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/teachersAjax.php",bPaginate:!0,order:[[7,"desc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
$("#datalist").dataTable({
  bProcessing: true,
  sAjaxSource: "../ajax/teachersAjax",
  bPaginate: true,
  order: [[7, "desc"]],
  sPaginationType: "full_numbers",
  aoColumnDefs: [
    { bSortable: false, aTargets: -1 }
  ],
  error: function(xhr, error, thrown) {
    console.log("DataTables error: " + error);
    console.log("AJAX error: " + thrown);
  }
});

var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#userSearch').on('change', function(){table.column(0).search(this.value).draw();});
$('#fullnameSearch').on('change', function(){table.column(1).search(this.value).draw();});
$('#emailSearch').on('change', function(){table.column(2).search(this.value).draw();});
$('#contactSearch').on('change', function(){table.column(3).search(this.value).draw();});
$('#schSearch').on('change', function(){table.column(4).search(this.value).draw();});
$('#statusSearch').on('change', function(){table.column(5).search(this.value).draw();});
$('#dateSearch').on('change', function(){table.column(6).search(this.value).draw();});
});

$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "stusers_active" : "stusers_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});

$(document).on("click", ".admin-active-btn, .admin-inactive-btn", function () {
    var action = $(this).hasClass("admin-active-btn") ? "admin_stusers_active" : "admin_stusers_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});
<?php } elseif($page == 'questionList.php') { ?>
$(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/questionbankAjax.php",bPaginate:!0,order:[[0,"desc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#clsSubj').on('change', function(){table.column(1).search(this.value).draw();});
$('#ques').on('change', function(){table.column(2).search(this.value).draw();});
$('#status').on('change', function(){table.column(3).search(this.value).draw();});
});
$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_quesB:a},success:function(a){location.reload()}})});

$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "quesB_active" : "quesB_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});
<?php } elseif($page == 'reportQuestion.php') { ?>
$(document).ready(function(){
  $("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/reportQuesAjax.php",bPaginate:!0,order:[[0,"desc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#quesid').on('change', function(){table.column(0).search(this.value).draw();});
$('#dateSearch').on('change', function(){table.column(8).search(this.value).draw();});
});

$(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "reportQues_active" : "reportQues_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});
<?php } else if($page == 'userQueries.php') { ?>
  $(document).ready(function() {
    $("#datalist").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/queryListAjax",
        bPaginate: !0,
        order: [[0, "desc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

    $('#datalist').on('click', '.custom-btn', function(event) {
      var dataId = event.target.getAttribute('data-id');
      $('#replyModal').show();
      $('#replyModal').css('opacity', 1);
      $(".user-id-reply").text(dataId);
      $('#query-id').val(dataId);
    });

    $('.close').on('click', function() {
      $('#replyModal').hide();
    })

    $('#datalist').on('change', '.status-select', function(event) {
      var dataId = event.target.getAttribute('data-id');
      var status = event.target.value;

      console.log(status);

      $.ajax({
        type: "post",
        url: "../ajax/setQueryStatus",
        data: {
          id: dataId,
          status
        },
        success: function (res) {
          // window.location.reload();
        }
      })
    });
  });
<?php } else if($page == 'overallReports.php'){?>
  $(document).ready(function() {

    $("#datalist-datewise-registrations").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/dateWiseStudentAjax",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1}]
      });

    $("#datalist-school").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/overallSchoolAjax",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_school = $('#datalist-school').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#schools').on('change', function(){table_school.column(1).search(this.value).draw();});

      $("#datalist-class").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/overallClassAjax",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_class = $('#datalist-class').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#classes').on('change', function(){table_class.column(1).search(this.value).draw();});

      $("#datalist-topic").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/overallTopicAjax",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_topic = $('#datalist-topic').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#topic_classes').on('change', function(){table_topic.column(1).search(this.value).draw();});
      $('#topics').on('change', function(){table_topic.column(2).search(this.value).draw();});

      $("#datalist-subtopic").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/overallSubtopicAjax",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_subtopic = $('#datalist-subtopic').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#subtopic_classes').on('change', function(){table_subtopic.column(1).search(this.value).draw();});
      $('#subtopic_topics').on('change', function(){table_subtopic.column(2).search(this.value).draw();});
      $('#subtopics').on('change', function(){table_subtopic.column(3).search(this.value).draw();});

      $("#datalist-datewise-student").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/overallStudentAjax",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_student_datewise = $('#datalist-datewise-student').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#student_datewise_names').on('change', function(){table_student_datewise.column(1).search(this.value).draw();});
      $('#student_datewise_emails').on('change', function(){table_student_datewise.column(2).search(this.value).draw();});
      $('#student_datewise_schools').on('change', function(){table_student_datewise.column(3).search(this.value).draw();});
      $('#student_datewise_classes').on('change', function(){table_student_datewise.column(4).search(this.value).draw();});
    });
<?php } else if($page == 'schoolReports.php') {?>
  $(document).ready(function() {

    $("#datalist-datewise-class").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/datewiseClassAjax?school_id=${school_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_datewise_class = $('#datalist-datewise-class').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#datewise-classes').on('change', function(){table_datewise_class.column(1).search(this.value).draw();});

    $("#datalist-class").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallClassAjax?school_id=${school_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_class = $('#datalist-class').DataTable();	
    $('.dataTables_length').addClass('bs-select');
    $('#classes').on('change', function(){table_class.column(1).search(this.value).draw();});

    $("#datalist-topic").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallTopicAjax?school_id=${school_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_topic = $('#datalist-topic').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#topic_classes').on('change', function(){table_topic.column(1).search(this.value).draw();});
      $('#topics').on('change', function(){table_topic.column(2).search(this.value).draw();});

    $("#datalist-subtopic").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallSubtopicAjax?school_id=${school_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_subtopic = $('#datalist-subtopic').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#subtopic_classes').on('change', function(){table_subtopic.column(1).search(this.value).draw();});
      $('#subtopic_topics').on('change', function(){table_subtopic.column(2).search(this.value).draw();});
      $('#subtopics').on('change', function(){table_subtopic.column(3).search(this.value).draw();});

      $("#datalist-datewise-student").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallStudentAjax?school_id=${school_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_student_datewise = $('#datalist-datewise-student').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#student_datewise_names').on('change', function(){table_student_datewise.column(1).search(this.value).draw();});
      $('#student_datewise_emails').on('change', function(){table_student_datewise.column(2).search(this.value).draw();});
      $('#student_datewise_schools').on('change', function(){table_student_datewise.column(3).search(this.value).draw();});
      $('#student_datewise_classes').on('change', function(){table_student_datewise.column(4).search(this.value).draw();});
  });
<?php } else if($page == 'classReports.php'){ ?>
  $(document).ready(function() {

    $("#datalist-datewise-school").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/datewiseSchoolAjax?class_id=${class_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_datewise = $('#datalist-datewise-school').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#datewise-schools').on('change', function(){table_datewise.column(1).search(this.value).draw();});

    $("#datalist-school").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallSchoolAjax?class_id=${class_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });

      var table_school = $('#datalist-school').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#schools').on('change', function(){table_school.column(1).search(this.value).draw();});
  });
<?php }  else if($page == 'studentReports.php'){ ?>
  $(document).ready(function() {

    $("#datalist-student-attempted-datewise").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/datewiseStudentAttemptedAjax`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_student_attempted = $('#datalist-student-attempted-datewise').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#student_name_search').on('change', function(){table_student_attempted.column(1).search(this.value).draw();});
      $('#student_email_search').on('change', function(){table_student_attempted.column(2).search(this.value).draw();});

    $("#datalist-student-datewise").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/datewiseTopicSubtopicAjax?user_id=${user_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_topic_subtopic = $('#datalist-student-datewise').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#topic_subtopic_classes').on('change', function(){table_topic_subtopic.column(1).search(this.value).draw();});

    $("#datalist-topic").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallTopicAjax?user_id=${user_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_topic = $('#datalist-topic').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#topic_classes').on('change', function(){table_topic.column(1).search(this.value).draw();});
      $('#topics').on('change', function(){table_topic.column(2).search(this.value).draw();});

    $("#datalist-subtopic").dataTable({
        bProcessing: !0, 
        sAjaxSource: `../ajax/overallSubtopicAjax?user_id=${user_id}`,
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
    });

    var table_subtopic = $('#datalist-subtopic').DataTable();	
      $('.dataTables_length').addClass('bs-select');
      $('#subtopic_classes').on('change', function(){table_subtopic.column(1).search(this.value).draw();});
      $('#subtopic_topics').on('change', function(){table_subtopic.column(2).search(this.value).draw();});
      $('#subtopics').on('change', function(){table_subtopic.column(3).search(this.value).draw();});
  });
<?php } elseif($page == 'blogCategories.php') { ?>
$(document).ready(function(){$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/blogCategoriesAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]})}),$(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{delete_blogCat:a},success:function(a){location.reload()}})}),$(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogCat_active:a},success:function(a){location.reload()}})}),$(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{blogCat_inactive:a},success:function(a){location.reload()}})});	
<?php } else if ($page == 'boosterPage.php') { ?>
  $(document).ready(() => {
    $("#datalist").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/fetchBoosterList",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });
  });
<?php } else if ($page == 'boosterCriteriaPage.php') { ?>
  $(document).ready(() => {
    $("#datalist").dataTable({
        bProcessing: !0, 
        sAjaxSource: "../ajax/fetchBoosterCriteriaList",
        bPaginate: !0,
        order: [[0, "asc"]],
        sPaginationType: "full_numbers",
        aoColumnDefs: [{bSortable: !1, aTargets: -1}]
      });
  });
<?php } if($page == 'copyright.php' || $page == 'tnc.php' || $page == 'disclaimer.php' || $page == 'privacy.php' || $page == 'about.php' || $page == 'question-bank.php' || $page == 'editquestionbank.php') { ?>
  tinymce.init({selector:'textarea#editor,textarea.ckeditor',width:"100%",height:"250",menubar:'false',plugins:"textcolor spellchecker link media code hr searchreplace table lists image code",toolbar:"styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | bullist numlist | forecolor backcolor | link table hr | undo redo | image | code", image_title: true,
  // enable title field in the Image dialog
  force_br_newlines : false,
  force_p_newlines : false,
  forced_root_block : '',
  image_title: true, 
        // enable automatic uploads of images represented by blob or data URIs
        automatic_uploads: true,
        // URL of our upload handler (for more details check: https://www.tinymce.com/docs/configure/file-image-upload/#images_upload_url)
        images_upload_url: 'postAcceptor',
        // here we add custom filepicker only to Image dialog
        file_picker_types: 'image',
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'});
<?php } ?>
<?php if($page == 'dynamic-quest.php') { ?>
function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/dynamicAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/dynamicAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
function selectTopic(){var a=$('select[name="tpName"]').val();jQuery.ajax({url:"../ajax/dynamicAjax",data:"tpName="+a,type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})}
function selectSubTopic(){
if($('select[name="sbtpName"]').val() == ''){
      $('#displayloop').addClass('hide');
    } else {
      $('#displayloop').removeClass('hide');
    }
}
<?php } ?>
<?php if($page == 'question-bank.php') { ?>
  <?php if(!empty($row['id'])) { ?>
    function selectClass(){var a=$('select[name="clsName"]').val(),e=<?php echo $row['subject']; ?>;jQuery.ajax({url:"../ajax/quesbAjax",data:{clsName:a,sbjN:e},type:"POST",success:function(a){$("#displaySubject").html(a),selectSubject()},error:function(){}})}
    function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val(),k=<?php echo $row['topic']; ?>;jQuery.ajax({url:"../ajax/quesbAjax",data:{sbjName:a,sbjclsName:e,topicName:k},type:"POST",success:function(a){$("#displayTopic").html(a),selectTopic()},error:function(){}})}
    function selectTopic(){var a=$('select[name="tpName"]').val(),e=<?php echo $row['subtopic']; ?>;jQuery.ajax({url:"../ajax/quesbAjax",data:{tpName:a,subtopicName:e},type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})}
  <?php } else { ?>
    function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/quesbAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
    function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/quesbAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
    function selectTopic(){var a=$('select[name="tpName"]').val();jQuery.ajax({url:"../ajax/quesbAjax",data:"tpName="+a,type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})}
  <?php } ?>
<?php } ?>

<?php if($page == 'editquestionbank.php') { ?>
  function selectClass(){var a=$('select[name="clsName"]').val(),e=<?php echo $row['subject']; ?>;jQuery.ajax({url:"../ajax/quesbAjax",data:{clsName:a,sbjN:e},type:"POST",success:function(a){$("#displaySubject").html(a),selectSubject()},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val(),k=<?php echo $row['topic']; ?>;jQuery.ajax({url:"../ajax/quesbAjax",data:{sbjName:a,sbjclsName:e,topicName:k},type:"POST",success:function(a){$("#displayTopic").html(a),selectTopic()},error:function(){}})}
  function selectTopic(){var a=$('select[name="tpName"]').val(),e=<?php echo $row['subtopic']; ?>;jQuery.ajax({url:"../ajax/quesbAjax",data:{tpName:a,subtopicName:e},type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})}
<?php } ?>
  
<?php if($page == 'createQuiz.php') { ?>
  function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/quizAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/quizAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
  //function selectTopic(){var a=$('select[name="tpName"]').val();jQuery.ajax({url:"../ajax/quizAjax",data:"tpName="+a,type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})};
<?php } ?>

//-----dipanjan changes
<?php if($page == 'dynamic-quest-multiple.php') {?>
  function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/multipleQuestionsAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/multipleQuestionsAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
  //function selectTopic(){var a=$('select[name="tpName"]').val();jQuery.ajax({url:"../ajax/quizAjax",data:"tpName="+a,type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})};
<?php } ?>

<?php if($page == 'subtopicRanking.php') {?>
  function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/subtopicRankingAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/subtopicRankingAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
  //function selectTopic(){var a=$('select[name="tpName"]').val();jQuery.ajax({url:"../ajax/quizAjax",data:"tpName="+a,type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})};
<?php } ?>

<?php if($page == 'topicRanking.php') {?>
  function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/topicRankingAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/topicRankingAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
  //function selectTopic(){var a=$('select[name="tpName"]').val();jQuery.ajax({url:"../ajax/quizAjax",data:"tpName="+a,type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})};
<?php } ?>

<?php if($page == 'deleteQuestions.php') { ?>
  function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/deleteQuestionsPageAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/deleteQuestionsPageAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}

  function runQuery() {
    var dataId = event.target.getAttribute("data-id");

    $.ajax({
      type: "post",
      url: "../ajax/deleteQuestionsAjax",
      data: {
        subtopic_id: dataId
      },
      success: function(res) {
        window.location.reload();
      }
    })
  }
  <?php } ?>
  <?php if($page == 'deleteBugQuestions.php') { ?>
    function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/deleteBugQuestionsPageAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
    function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/deleteBugQuestionsPageAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
  
    function runQuery() {
      var dataId = event.target.getAttribute('data-id');

      $.ajax({
        type: "post",
        url: "../ajax/deleteBugQuestionsAjax",
        data: {
          subtopic_id: dataId
        },
        success: function(res) {
          window.location.reload();
        }
      });
    }
  <?php } ?>

<?php if($page == 'pdfGenerationPanel.php') {?>
  function selectClass(){var a=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/pdfGenerationAjax",data:"clsName="+a,type:"POST",success:function(a){$("#displaySubject").html(a)},error:function(){}})}
  function selectSubject(){var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val();jQuery.ajax({url:"../ajax/pdfGenerationAjax",data:{sbjName:a,sbjclsName:e},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}

  function runDelete() {
    var dataId = event.target.getAttribute('data-id');
    $.ajax({
      type: "post",
      url: "<?php echo $baseurl ?>ajax/deletePdfAjax",
      data: {
        subtopic_id: dataId
      },
      success: function(res) {
        // window.location.reload();
      }
    });
  }
  
  function runQuery() {
      // Get the data-id attribute value
      var dataId = event.target.getAttribute("data-id");
      // Create an AJAX request
      var xhr = new XMLHttpRequest();

      // Set up the request
      xhr.open("POST", "../ajax/fetch_data.php?id="+ dataId, true);

      // Set the callback function to handle the response
      xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
            // Process the response here if needed
            generatePDFFromData(xhr.responseText);
        }
      };

      // Send the request
      xhr.send();
  }

  async function generatePDFFromData(resp) {
    var responseParent = JSON.parse(resp);
    var file_name = responseParent.filename;
    console.log(file_name);

    // Send data to the server to render HTML content
    fetch('../offline_ppr', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ data: responseParent.data })
    })
    .then(response => response.text())
    .then(async(html) => {

          var tempDiv = document.createElement('div');
          // Insert the received HTML into the temporary div

          tempDiv.innerHTML = html;

          console.log(tempDiv);
          
          let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=100');

          mywindow.document.write(`<html><head><title>${file_name}</title>`);
          mywindow.document.write('</head><body >');
          mywindow.document.write(tempDiv.innerHTML);
          mywindow.document.write('</body></html>');

          // Add a delay before printing to allow time for the charts to render
          setTimeout(function () {
              mywindow.document.close(); // necessary for IE >= 10
              mywindow.focus(); // necessary for IE >= 10
              mywindow.print();
              mywindow.close();
          }, 5000); // Adjust the delay as needed

          // mywindow.document.title = file_name;

          return true;
      })
      .catch(error => console.error('promise_error: ', error));
  }
<?php } ?>

<?php if($page == 'listQuiz.php') { ?>
    function runQuery() {
    // Get the data-id attribute value
    var dataId = event.target.getAttribute("data-id");
    // Create an AJAX request
    var xhr = new XMLHttpRequest();

    // Set up the request
    xhr.open("POST", "../ajax/fetch_data.php?id="+ dataId, true);

    // Set the callback function to handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
        // Process the response here if needed
        generatePDFFromData(xhr.responseText);
    }
    };

    // Send the request
    xhr.send();
}

async function generatePDFFromData(res) {
  console.log("Forming");
  var responseParent = JSON.parse(res);
  var data = responseParent.data;
  var filename = responseParent.question_papername;
  // Send data to the server to render HTML content
  fetch('../ajax/download_paper', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ data: data })
  })
  .then(response => response.text())
  .then(async(html) => {

          var tempDiv = document.createElement('div');
          // Insert the received HTML into the temporary div

          tempDiv.innerHTML = html;

          console.log(tempDiv);
          
          let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=100');

          mywindow.document.write(`<html><head><title>${filename}</title>`);
          mywindow.document.write('</head><body >');
          mywindow.document.write(tempDiv.innerHTML);
          mywindow.document.write('</body></html>');

          // Add a delay before printing to allow time for the charts to render
          setTimeout(function () {
              mywindow.document.close(); // necessary for IE >= 10
              mywindow.focus(); // necessary for IE >= 10
              mywindow.print();
              mywindow.close();
          }, 5000); // Adjust the delay as needed

          // mywindow.document.title = file_name;

          return true;
    })
    .catch(error => console.error('promise_error: ', error));
}

function runDQuery() {
    // Get the data-id attribute value
    var dataId = event.target.getAttribute("data-id");
    // Create an AJAX request
    var xhr = new XMLHttpRequest();

    // Set up the request
    xhr.open("POST", "../ajax/fetch_data.php?id="+ dataId, true);

    // Set the callback function to handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
        // Process the response here if needed
        generatePDFFromData1(xhr.responseText);
    }
    };

    // Send the request
    xhr.send();
}

function generatePDFFromData1(res) {
    console.log("Forming");

    var responseParent = JSON.parse(res);
    var data = responseParent.data;
    var filename = responseParent.answer_papername;
  // Send data to the server to render HTML content
  fetch('../ajax/download_answer', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ data: data })
  })
  .then(response => response.text())
  .then(async(html) => {

          var tempDiv = document.createElement('div');
          // Insert the received HTML into the temporary div

          tempDiv.innerHTML = html;

          console.log(tempDiv);
          
          let mywindow = window.open('', 'PRINT', 'height=650,width=900,top=100,left=100');

          mywindow.document.write(`<html><head><title>${filename}</title>`);
          mywindow.document.write('</head><body >');
          mywindow.document.write(tempDiv.innerHTML);
          mywindow.document.write('</body></html>');

          // Add a delay before printing to allow time for the charts to render
          setTimeout(function () {
              mywindow.document.close(); // necessary for IE >= 10
              mywindow.focus(); // necessary for IE >= 10
              mywindow.print();
              mywindow.close();
          }, 5000); // Adjust the delay as needed

          // mywindow.document.title = file_name;

          return true;
    })
    .catch(error => console.error('promise_error: ', error));
}
<?php } ?>
 
//------ end dipanjan changes

<?php if($page == 'editQuiz.php') { ?>
  function selectClass(){var a=$('select[name="clsName"]').val(),e=<?php echo $row['subject']; ?>;jQuery.ajax({url:"../ajax/quizAjax",data:{clsName:a,sbjN:e},type:"POST",success:function(a){$("#displaySubject").html(a),selectSubject()},error:function(){}})};
  function selectSubject(){var k = <?php echo $id; ?>;var a=$('select[name="subjName"]').val(),e=$('select[name="clsName"]').val(),j=<?php echo $row['id']; ?>;jQuery.ajax({url:"../ajax/quizAjax",data:{sbjName:a,sbjclsName:e,subtopicName:j,id:k},type:"POST",success:function(a){$("#displayTopic").html(a)},error:function(){}})}
  //function selectTopic(){var a=$('select[name="tpName"]').val(),e=<?php echo $row['id']; ?>;jQuery.ajax({url:"../ajax/quizAjax",data:{tpName:a,subtopicName:e},type:"POST",success:function(a){$("#displaySubTopic").html(a)},error:function(){}})};
  $(document).ready(function() {"2"==$('select[name="selQuiz"]').val()?$("#displayQuiz").addClass("hide"):$("#displayQuiz").removeClass("hide")});
  <?php } ?>

<?php if($page == 'createQuiz.php' || $page == 'editQuiz.php') { ?>
  $(document).on("change","#selQuiz",function(){"2"==$('select[name="selQuiz"]').val()?$("#displayQuiz").addClass("hide"):$("#displayQuiz").removeClass("hide")}),
  $(document).on("change","#quessel",function(){""==$('select[name="quessel"]').val()?$("#displayClass").addClass("hide"):$("#displayClass").removeClass("hide")});
  //$(document).ready(function(){var t=new Date().toISOString().split("T")[0];$(".dateInput").attr("min",t),$(".dateInput").val(t)});
  let input = document.querySelector(".startdate").min = new Date().toISOString().slice(0, 10);
  let input1 = document.querySelector(".enddate").min = new Date().toISOString().slice(0, 10);
  $(".startdate").change(function(){
  $(".enddate").prop("min", $(this).val());
  $(".enddate").val(""); //clear end date input when start date changes
});
<?php } ?>

<?php if($page == 'listQuiz.php') { ?>
  $(document).ready(function(){
    $("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/listQuizAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
    var table = $('#datalist').DataTable();	
    $('.dataTables_length').addClass('bs-select');
    $('#clsSubj').on('change', function(){table.column(1).search(this.value).draw();});
    $('#ques').on('change', function(){table.column(2).search(this.value).draw();});
    $('#status').on('change', function(){table.column(3).search(this.value).draw();});
  });

  $(document).on("click", ".active-btn, .inactive-btn", function () {
    var action = $(this).hasClass("active-btn") ? "quizB_active" : "quizB_inactive";
    var a = $(this).data("id");

    $.ajax({
        url: "deleteAjax",
        method: "POST",
        data: { [action]: a },
        success: function (data) {
            location.reload(true);
        }
    });
});
<?php } ?>

<?php if($page == 'homeFaqs.php' ) { ?>
  $(document).ready(function(){
  $("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/homefaqsAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
  var table = $('#datalist').DataTable();	
  $('.dataTables_length').addClass('bs-select');
  $('#faqQues').on('change', function(){table.column(1).search(this.value).draw();});
  $('#status').on('change', function(){table.column(2).search(this.value).draw();});
  });
  $(document).on("click",".delete",function(){var a=$(this).data("id");confirm("Are you sure you want to remove it?")&&$.ajax({url:"deleteAjax",method:"POST",data:{home_faqs_delete:a},success:function(a){location.reload()}})});
  $(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{home_faqs_active:a},success:function(a){location.reload()}})});
  $(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{home_faqs_inactive:a},success:function(a){location.reload()}})}); 
<?php } ?>
<?php if($page == 'packages.php') { ?>
  $(document).ready(function(){
  $("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/packagesAjax.php",bPaginate:!0,order:[[0,"asc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1,aTargets:-1}]});
  });
  $(document).on("click",".active-btn",function(){window.location.reload(!0);var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{packages_active:a},success:function(a){location.reload()}})});
  $(document).on("click",".inactive-btn",function(){var a=$(this).data("id");$.ajax({url:"deleteAjax",method:"POST",data:{packages_inactive:a},success:function(a){location.reload()}})}); 
<?php } ?>

<?php if($page == 'orders.php') { ?>
  $(document).ready(function(){
$("#datalist").dataTable({bProcessing:!0,sAjaxSource:"../ajax/ordersAjax.php",bPaginate:!0,order:[[0,"desc"]],sPaginationType:"full_numbers",aoColumnDefs:[{bSortable:!1}]});
var table = $('#datalist').DataTable();	
$('.dataTables_length').addClass('bs-select');
$('#userSearch').on('change', function(){table.column(0).search(this.value).draw();});
$('#fullnameSearch').on('change', function(){table.column(1).search(this.value).draw();});
$('#emailSearch').on('change', function(){table.column(2).search(this.value).draw();});
$('#contactSearch').on('change', function(){table.column(3).search(this.value).draw();});
$('#clsSearch').on('change', function(){table.column(4).search(this.value).draw();});
$('#schSearch').on('change', function(){table.column(5).search(this.value).draw();});
$('#statusSearch').on('change', function(){table.column(6).search(this.value).draw();});
});

<?php } ?>
</script>
</html>