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
    <title>Admin</title>

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

                //echo "<a href='edit_profile.php?Id=$res_id'>Change Profile</a>";
            ?>

            <!--<a href="#">Edit Profile</a>-->
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
                    <h1 class="head-text">Update User Records</h1>
                    <p class="head-des" >Table Name : Users</p>
                    <?php
                    //UPDATE
                        
                        if(isset($_POST['update'])){
                            $Uname = $_POST['upUname'];
                            $Email = $_POST['upEmail'];
                            $Age = $_POST['upAge'];
                            $Pass = $_POST['upPass'];
                            $Role = $_POST['upRole'];
                //PROBLEM Event_Id
                            $ID = $_POST['id'];
            
                            $changeUser_query = mysqli_query($con, "UPDATE users SET `Username`='$Uname',`Email`='$Email',`Age`='$Age',`Password`='$Pass',`Admin`= '$Role' WHERE Id='$ID'") or die("Error Occured - Update");
        
                            if($changeUser_query){
                                echo "<div class='message'>
                                        <p>Data Have Been Updated !</p>
                                    </div> <br>";
                                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                            }
                            
                            
                        } 
                            
                        else{
                            //$id = $_SESSION['Event_Id'];
                            $eventQuery = "SELECT * FROM users /*WHERE Event_Id = $id*/";
                            $eventResult = mysqli_query($con, $eventQuery);
                            $eventResultCheck = mysqli_num_rows($eventResult);

                            //DELETE
                            if(isset($_POST['delete'])){

                                $Uname = $_POST['upUname'];
                                $Email = $_POST['upEmail'];
                                $Age = $_POST['upAge'];
                                $Pass = $_POST['upPass'];
                                $Role = $_POST['upRole'];
                //PROBLEM Event_Id
                                $ID = $_POST['id'];

                                //Validation for Entry - Delete
                                    
                                $entryQueryIn = "DELETE FROM users WHERE Id='$ID'";
                                $entryResult = mysqli_query($con, $entryQueryIn);

                                if($entryResult){
                                    
                                    echo"<div class=pop-up id=popup>
                                            <img src='../img/circle-trash.png'>
                                            <h2>Delete Successfull</h2>
                                            <p>Hope to see you again in The Next Event!</p>
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
                                    $rec_Uname = $row['Username'];
                                    $rec_Email = $row['Email'];
                                    $rec_Age = $row['Age'];
                                    $rec_Pass = $row['Password'];
                                    $rec_Role = $row['Admin'];

                                    $rec_Uid = $row['Id'];

                                    //Validation - Admin or not
                                    if($rec_Role == 1){
                                        $role = "Admin Level User";
                                    }

                                    else{
                                        $role = "Normal Level User"; 
                                    }
                                    
                        ?>
                                    <form action="" method="post">
                                        <div class="list">
                                            <div class="id-user">

                                                    <label for="">User ID</label><br>
                                                    <input type="text" name="id" id="id" value="<?php echo $rec_Uid ?>" readonly>
                                                    <!--<h2><input type="date" name="upTime" id="date" value="</?php echo $eTime ?>"></h2>-->
                                                
                                            </div>
                                            <div class="detail">
                                                
                                                <label for="">Username :</label>    
                                                <input type="text" name="upUname" id="UPusername" value="<?php echo $rec_Uname ?>"><br>
                                                
                                                <label for="">Email :</label>
                                                <input type="text" name="upEmail" id="UPemail" value="<?php echo $rec_Email ?>"><br>
                                                
                                                <label for="">Age :</label>
                                                <input type="number" name="upAge" id="UPage" value="<?php echo $rec_Age ?>"><br>
                                                
                                                <label for="">Password :</label>
                                                <input type="text" name="upPass" id="UPpassword" value="<?php echo $rec_Pass?>"><br>

                                                <label for="">Role :</label>
                                                <input type="text" name="upRole" id="UProle" value="<?php echo $rec_Role?>"> <?php echo $role?>
                                                

                                                <div class="regis">
                                                    
                                                        <input type="submit" class="register-btn" id="update_<?php echo $rec_Uid ?>" name="update" value="Update">
                                                        
                                                        <input type="submit" class="del-btn" id="delete_<?php echo $rec_Uid ?>" name="delete" value="Delete">       
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