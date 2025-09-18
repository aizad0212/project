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

                //echo "<a href='adminEdit_profile.php?Id=$res_id' style='text-decoration:none; margin-right:25px; color:#f5f5f5;'>Change Profile</a>";
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
                <!--<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>-->
                    <p class="head-text">Update Function</p>
                    <div class="admin-box">

                        <div class="admin-func">
                                <a href="adminUpdateUser.php"><button>
                                    <span class="fIcon"><i class="fa-solid fa-people-group"></i></span><br><br>
                                    Update Users
                                </button></a>
                        </div>

                        <div class="admin-func">
                                <a href="adminUpdateEvent.php"><button>
                                    <span class="fIcon"><i class="fa-solid fa-calendar-days"></i></span><br><br>
                                    Update Events
                                </button></a>
                        </div>

                        <div class="admin-func">
                                <a href="adminUpdateEntry.php"><button>
                                    <span class="fIcon"><i class="fa-solid fa-right-to-bracket"></i></span><br><br>
                                    Update Entry
                                </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </main>
</body>
</html>