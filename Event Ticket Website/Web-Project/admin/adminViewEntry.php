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
                    <h1 class="head-text">View Participant Records</h1>
                    <p class="head-des" >Table Name : Entry</p>
                    <?php
                    
                            $Query = "SELECT * FROM entry";
                            $Result = mysqli_query($con, $Query);
                            $ResultCheck = mysqli_num_rows($Result);
                            
                            if($ResultCheck > 0){
                                while($row = mysqli_fetch_assoc($Result)){
                                    $rec_Uid = $row['User_Id'];
                                    $rec_Eid = $row['Event_Id'];
                                    $rec_Reg = $row['Register'];
                                    $rec_Entryid = $row['Entry_Id'];                           
                        
                                    //Validation - Register or not
                                    if($rec_Reg == 1){
                                        $role = "Register";
                                    }

                                    else{
                                        $role = "Unregister"; 
                                    }
                                    
                        ?>
                                    <form action="" method="post" name="">
                                        <div class="list list-view">
                                            <div class="id-user">

                                                    Entry ID<br>
                                                    <b><?php echo $rec_Entryid ?></b>
                                                    
                                                
                                            </div>
                                            <div class="detail" style="padding-bottom:10px;">
                                                
                                                <table width=100%>
                                                    <tr>
                                                        <td class="box1">User ID : </td>
                                                        <td><?php echo $rec_Uid ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="box1">Event ID : </td>
                                                        <td><?php echo $rec_Eid ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="box1" rowspan="2">Register : </td>
                                                        <td><?php echo $rec_Reg ?><span style="margin-left:15px;">[<?php echo $role?></span>]</td>
                                                    </tr>
                                                    
                                                                                                    
                                                </table>
                                                
                                            </div>
                                        </div>
                                    </form> 
                        
                        <?php
                            }   
                        }
                        ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>