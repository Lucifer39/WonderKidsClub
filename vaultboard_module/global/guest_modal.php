
  <!-- Include Bootstrap CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  
  <style>
    body {
      background-color: #f8f9fa;
      font-family: Arial, sans-serif;
    }
    
    .modal-content {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    h4 {
      font-size: 20px;
      color: #333333;
      margin-top: 0;
      margin-bottom: 20px;
    }
    
    p {
      font-size: 16px;
      color: #666666;
      line-height: 1.5;
      margin-bottom: 20px;
    }
    
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    
    .btn-primary:hover {
      background-color: #0069d9;
      border-color: #0062cc;
    }
  </style>
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <h4>Welcome, guest user!</h4>
        <p>We're thrilled to have you here. As a guest, you can enjoy exciting activities and games on our platform. Please note that some features are exclusively available to registered users.</p>
        <p>Make the most of the available fun and interactive content. Explore, play, and learn with other kids from around the world. You'll discover a world of adventure and knowledge at your fingertips!</p>
        <p>If you'd like to unlock additional features and personalize your experience, consider asking a parent or guardian to sign you up. It's quick, easy, and opens doors to even more exciting possibilities.</p>
        <p>Thank you for joining us as a guest. We hope you have an amazing time here!</p>
        <button type="button" id="guest-modal-close" class="btn btn-primary" data-bs-dismiss="modal">Continue as Guest</button>
      </div>
    </div>
  </div>
  
  <!-- Include Bootstrap JavaScript -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
  
  <script>
    // Show the modal when the page finishes loading
    window.addEventListener("load", function() {
      var myModal = new bootstrap.Modal(document.getElementById("myModal"));
      myModal.show();
    });

    document.getElementById("guest-modal-close").addEventListener("click", () => {
      $.ajax({
        type: "post",
        url: "<?php echo GLOBAL_URL; ?>connection/dependencies.php?function_name=setGuestModal"
      })
    })
  </script>

