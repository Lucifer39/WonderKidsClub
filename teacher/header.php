<?php 
$usrsql = mysqli_query($conn, "SELECT fullname FROM users WHERE id='".$_SESSION['id']."'");
$usrrow = mysqli_fetch_assoc($usrsql);

$link = $_SERVER[ 'PHP_SELF' ];
$link_array = explode( '/', $link );
$page = end( $link_array );

?>
<header>
    <div class="header-wrap">
        <div class="container-fluid">            
            <div class="row align-items-center">
                <div class="col-8">
                    <ul class="btn-link d-flex align-items-center pb-0">
                    <li>
                <a href="group">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 3C12.9283 3 13.8185 3.36875 14.4749 4.02513C15.1313 4.6815 15.5 5.57174 15.5 6.5C15.5 7.42826 15.1313 8.3185 14.4749 8.97487C13.8185 9.63125 12.9283 10 12 10C11.0717 10 10.1815 9.63125 9.52513 8.97487C8.86875 8.3185 8.5 7.42826 8.5 6.5C8.5 5.57174 8.86875 4.6815 9.52513 4.02513C10.1815 3.36875 11.0717 3 12 3ZM5 5.5C5.56 5.5 6.08 5.65 6.53 5.92C6.38 7.35 6.8 8.77 7.66 9.88C7.16 10.84 6.16 11.5 5 11.5C4.20435 11.5 3.44129 11.1839 2.87868 10.6213C2.31607 10.0587 2 9.29565 2 8.5C2 7.70435 2.31607 6.94129 2.87868 6.37868C3.44129 5.81607 4.20435 5.5 5 5.5ZM19 5.5C19.7956 5.5 20.5587 5.81607 21.1213 6.37868C21.6839 6.94129 22 7.70435 22 8.5C22 9.29565 21.6839 10.0587 21.1213 10.6213C20.5587 11.1839 19.7956 11.5 19 11.5C17.84 11.5 16.84 10.84 16.34 9.88C17.2 8.77 17.62 7.35 17.47 5.92C17.92 5.65 18.44 5.5 19 5.5ZM5.5 15.75C5.5 13.68 8.41 12 12 12C15.59 12 18.5 13.68 18.5 15.75V17.5H5.5V15.75ZM0 17.5V16C0 14.61 1.89 13.44 4.45 13.1C3.86 13.78 3.5 14.72 3.5 15.75V17.5H0ZM24 17.5H20.5V15.75C20.5 14.72 20.14 13.78 19.55 13.1C22.11 13.44 24 14.61 24 16V17.5Z" fill="white"/>
</svg>
                    <span>Group</span>
                </a>
            </li>
                   <!-- <li>
                <a href="stats">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M9 17H7V10H9V17ZM13 17H11V7H13V17ZM17 17H15V13H17V17ZM19 19H5V5H19V19.1M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3Z" fill="white"/>
</svg>
                    <span>Stats</span>
                </a>
            </li>-->
                    </ul>
                </div>
                <div class="col-4 pe-0 text-end">
                    <div class="usr-profile pe-5 ps-3">
                    <div class="profile-img">
                        <figure class="mb-0">
                            <img src="../assets/images/profile.jpg" width="100" height="100" alt="">
                        </figure>
</div>
                    <div class="text-start">
                    <h2><a href="profile"><?php echo $usrrow['fullname']; ?></a></h2>
                    <a href="<?php echo $baseurl.'logout'; ?>" class="btn btn-red btn-sm custom-btn">LOGOUT</a>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
    </header> 