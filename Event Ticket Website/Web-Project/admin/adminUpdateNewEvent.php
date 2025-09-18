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
                        <?php
                        //INSERT
                        if(isset($_POST['new'])){
                                $Time = $_POST['inTime'];
                                $Title = $_POST['inTitle'];
                                $Venue = $_POST['inVenue'];
                                $Desc = $_POST['inDescription'];
                                $Lim = $_POST['inLimitation'];
            
                                $verify_query = mysqli_query($con, "SELECT title FROM events WHERE Title='$Title' OR Time='$Time'");
            
                                if(mysqli_num_rows($verify_query) != 0){
                                    echo "<div class= message>
                                            <p>This event already exists</p>
                                        </div> <br>";
                                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                                        
                                }
            
                                else{
                                    $rev = mysqli_query($con, "INSERT INTO events (time, title, venue, description, limitation) VALUES ('$Time', '$Title', '$Venue', '$Desc', '$Lim')") or die("Error Occured - Insert");
                                    if($rev){
                                        echo "<div class='message'>
                                                <p>Event Registration Successfull !</p>
                                            </div> <br>";
                                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                                    }
                                    else{
                                        echo "<div class='message'>
                                            <p>Error Inserting Data !</p>
                                            </div> <br>";
                                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                                    }
                                }
            
                            
                        }

                        ?>

                        <form action="" method="post">
                            <div class="list">
                                <div class="check">
                                    <i class="fa-solid fa-music"></i>   
                                    <i class="fa-solid fa-circle-check"></i>
                                    
                                        <h2><input type="date" name="inTime" id="date" value="" placeholder="Date"></h2>
                                   
                                </div>
                                <div class="detail">
                                    
                                        <h2><input type="text" name="inTitle" id="title" value="" placeholder="Title"></h2>
                                        <b><input type="text" name="inVenue" id="venue" value="" placeholder="Venue"></b>
                                        <p><textarea name="inDescription" id="desc" cols="100" rows="10" value="" placeholder="Description"></textarea></p>
                                        <p><input type="number" name="inLimitation" id="limit" value="" placeholder="Max Participants"></p>
                                    

                                    <div class="regis">
                                            <input type="submit" class="register-btn" name="new" value="New">
                                                    
                                    </div>
                                </div>
                            </div>
                        </form> 
                        <a href="adminUpdateEvent.php"><button class="btn" style="float: right; margin-right: 23px;">Go Back</button></a>  
                    </div>
                </div>
            </div>
        </div>
        
   </main>
</body>
</html>