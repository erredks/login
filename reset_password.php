<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php
            include_once "control.php";
            if(isset($_POST['submit'])){

                if(isset($_GET['token'])){
                    $token = $_GET['token'];

                    $password = mysqli_real_escape_string($con, $_POST['password']);
                    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

                    $pass = md5($password);

                    if ($password==$cpassword) {
                        $updatesql= "UPDATE `user` SET `password` = '$pass' WHERE `token` = '$token'";
                        $updatequery = mysqli_query($con, $updatesql);

                        if($updatequery){
                            $_SESSION['msg'] = "Your password has been updated";
                            header("location:login.php");
                        }
                        else{
                            $_SESSION['msg'] = "update error";
                            header("location:reset_password.php?token=$token");
                        }
                    }

                    else
                    {
                        $err = "Password does'nt match";
                    }
                }
                else{
                    $err = "Invalid Token";
                }
        }


    ?>
        
        <form action="" method="POST" style="border:1px solid #ccc">
            <div class="container">
                <h1>Reset Password</h1>
                <p>Please fill in this form to reset password.</p>

                <!-- error msg -->
                <p style=background-color:red;><?php 
                    if(isset($err)){
                        echo $err;
                    }
                ?>
                </p>
                <hr>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" >

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="cpassword" >


                <div class="clearfix">
                    <button type="submit" name="submit" class="signupbtn">Reset</button>
                </div>
                <p>Have an account? <a href='login.php'>Login</a></p>
        </div>
        </form>

    </body>
</html>

