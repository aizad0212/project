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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                        <h1 class="head-text">View Event Records</h1>
                        <p class="head-des" >Table Name : Events</p>

                        <!--<a href="adminUpdateNewEvent.php"><button class="btn" style="margin-left:44%; margin-bottom:10px">+ New Event</button></a>-->
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
                                        <div>
                                            <div class="check" style="width:13%; margin-left:15px;">
                                                
                                                Event ID : <b><?php echo $eId ?></b>
                                                                                                  
                                            </div>
                                            <!-- Using Bootstrap Card Component -->
                                            <div class="card cards mb-3" style="max-width: 100%;">
                                                <div class="card-body" >
                                                    <h5 class="card-title"><?php echo $eTitle ?><span style="float:right;"><?php echo $eTime ?></span></h5>
                                                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $eVenue ?></h6>

                                                    <p class="card-text"><?php echo $eDesc ?></p>
                                                    <p class="card-text">Max: <?php echo $eLimit ?> participants</p>
                                                </div>
                                            </div>
                                        </div>
                        
                        <?php   }
                            }   
                        
                        ?>
                        
                          
                    </div>
                </div>
            </div>
        </div>
        
   </main>
</body>
</html>