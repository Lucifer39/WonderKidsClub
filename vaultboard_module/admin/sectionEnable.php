<?php 
    require_once("functions/toggleSectionsFunctions.php");

    $section_array = getSections();
?>
<style>
        /* Style for the toggle container */
        .toggle-container {
            display: inline-block;
            position: relative;
            width: 60px;
            height: 30px;
            background-color: #ccc;
            border-radius: 15px;
            cursor: pointer;
            margin: 0 10px;
        }

        /* Style for the toggle switch */
        .toggle-switch {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 26px;
            height: 26px;
            background-color: #fff;
            border-radius: 50%;
            transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
        }

        /* Style for the "Off" and "On" labels */
        .toggle-label {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
            display: inline-block;
        }

        /* Style for the "Off" state */
        .toggle-off {
            transform: translateX(0);
        }

        /* Style for the "On" state */
        .toggle-on {
            transform: translateX(30px);
            background-color: #4CAF50; /* Green color when On */
        }
        .button-container{
        	display: flex;
        	align-items: center;
        }

        .parent-toggle-container{
            height: 600px;
            overflow-y: scroll;
            display: block;
        }
    </style>
    <script>
        function toggleSwitch(buttonID) {
            const toggleSwitch = document.getElementById(buttonID);
            if (toggleSwitch.classList.contains('toggle-off')) {

                $.ajax({
                    type: "post",
                    url: "functions/toggleSectionsFunctions.php?function_name=setToggle",
                    data: {
                        id:buttonID,
                        enable: 1
                    },
                    success: function(res) {
                        var response =JSON.parse(res);

                        if(response) { 
                            toggleSwitch.classList.remove('toggle-off');
                            toggleSwitch.classList.add('toggle-on');
                        }
                    }
                })
            } else {

                $.ajax({
                    type: "post",
                    url: "functions/toggleSectionsFunctions.php?function_name=setToggle",
                    data: {
                        id:buttonID,
                        enable: 0
                    },
                    success: function(res) {
                        var response =JSON.parse(res);

                        if(response) { 
                            toggleSwitch.classList.remove('toggle-on');
                            toggleSwitch.classList.add('toggle-off');
                        }
                    }
                })
            }

            // Get the current value (0 or 1) based on the toggle state
            // const value = toggleSwitch.classList.contains('toggle-on') ? 1 : 0;
        }
    </script>
<div class="container text-center parent-toggle-container">
    <h3>Toggle Sections</h3>
    <?php 
        foreach($section_array as $each) {
            ?>
                <div class="row align-items-center justify-content-between w-100 m-4">
                    <div class="col">
                        <?php echo $each["section"]; ?>
                    </div>
                    <div class="col">
                        <div class="toggle-section">
                            <div class="toggle-label">Disable</div>
                                <div class="toggle-container" onclick="toggleSwitch(<?php echo $each['id']; ?>)">
                                    <div class="toggle-switch <?php echo $each['enable'] == 1 ? 'toggle-on' : 'toggle-off'; ?>" id="<?php echo $each["id"]; ?>"></div>
                                </div>
                                <div class="toggle-label">Enable</div>
                        </div>
                    </div>
                </div>
            <?php
        }
    ?>
</div>