<?php 
    include("config/config.php");

    $userSQL = mysqli_query($conn, "SELECT u.id, u.fullname, sm.name AS school, sc.name AS class, sa.bio, sa.adjectives, u.avatar 
                                    FROM users u
                                    LEFT JOIN student_about sa
                                    ON u.id = sa.student_id
                                    LEFT JOIN school_management sm
                                    ON u.school = sm.id
                                    LEFT JOIN subject_class sc
                                    ON u.class = sc.id
                                    WHERE u.id = '". $_GET["student_id"] ."'");

    $userrow = mysqli_fetch_assoc($userSQL);
?>

<style>
    .container{
        width: 300px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .user-profile{
        height: 150px;
        width: 300px;
        display: flex;
        flex-direction: column;
        align-items: start;
        justify-content: space-evenly;
        /* border: 5px solid rgb(255, 89, 148); */
        border-radius: 1rem;
        text-align: left;
        padding: 1rem;;
    }

    .user-avatar{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 10px;
    }

    .user-avatar img{
        height: 30px;
        width: 30px;
        border-radius: 50%;
        border: 2px solid rgb(255, 89, 148);
        padding: 0.05rem;
        margin-right: 5px;
    }

    .user-name{
        font-size: 1.25rem;
        font-weight: 500;
    }

    h3{
        margin: 0.25rem !important;
    }

    .user-bio{
        font-size: 1rem;
    }

    .label{
        color: grey;
        font-style: italic;
    }
</style>

<div class="container">
    <div class="user-profile">
        <div class="user-avatar">
            <?php if(isset($userrow["avatar"])) { ?>
                <img src="<?php echo $baseurl; ?>assets/images/avatars/<?php echo $userrow["avatar"]; ?>">
            <?php } else { ?>
                <img src="<?php echo $baseurl; ?>assets/images/user.svg">
            <?php } ?>
            <div class="user-name">
                <?php echo $userrow["fullname"]; ?>
            </div>
        </div>
        <div class="user-details">
                <div class="user-school-class">
                  <span class="label"> Class: </span><?php echo $userrow["class"]; ?>
                </div>
                <div class="user-class-school">
                 <span class="label"> School: </span> <?php echo $userrow["school"]; ?>
                </div>
        </div>
        <div class="user-bio">
            <span class="label"> Adjectives: </span>
            <?php if(isset($userrow["adjectives"])) { ?>
            <?php $words = explode(",", $userrow["adjectives"]); // Split the string by comma and space

                    $niceHexColors = array(
                        "#FF5733",
                        "#3498DB",
                        "#2ECC71",
                        "#FFA500",
                        "#9B59B6",
                        "#FF6B81",
                        "#8B4513",
                        "#00BCD4",  // Cyan
                        "#FFD700",  // Gold
                        "#FF6347",  // Tomato
                        "#40E0D0",  // Turquoise
                        "#9932CC",  // Dark Orchid
                        "#FF1493",  // Deep Pink
                        "#1E90FF",  // Dodger Blue
                        "#228B22",  // Forest Green
                        "#DC143C",  // Crimson
                        "#4B0082",  // Indigo
                        "#800000",  // Maroon
                        "#008080",  // Teal
                        "#FF8C00",  // Dark Orange
                        "#7B68EE",  // Medium Slate Blue
                    );

                    shuffle($niceHexColors);
                    $colour_count = 0;
                            
                    foreach ($words as &$word) {
                        $color = $niceHexColors[$colour_count % count($niceHexColors)];
                        if (!empty($word)) {
                            $word = '<span style="color: '.$color.';"><b>' . trim($word)[0] . '</b>' . substr(trim($word), 1) . '</span>';
                        }
                        $colour_count++;
                    }

                    $newString = implode(", ", $words); // Join the modified words back together

                    echo $newString; 
                    
                } ?>
                <br> <span class="label"> About: </span>
                <?php if(isset($userrow["bio"])) {?> 
            <?php  $colour_count = 0;
            $words = explode(" ", $userrow["bio"]); 
                            
                            foreach ($words as &$word) {
                                $color = $niceHexColors[$colour_count % count($niceHexColors)];
                                if (!empty($word)) {
                                    $word = '<span style="color: '.$color.';"><b>' . trim($word)[0] . '</b>' . substr(trim($word), 1) . '</span>';
                                }
                                $colour_count++;
                            }
        
                            $newString = implode(" ", $words); // Join the modified words back together
        
                            echo $newString; 
        }?>
        </div>
    </div>
</div>