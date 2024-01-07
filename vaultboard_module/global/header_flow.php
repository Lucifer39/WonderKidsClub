<?php 
  $dir = __DIR__;
  $parentdir = dirname($dir);
  require_once($parentdir ."/connection/dependencies.php");
  require_once($parentdir. "/connection/logout.php");
  require_once("navigation.php");

  $student_id = getID();
?>

<head>
 <?php require_once("head.php"); ?>
</head>

<style>
    .navbar {
  background-color: #FFFFFF;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
  width: 100%;
}

.nav-tabs {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}

.tab {
  padding: 10px 15px;
  margin-right: 10px;
  background-color: #EFEFEF;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.tab.active {
  background-color: #2C82C9;
}

.tab a {
  text-decoration: none;
  color: #333333;
  font-weight: bold;
  transition: color 0.3s ease;
}

.tab a:hover {
  color: #FFFFFF;
}

.nav-buttons .btn {
  padding: 10px 15px;
  margin-left: 10px;
  background-color: #2C82C9;
  border: none;
  color: #FFFFFF;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s ease;
}

.nav-buttons .btn:hover {
  background-color: #1A5F8B;
}

.navbar-right{
  display:flex;
  width: 20%;
  justify-content: space-evenly;
  align-items: center;
}

.dropdown-menu {
  display: none;
  padding: 1rem;
}

.dropdown-menu a{
  text-decoration: none;
  color: #000;
}

.dropdown-menu li{
  padding: 1rem;
  border-bottom: 1px solid #777;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
}

.dropdown-menu li:hover{
  background-color: #eee;
  cursor: pointer;
  color: #fff;
}

.header-flow-li:hover .dropdown-menu {
  display: block;
}

li{
  list-style-type: none;
}

.header-flow-li{
  padding: 1rem;
  width: 100%;
  height: 100%;
  border-right: 1px solid #777;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.header-flow-li:hover{
  cursor: pointer;
  background-color: #eee;
}

.header-flow{
  height: 100%;
  width: 30%;
  display: flex;
  justify-content: space-around;
}


</style>

<nav class="navbar">
  <!-- <ul class="nav-tabs">
    <li class="tab active"><a href="../vocabulary_module/index.php?universe=words">Words</a></li>
    <li class="tab active"><a href="../vocabulary_module/index.php?universe=idioms">Idioms</a></li>
    <li class="tab active"><a href="../vocabulary_module/index.php?universe=simile">Simile</a></li>
    <li class="tab active"><a href="../vocabulary_module/index.php?universe=metaphor">Metaphor</a></li>
    <li class="tab active"><a href="../vocabulary_module/index.php?universe=hyperbole">Hyperbole</a></li>
    <li class="tab active"><a href="../learn_typing/main_menu.php">Learn Typing</a></li>
    <li class="tab active"><a href="../type_master/mainMenu.php">Type Master</a></li>
  </ul> -->

  <ul class="header-flow">
  <li class="header-flow-li">
    <div>
    Vocab Module
      <ul class="dropdown-menu">
        <li class="dropdown-menu-li"><a href="../vocabulary_module/index.php?universe=words">Words</a></li>
        <li class="dropdown-menu-li"><a href="../vocabulary_module/index.php?universe=idioms">Idioms</a></li>
        <li class="dropdown-menu-li"><a href="../vocabulary_module/index.php?universe=simile">Simile</a></li>
        <li class="dropdown-menu-li"><a href="../vocabulary_module/index.php?universe=metaphor">Metaphor</a></li>
        <li class="dropdown-menu-li"><a href="../vocabulary_module/index.php?universe=hyperbole">Hyperbole</a></li>
      </ul>
    </div>
  </li>
  <li class="header-flow-li">
    <div>
    Typing Module
    <ul class="dropdown-menu">
      <li class="dropdown-menu-li"><a href="../learn_typing/main_menu.php">Learn Typing</a></li>
      <li class="dropdown-menu-li"><a href="../type_master/mainMenu.php">Type Master</a></li>
    </ul>
    </div>
  </li>
  <li class="header-flow-li">
    <a href="../discussion_forum/pages/newsfeed.php">
      <div>
        Discussion Forum
      </div>
    </a>
  </li>
</ul>


  <div class="navbar-right">
    <?php 
        require_once("notifications_tab.php");
    ?>
    <!-- <form method="POST">
      <div class="nav-buttons">
      <input type="submit" name="logout_button" value="Logout">
      </div>
    </form> -->
  </div>
</nav>

<?php 
  if(isset($_POST["logout_button"])){
    // logout($student_id);
    header("Location: ". GLOBAL_URL ."login_page.php");
    exit;
  }
?>

<!-- <script>
  var student_id = <?php echo json_decode($student_id); ?>;

  function logout_fn(){
    $.ajax({
      type: "POST",
      url: "../connection/dependencies.php?function_name=logout",
      data: {
        student_id
      },
      success: function (res){
        window.location.href = "../login_page.php";
      }
    })
  }
</script> -->
