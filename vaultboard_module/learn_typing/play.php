<?php 
    $dir = __DIR__;
    require_once($dir ."/functions/level_functions.php");
    require_once("functions/play_functions.php");
    
    $parentdir = dirname($dir);
    require_once($parentdir ."/connection/dependencies.php");
    require_once($parentdir ."/global/navigation.php");
    include_once($parentdir.'/login_page.php');

    $getid = getID();
    $isGetIDEmpty = empty($getid); // Check if getid is empty
    // if($getid == ""){
    //     header("Location: ". GLOBAL_URL ."login_page.php");
    // }

    $student = getCurrentStudent();
    $group_id = $_GET["group_id"];

    if($group_id == '') {
        ?>
            <script>
                window.location.href = "<?php echo GLOBAL_URL; ?>learn_typing/index.php?page=levels_page";
            </script>
        <?php
    }

    $group_desc = get_group_desc($group_id);
    $group_name = $group_desc->group_name;


    if(!$isGetIDEmpty){
        $status = check_valid_group($student["id"], $group_id);

        if($group_id == 1 || $status == "ongoing" || $status == "completed"){
            $join_play = make_ongoing($student["id"], $group_id);
        }
        else{
            header("Location: ". GLOBAL_URL ."learn_typing/main_menu.php");
        }
    }

    
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="./style.css">
<script>
    var data = <?php echo json_encode($group_desc); ?>;
    var group_id = <?php echo json_encode($group_id); ?>;
    var group_name = <?php echo json_encode($group_name); ?>;
    var student = <?php echo json_encode($student); ?>;
    var isGetIDEmpty = <?php echo $isGetIDEmpty ? 'true' : 'false'; ?>; 
</script>
    <div class="text-white bg-danger rounded" id="floating-div"><i class="bi bi-x-circle-fill text-white"></i> Please keep the Input Box focused for Typing</div>
    <audio id="typing-sound" src="extras/audio/y2mate.com - Keyboard typing sound effect.mp3" preload="auto"></audio>
    <audio id="mistyped-sound" src="extras/audio/y2mate.com - Knock knock klopfen  Sound Effect.mp3" preload="auto"></audio>

    <div class="play-container d-flex mt-2">
        <div class="game-box col-sm-11 border-0 shadow-lg">
            <h3 id="skill-name"></h3>
            <div id="type-master-container">
                <div id="combinations" class="border-0 bg-dark text-white shadow mt-3"></div>
                <input type="text" id="input-box" onblur="this.focus()" autofocus>
            </div>
        </div>
        <div class="type-tools">
            Sound: 
            <label class="toggle-switch">
                <input type="checkbox" id="sound-icon" checked>
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="col-3" style="padding:10px 10px 0 15px">
            <div class="text-dark shadow instructions">
                <h5 class="text-center insthead"><b>INSTRUCTIONS</b></h5>
                <ul class="mt-2 instul">
                    <li>Please Keep the <b class="text-danger">Input Box</b> focused for writing.</li>
                    <li>Rest Your left hand fingers on letters<b class="text-danger"> A, S, D & F</b></li>
                    <li>Rest Your right hand fingers on letters<b class="text-danger"> J, K, L & ;</b></li>
                    <li>Press <b class="text-danger">Shift</b> accordingly for Capital Letters</li>
                    <li>Once you are thorough with the letters <b class="text-danger">don't look at keyboard</b></li>
                </ul>
            </div>
        </div>
        <div class="col-9 keyboard text-start">
            <div class="p-2" id="dtext"></div>
            <div class="keyboard__row keyboard__row--h1">
                <div data-key="27" class="key--word">
                <span>esc</span>
                </div>
                <div data-key="112" class="key--fn">
                <span>F1</span>
                </div>
                <div data-key="113" class="key--fn">
                <span>F2</span>
                </div>
                <div data-key="114" class="key--fn">
                <span>F3</span>
                </div>
                <div data-key="115" class="key--fn">
                <span>F4</span>
                </div>
                <div data-key="116" class="key--fn">
                <span>F5</span>
                </div>
                <div data-key="117" class="key--fn">
                <span>F6</span>
                </div>
                <div data-key="118" class="key--fn">
                <span>F7</span>
                </div>
                <div data-key="119" class="key--fn">
                <span>F8</span>
                </div>
                <div data-key="120" class="key--fn">
                <span>F9</span>
                </div>
                <div data-key="121" class="key--fn">
                <span>F10</span>
                </div>
                <div data-key="122" class="key--fn">
                <span>F11</span>
                </div>
                <div data-key="123" class="key--fn">
                <span>F12</span>
                </div>
                <div data-key="n/a" class="key--word">
                <span>pwr</span>
                </div>
            </div>
            <div class="keyboard__row">
                <div class="key--double" data-key="192">
                <div>~</div>
                <div>`</div>
                </div>
                <div class="key--double" data-key="49">
                <div>!</div>
                <div>1</div>
                </div>
                <div class="key--double" data-key="50">
                <div>@</div>
                <div>2</div>
                </div>
                <div class="key--double" data-key="51">
                <div>#</div>
                <div>3</div>
                </div>
                <div class="key--double" data-key="52">
                <div>$</div>
                <div>4</div>
                </div>
                <div class="key--double" data-key="53">
                <div>%</div>
                <div>5</div>
                </div>
                <div class="key--double" data-key="54">
                <div>^</div>
                <div>6</div>
                </div>
                <div class="key--double" data-key="55">
                <div>&</div>
                <div>7</div>
                </div>
                <div class="key--double" data-key="56">
                <div>*</div>
                <div>8</div>
                </div>
                <div class="key--double" data-key="57">
                <div>(</div>
                <div>9</div>
                </div>
                <div class="key--double" data-key="48">
                <div>)</div>
                <div>0</div>
                </div>
                <div class="key--double" data-key="189">
                <div>_</div>
                <div>-</div>
                </div>
                <div class="key--double" data-key="187">
                <div>+</div>
                <div>=</div>
                </div>
                <div class="key--bottom-right key--word key--w4" data-key="8">
                <span>delete</span>
                </div>
            </div>
            <div class="keyboard__row">
                <div class="key--bottom-left key--word key--w4" data-key="9">
                <span>tab</span>
                </div>
                <div class="key--letter" data-char="Q">Q</div>
                <div class="key--letter" data-char="W">W</div>
                <div class="key--letter" data-char="E">E</div>
                <div class="key--letter" data-char="R">R</div>
                <div class="key--letter" data-char="T">T</div>
                <div class="key--letter" data-char="Y">Y</div>
                <div class="key--letter" data-char="U">U</div>
                <div class="key--letter" data-char="I">I</div>
                <div class="key--letter" data-char="O">O</div>
                <div class="key--letter" data-char="P">P</div>
                <div class="key--double" data-key="219" data-char="{[">
                <div>{</div>
                <div>[</div>
                </div>
                <div class="key--double" data-key="221" data-char="}]">
                <div>}</div>
                <div>]</div>
                </div>
                <div class="key--double" data-key="220" data-char="|\">
                <div>|</div>
                <div>\</div>
                </div>
            </div>
            <div class="keyboard__row">
                <div class="key--bottom-left key--word key--w5" data-key="20">
                <span>caps lock</span>
                </div>
                <div class="key--letter" data-char="A">A</div>
                <div class="key--letter" data-char="S">S</div>
                <div class="key--letter" data-char="D">D</div>
                <div class="key--letter" data-char="F">F</div>
                <div class="key--letter" data-char="G">G</div>
                <div class="key--letter" data-char="H">H</div>
                <div class="key--letter" data-char="J">J</div>
                <div class="key--letter" data-char="K">K</div>
                <div class="key--letter" data-char="L">L</div>
                <div class="key--double" data-key="186">
                <div>:</div>
                <div>;</div>
                </div>
                <div class="key--double" data-key="222">
                <div>"</div>
                <div>'</div>
                </div>
                <div class="key--bottom-right key--word key--w5" data-key="13">
                <span>return</span>
                </div>
            </div>
            <div class="keyboard__row">
                <div class="key--bottom-left key--word key--w6" data-key="16">
                <span>shift</span>
                </div>
                <div class="key--letter" data-char="Z">Z</div>
                <div class="key--letter" data-char="X">X</div>
                <div class="key--letter" data-char="C">C</div>
                <div class="key--letter" data-char="V">V</div>
                <div class="key--letter" data-char="B">B</div>
                <div class="key--letter" data-char="N">N</div>
                <div class="key--letter" data-char="M">M</div>
                <div class="key--double" data-key="188">
                <div>&lt;</div>
                <div>,</div>
                </div>
                <div class="key--double" data-key="190">
                <div>&gt;</div>
                <div>.</div>
                </div>
                <div class="key--double" data-key="191">
                <div>?</div>
                <div>/</div>
                </div>
                <div class="key--bottom-right key--word key--w6" data-key="16-R">
                <span>shift</span>
                </div>
            </div>
            <div class="keyboard__row keyboard__row--h3">
                <div class="key--bottom-left key--word">
                <span>fn</span>
                </div>
                <div class="key--bottom-left key--word key--w1" data-key="17">
                <span>control</span>
                </div>
                <div class="key--bottom-left key--word key--w1" data-key="18">
                <span>option</span>
                </div>
                <div class="key--bottom-right key--word key--w3" data-key="91">
                <span>command</span>
                </div>
                <div class="key--double key--right key--space" data-key="32" data-char=" ">
                &nbsp;
                </div>
                <div class="key--bottom-left key--word key--w3" data-key="93-R">
                <span>command</span>
                </div>
                <div class="key--bottom-left key--word key--w1" data-key="18-R">
                <span>option</span>
                </div>
                <div data-key="37" class="key--arrow">
                <span>&#9664;</span>
                </div>
                <div class="key--double key--arrow--tall" data-key="38">
                <div>&#9650;</div>
                <div>&#9660;</div>
                </div>
                <div data-key="39" class="key--arrow">
                <span>&#9654;</span>
                </div>
            </div>
            <img src="./images/handscolored.png" />
        </div>
    </div>
    <!-- KEYBOARD KEYS -->
    
    <div class="modal-1" id="modal">
        <div class="modal-container">
            <div id="modal-header"></div>
            <div id="modal-buttons"></div>
        </div>
    </div>

<script src="scripts/play_script.js"></script>
<script src="scripts/keyboard.js"></script>
<script>
    const inputField = document.getElementById('input-box');
    const floatingDiv = document.getElementById('floating-div');

    // Function to show the floating div
    function showFloatingDiv() {
        floatingDiv.style.opacity = '1';
        floatingDiv.style.pointerEvents = 'auto';
        floatingDiv.style.display = 'block';
        setTimeout(function() {
            floatingDiv.style.display = 'none';
        }, 2000);
    }

    // Function to hide the floating div
    function hideFloatingDiv() {
        floatingDiv.style.display = 'none';
    }

    // Event listener for when the input field loses focus
    inputField.addEventListener('blur', showFloatingDiv);

    // Event listener for when the input field gains focus
    inputField.addEventListener('focus', hideFloatingDiv);

    window.addEventListener('DOMContentLoaded', () => {
        const errorTextElement = document.getElementById('dtext');
        const counter = sessionStorage.getItem('counter');
        
        if (counter > 0) {
            errorTextElement.innerHTML = '<i class="bi bi-x-circle-fill text-white align-middle"></i> Check for the wrong character';
            errorTextElement.style.display = 'block';
            errorTextElement.classList.add('show');

            setTimeout(function() {
                errorTextElement.classList.remove('show');
                setTimeout(function() {
                    errorTextElement.style.display = 'none';
                }, 500);
            }, 2000);
        } else {
            errorTextElement.style.display = 'none';
        }
    });
</script>