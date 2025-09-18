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
                    <h1 class="head-text">Update Participant Records</h1>
                    <p class="head-des">Table Name : Entry</p>
                    <?php
                    //UPDATE
                        
                        if(isset($_POST['update'])){
                            $userID = $_POST['upUid'];
                            $eventID = $_POST['upEid'];
                            $register = $_POST['upReg'];
                //PROBLEM Event_Id
                            $entryID = $_POST['id'];
            
                            $changeEntry_query = mysqli_query($con, "UPDATE entry SET `User_Id`='$userID',`Event_Id`='$eventID',`Register`='$register' WHERE Entry_Id='$entryID'") or die("Error Occured - Update");
        
                            if($changeEntry_query){
                                echo "<div class='message'>
                                        <p>Data Have Been Updated !</p>
                                    </div> <br>";
                                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                            }
                            
                            
                        } 
                            
                        else{
                            //$id = $_SESSION['Event_Id'];
                            $eventQuery = "SELECT * FROM entry /*WHERE Event_Id = $id*/";
                            $eventResult = mysqli_query($con, $eventQuery);
                            $eventResultCheck = mysqli_num_rows($eventResult);

                            //DELETE
                            if(isset($_POST['delete'])){

                                $userID = $_POST['upUid'];
                                $eventID = $_POST['upEid'];
                                $register = $_POST['upReg'];
                    //PROBLEM Event_Id
                                $entryID = $_POST['id'];

                                //Validation for Entry - Delete
                                    
                                $entryQueryIn = "DELETE FROM entry WHERE Entry_Id='$entryID'";
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
                                    $rec_Uid = $row['User_Id'];
                                    $rec_Eid = $row['Event_Id'];
                                    $rec_Reg = $row['Register'];

                                    $rec_Entryid = $row['Entry_Id'];

                                    //Validation - Admin or not
                                    if($rec_Reg == 1){
                                        $regi = "User Register";
                                    }

                                    else{
                                        $regi = "Not Register"; 
                                    }
                                    
                        ?>
                                    <form action="" method="post">
                                        <div class="list">
                                            <div class="id-user">

                                                    <label for="">Entry ID</label><br>
                                                    <input type="text" name="id" id="id" value="<?php echo $rec_Entryid ?>" readonly>
                                                    <!--<h2><input type="date" name="upTime" id="date" value="</?php echo $eTime ?>"></h2>-->
                                                
                                            </div>
                                            <div class="detail">
                                                
                                                <label for="">User ID :</label>    
                                                <input type="text" name="upUid" id="UPuid" value="<?php echo $rec_Uid ?>"><br>
                                                
                                                <label for="">Event ID :</label>
                                                <input type="number" name="upEid" id="UPeid" value="<?php echo $rec_Eid ?>"><br>

                                                <label for="">Register :</label>
                                                <input type="text" name="upReg" id="UPreg" value="<?php echo $rec_Reg?>"> <?php echo $regi?>
                                                

                                                <div class="regis">
                                                    
                                                        <input type="submit" class="register-btn" id="update_<?php echo $rec_Entryid ?>" name="update" value="Update">
                                                        
                                                        <input type="submit" class="del-btn" id="delete_<?php echo $rec_Entryid ?>" name="delete" value="Delete">       
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