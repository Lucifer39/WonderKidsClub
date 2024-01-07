<style>
.popup {
      position: fixed;
      top: 20px;
      left: 20px;
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      z-index: 9999;
    }

    .popup.show {
      opacity: 1;
      visibility: visible;
    }
</style>

  <div class="popup" id="popup">
    <div class="popup-content">
      <h2 id="popup-title">Notification</h2>
      <p id="popup-body">This is a popup notification message.</p>
    </div>
  </div>

  <script>
    function showPopup(notification_title, notification_body) {
        var popup = document.getElementById("popup");
        var popupTitleContainer = document.getElementById("popup-title");
        var popupBodyContainer = document.getElementById("popup-body");

        popupTitleContainer.textContent = notification_title;
        popupBodyContainer.textContent =notification_body;

        popup.classList.add("show");

        setTimeout(() => {
            hidePopup();
        }, 2000);
    }

    function hidePopup() {
        var popup = document.getElementById("popup");
        popup.classList.remove("show");
    }

  </script>