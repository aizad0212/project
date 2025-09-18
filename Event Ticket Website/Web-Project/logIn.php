<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>

    <link rel="stylesheet" href="css/style2.css">
</head>
<body class="front-page">
    <div class="container">
        <div class="box form-box">

        <?php
            include("php/config.php");

            if(isset($_POST['submit'])){
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                $result = mysqli_query($con, "SELECT * FROM users WHERE Username = '$username' AND Password = '$password'") or die("Select Error");
                $row = mysqli_fetch_assoc($result);

                if(is_array($row) && !empty($row)){
                    $_SESSION['valid'] = $row['Username'];
                    $_SESSION['email'] = $row['Email'];
                    $_SESSION['age'] = $row['Age'];
                    $_SESSION['id'] = $row['Id'];

                    // Check if the user is an administrator
                    if ($row['Admin'] == 1) {
                        $_SESSION['admin'] = true;
                    }

                }

                else{
                    echo "<div class= message>
                            <p>Wrong Username or Password</p>
                          </div> <br>";
                    echo "<a href='logIn.php'><button class='btn'>Go Back</button></a>";
                }

                if(isset($_SESSION['valid'])){
                    
                    if(isset($_SESSION['admin'])) {
                        header("Location: adminHome.php"); // Redirect to admin panel
                    }
                    else{
                        header("Location: home.php");   //Redirect to user panel
                    }
                }
            }else{

        ?>

            <header>Log In</header>
            <form action="" method="post">
                   
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Log In" required>
                </div>

                <div class="links">
                    Don't have account? <a href="register.php">Sign Up</a>
                </div>
            </form>
        </div>

        <?php
            }
        ?>

    </div>
    
</body>
</html>