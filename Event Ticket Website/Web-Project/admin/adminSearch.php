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
                    <h1 class="head-text">Search Customers Records</h1>

                    <form align="center" name=adminupdate method="post" action="">
                        <div class="search">
                            <h3>Enter ID Below to Find User Information</h3><br>
                            <b>User ID : </b>
                            <input type="text" name="SearchID" size="8" required autocomplete="off">
                            <br><br>
                        </div>
                            <input type="submit" name= "Search" value="Search" class="search-btn">
                            <input type="reset" name="Reset" id="reset" value="Reset" class="search-btn">
                            
                    </form>
                    <div class="return-home">
                        <a href='../adminHome.php'><button class="search-btn">Return Home</button></a>
                    </div>

                    <h2 style="text-align: center;">Details</h2>
                    <div class="user-detail-top">
                    <?php
                    //$conn = new mysqli("localhost", "root", "", "webprog_project");
                    if(isset($_POST['Search'])){    
                        if ($con->connect_error) {
                            die("Connection failed: " . $con->connect_error);
                        }

                        $userIdToViewUpdate = $_POST["SearchID"];

                        // Retrieve user information
                        $userInfoSql = "SELECT * FROM users WHERE id = ?";
                        $userInfoStmt = $con->prepare($userInfoSql);
                        $userInfoStmt->bind_param("i", $userIdToViewUpdate);
                        $userInfoStmt->execute();
                        $userInfoResult = $userInfoStmt->get_result();

                        if ($userInfoResult->num_rows > 0) {
                            $userInfo = $userInfoResult->fetch_assoc();

                            // Display user information for viewing?>
                            
                            <div class='user-detail-title'>
                                <?php echo "User Information:<br>";?>
                            </div>
                            <div class= 'user-detail'>
                                
                            <table>
                                <tr>
                                    <td class="box1">User ID : </td>
                                    <td><?php echo $userInfo["Id"];?></td>
                                </tr>
                                <tr>
                                    <td class="box1">Username : </td>
                                    <td><?php echo $userInfo["Username"];?></td>
                                </tr>
                                <tr>
                                    <td class="box1">Email : </td>
                                    <td><?php echo $userInfo["Email"];?></td>
                                </tr>
                                <tr>
                                    <td class="box1">Password : </td>
                                    <td><?php echo $userInfo["Password"];?></td>
                                </tr>
                                <tr>
                                    <td class="box1">Age : </td>
                                    <td><?php echo $userInfo["Age"];?></td>
                                </tr>
                                <tr>
                                    <td class="box1">Roles : </td>
                                    <td><?php echo $userInfo["Admin"];?></td>
                                </tr>   
                            </table>
                            </div>
                            <?php

                            /*// Display form for updating user information
                            echo "<h2>Update User Information</h2>";
                            echo "<form action='update_user.php' method='post'>";
                            echo "Id:  " . $userInfo["Id"];
                            echo "<input type='hidden' name='user_id_to_update' value='" . $userInfo["Id"] . "'><br>";
                            echo "<label for='username_to_update'>Username:</label>";
                            echo "<input type='text' name='username_to_update' value='" . $userInfo["Username"] . "'><br>";
                            echo "<label for='Email_to_update'>Email:</label>";
                            echo "<input type='text' name='Email_to_update' value='" . $userInfo["Email"] . "'><br>";
                            echo "<label for='password_to_update'>Password:</label>";
                            echo "<input type='text' name='password_to_update' value='" . $userInfo["Password"] . "'><br>";
                            echo "<label for='age_to_update'>Age:</label>";
                            echo "<input type='text' name='age_to_update' value='" . $userInfo["Age"] . "'><br>";
                            echo "<label for='new_admin_status'>Admin Status:</label>";
                            echo "<input type='text' name='new_admin_status' value='" . $userInfo["Admin"] . "' required><br>";
                            echo "<button type='submit'>Update User Information</button>";
                            echo "</form>";*/
                        } else {
                            echo "<div style='padding-left: 430px;'> User not found.</div>";
                            
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>