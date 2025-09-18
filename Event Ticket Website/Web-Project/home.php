<?php
    session_start();

    include("php/config.php");
    
    if(!isset($_SESSION['valid'])){
        header("Location: logIn.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="css/style2.css">
    <script src="https://kit.fontawesome.com/14f9346b7c.js" crossorigin="anonymous"></script>
</head>
<body>
   <div class="nav">
        <div class="logo">
            <p><a href="home.php">EventCon</a></p>
        </div>

        <div class="right-links">

            <?php
                $id = $_SESSION['id'];
                $query = mysqli_query($con, "SELECT * FROM users WHERE Id = $id");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                    $res_id = $result['Id'];
                }

                echo "<a href='edit_profile.php?Id=$res_id' style='text-decoration:none; margin-right:25px; color:#f5f5f5;'>Change Profile</a>";
                    
            ?>

            
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </div>
   </div>
   
   <main>
        <div class="main-box top">
            <div class="top">
                <div class="box">
                    <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
                </div>

                <div class="box">
                    <p>Your email is <b><?php echo $res_Email ?></b></p>
                </div>
            </div>

            <div class="bottom">
                <div class="box">
                    <div class="user-box">
                        <h1 class="head-text">Pick Your Event ~ Enjoy it to Your Heart's Content</h1>
                        <?php
                            $eventQuery = "SELECT * FROM events";
                            $eventResult = mysqli_query($con, $eventQuery);
                            $eventResultCheck = mysqli_num_rows($eventResult);
            
                            if($eventResultCheck > 0){
                                while($row = mysqli_fetch_assoc($eventResult)){
                                    $eTime = $row['Time'];
                                    $eTitle = $row['Title'];
                                    $eVenue = $row['Venue'];
                                    $eDesc = $row['Description'];
                                    $eLimit = $row['Limitation'];

                                    $eId = $row['Event_Id'];
                        ?>
                        <div class="list">
                                <div class="check">
                                    <i class="fa-solid fa-music"></i>   
                                    <i class="fa-solid fa-circle-check"></i>
                                    <h2><?php echo $eTime ?></h2>
                                </div>
                                <div class="detail">
                                    
                                    <h2><?php echo $eTitle ?></h2>
                                    <b><?php echo $eVenue ?></b>
                                    <p><?php echo $eDesc?></p>

                                    <?php
                                        
                                        $verifying_query = mysqli_query($con, "SELECT User_Id, Event_Id FROM entry WHERE User_Id='$id' AND Event_Id='$eId'");
                                        
                                        if(isset($_POST['submit-' .$eId])){

                                            //Place for limit
                                            $limit_query = mysqli_query($con, "SELECT COUNT(*) AS count FROM entry WHERE Event_Id='$eId'");
                                            $limit_result = mysqli_fetch_assoc($limit_query);
                                            $currentParticipants = $limit_result['count'];

                                            if($currentParticipants >= $eLimit){
                                                    echo"<div class=pop-up id=popup>
                                                            <img src='img/circle-exclamation.png'>
                                                            <h2>Sorry This Event Have Full</h2>
                                                            <p>Thank you for your support.</p>
                                                            <a href='javascript:self.history.back()'><button>Return Home</button></a>
                                                        </div>";
                                                }
                                            
                                            else{
                                                //Validation for Entry
                                                if(mysqli_num_rows($verifying_query) != 0){
                                                    echo"<div class=pop-up id=popup>
                                                                <img src='img/circle-check.png'>
                                                                <h2>You Already Participated on This Event</h2>
                                                                <p>Your participation is so appreciated. Thank You</p>
                                                                <a href='javascript:self.history.back()'><button>Return Home</button></a>
                                                        </div>";
                                                }

                                                else{
                                                    $entryQueryIn = "INSERT INTO entry (User_Id, Event_Id, Register) VALUES ('$id', '$eId', '1')";
                                                    $entryResult = mysqli_query($con, $entryQueryIn);

                                                    if($entryResult){
                                                        
                                                        echo"<div class=pop-up id=popup>
                                                                <img src='img/circle-check.png'>
                                                                <h2>Thank You</h2>
                                                                <p>Your registration have been captured. Thanks!</p>
                                                                <a href='javascript:self.history.back()'><button>Return Home</button></a>
                                                        </div>";  
                                                            
                                                    } 
                                                    else {
                                                        // Data insertion failed
                                                        echo "Error occurred while inserting data.". mysqli_error($con);
                                                    }
                                                }
                                            }
                                        }

                                        if(isset($_POST['delete-' .$eId])){

                                            //Validation for Entry - Delete
                                            if(mysqli_num_rows($verifying_query) != 1){
                                                echo"<div class=pop-up id=popup>
                                                            <img src='img/circle-exclamation.png'>
                                                            <h2>You Already Cancel This Event</h2>
                                                            
                                                            <a href='javascript:self.history.back()'><button>Return Home</button></a>
                                                    </div>";
                                            }

                                            else{
                                                $entryQueryIn = "DELETE FROM entry WHERE User_Id='$id' AND Event_Id='$eId'";
                                                $entryResult = mysqli_query($con, $entryQueryIn);

                                                if($entryResult){
                                                    
                                                    echo"<div class=pop-up id=popup>
                                                            <img src='img/circle-trash.png'>
                                                            <h2>Cancel Successfull</h2>
                                                            <p>Hope to see you again in The Next Event!</p>
                                                            <a href='javascript:self.history.back()'><button>Return Home</button></a>
                                                    </div>";  
                                                        
                                                } 
                                                else {
                                                    // Data insertion failed
                                                    echo "Error occurred while inserting data.". mysqli_error($con);
                                                }
                                            }
                                        }
                                    ?>

                                    <div class="regis">
                                        <form action="" method="post">
                                            <input type="hidden" name="event-id" value="<?php echo $eId; ?>">
                                            <input type="submit" class="del-btn" name="delete-<?php echo $eId; ?>" value="Cancel">

                                            <input type="hidden" name="event-id" value="<?php echo $eId; ?>">
                                            <input type="submit" class="register-btn" name="submit-<?php echo $eId; ?>" value="Register">
                                            
                                        </form>
                                                    
                                    </div>
                                    
                                </div>
                        </div>
                        <?php }
                            }?>
                    </div>
                </div>
            </div>
        </div>
        
   </main>
</body>

</html>