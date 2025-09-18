<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link rel="stylesheet" href="css/style2.css">
</head>
<body class="front-page">
    <div class="container">
        <div class="box form-box">
            
        <?php
            include("php/config.php");

            if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];
                $password = $_POST['password'];
                $cPassword = $_POST['cPassword'];

                //Verifying the Password
                if($password != $cPassword){
                    echo "<div class= message>
                            <p>The Password doesn't match</p>
                          </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                }

                else{
                    //Verifying the unique email & username
                    $verify_query = mysqli_query($con, "SELECT email FROM users WHERE Email='$email' OR Username='$username'");

                    if(mysqli_num_rows($verify_query) != 0){
                        echo "<div class= message>
                                <p>This user already exists, Please change your Username or Email</p>
                            </div> <br>";
                        echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                            
                    }

                    else{
                        mysqli_query($con, "INSERT INTO users (username, email, age, password) VALUES ('$username', '$email', '$age', '$password')") or die("Error Occured");
                        echo "<div class='message'>
                                <p>Registration Successfull !</p>
                            </div> <br>";
                        echo "<a href='logIn.php'><button class='btn'> Log In </button></a>";
                    }

            }
        }else{
        ?>
            
            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>
    
                <div class="field input">
                    <label for="cPassword">Password Confirmation</label>
                    <input type="password" name="cPassword" id="cPassword" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register" required>
                </div>

                <div class="links">
                    Already have an account? <a href="logIn.php">Sign In</a>
                </div>
            </form>
        </div>

        <?php
            }
        ?>

    </div>
    
</body>
</html>