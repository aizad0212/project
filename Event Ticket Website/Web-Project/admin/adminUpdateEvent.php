<?php
    session_start();

    include("../php/config.php");
    
    if(!isset($_SESSION['valid'])){
        header("Location: ../logIn.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="../css/style2.css">
    <script src="https://kit.fontawesome.com/14f9346b7c.js" crossorigin="anonymous"></script>
</head>
<body>
   <div class="nav">
        <div class="logo">
            <p><a href="../adminHome.php">Administrator</a></p>
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
                    

                //echo "<a href='edit_profile.php?Id=$res_id' style='text-decoration:none; margin-right:25px; color:#f5f5f5;'>Change Profile</a>";
                   
            ?>

            
            <a href="../php/logout.php"><button class="btn">Log Out</button></a>
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
                        <h1 class="head-text">Update Event Records</h1>

                        <a href="adminUpdateNewEvent.php"><button class="btn" style="margin-left:44%; margin-bottom:10px">+ New Event</button></a>
                        <?php
                        
                        
                        
                        
                        //UPDATE
                        
                        if(isset($_POST['update'])){
                            $Time = $_POST['upTime'];
                            $Title = $_POST['upTitle'];
                            $Venue = $_POST['upVenue'];
                            $Desc = $_POST['upDescription'];
                            $Lim = $_POST['upLimitation'];
            //PROBLEM Event_Id
                            $Event_Id = $_POST['Event_Id'];
            
                            $change_query = mysqli_query($con, "UPDATE events SET `Time`='$Time',`Title`='$Title',`Venue`='$Venue',`Description`='$Desc',`Limitation`= '$Lim' WHERE Event_Id='$Event_Id'") or die("Error Occured - Update");
        
                            if($change_query){
                                echo "<div class='message'>
                                        <p>Data Have Been Updated !</p>
                                    </div> <br>";
                                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                            }
                            
                            
                        } 
                            
                        else{
                            //$id = $_SESSION['Event_Id'];
                            $eventQuery = "SELECT * FROM events /*WHERE Event_Id = $id*/";
                            $eventResult = mysqli_query($con, $eventQuery);
                            $eventResultCheck = mysqli_num_rows($eventResult);


                            if(isset($_POST['delete'])){

                                $Time = $_POST['upTime'];
                                $Title = $_POST['upTitle'];
                                $Venue = $_POST['upVenue'];
                                $Desc = $_POST['upDescription'];
                                $Lim = $_POST['upLimitation'];
                //PROBLEM Event_Id
                                $Event_Id = $_POST['Event_Id'];

                                //Validation for Entry - Delete
                                    
                                $entryQueryIn = "DELETE FROM events WHERE Event_Id='$Event_Id'";
                                $entryResult = mysqli_query($con, $entryQueryIn);

                                if($entryResult){
                                    
                                    echo"<div class=pop-up id=popup>
                                            <img src='../img/circle-trash.png'>
                                            <h2>Delete Successfull</h2>
                                            
                                            <a href='javascript:self.history.back()'><button>Return Home</button></a>
                                    </div>";  
                                        
                                } 
                                else {
                                    // Data insertion failed
                                    echo "Error occurred while inserting data.". mysqli_error($con);
                                
                                }
                            }

                            
                            if($eventResultCheck > 0){
                                while($row = mysqli_fetch_assoc($eventResult)){
                                    $eTime = $row['Time'];
                                    $eTitle = $row['Title'];
                                    $eVenue = $row['Venue'];
                                    $eDesc = $row['Description'];
                                    $eLimit = $row['Limitation'];

                                    $eId = $row['Event_Id'];
                                    
                        ?>
                                    <form action="" method="post">
                                        <div class="list">
                                            <div class="check">
                                                <i class="fa-solid fa-music"></i>   
                                                <i class="fa-solid fa-circle-check"></i>
                                                
                                                    <h2><input type="hidden" name="Event_Id" id="date" value="<?php echo $eId ?>"></h2>
                                                    <h2><input type="date" name="upTime" id="date" value="<?php echo $eTime ?>"></h2>
                                                
                                            </div>
                                            <div class="detail">
                                                
                                                    <h2><input type="text" name="upTitle" id="title" value="<?php echo $eTitle ?>"></h2>
                                                    <b><input type="text" name="upVenue" id="venue" value="<?php echo $eVenue ?>"></b>
                                                    <p><textarea name="upDescription" id="desc" cols="100" rows="10" value=""><?php echo $eDesc?></textarea></p>
                                                    <p><input type="number" name="upLimitation" id="limit" value="<?php echo $eLimit?>"></p>
                                                

                                                <div class="regis">
                                                    
                                                        <input type="submit" class="register-btn" id="update_<?php echo $eId ?>" name="update" value="Update">
                                                        
                                                        <input type="submit" class="del-btn" id="delete_<?php echo $eId ?>" name="delete" value="Delete">       
                                                </div>
                                            </div>
                                        </div>
                                    </form> 
                        
                        <?php   }
                            }   
                        }
                        ?>
                        
                          
                    </div>
                </div>
            </div>
        </div>
        
   </main>
</body>
</html>

<!--$id = $_SESSION['id'];
                                $query = mysqli_query($con, "SELECT * FROM users WHERE Id = $id");
                
                                while($result = mysqli_fetch_assoc($query)){
                                    $res_Uname = $result['Username'];
                                    $res_Email = $result['Email'];
                                    $res_Age = $result['Age'];
                                    $res_Password = $result['Password'];
                                }*/

                            //End-->