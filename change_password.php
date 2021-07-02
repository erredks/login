<?php
    $oldErr = "";
    $matchErr = ""; 
    $showAlert = "";
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    
    else{
        $username = $_SESSION['username'];
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            
            
            include 'control.php';
            
            //to prevent from mysqli injection
            function safe($con,$data){  
                $username = stripcslashes($data);                
                $data = htmlspecialchars($data);
                $username = mysqli_real_escape_string($con, $data);  
                return $data;  
            }

            $opassword = safe($con, $_POST['opassword']);
            $npassword = safe($con, $_POST['npassword']);
            $cpassword = safe($con, $_POST['cpassword']);

            $sql = "select * from user where username = '$username'";
            $result = mysqli_query($con, $sql);  
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
            $num = mysqli_num_rows($result);

            if(md5($opassword) == $row['password']){
                
                if($npassword == $cpassword){
                    
                    if($npassword == ""){
                        $matchErr = "New Password should not be empty....";
                    }
                    else{
                        $encrypted = md5($npassword);
                        $sql = "update `user` SET password = '$encrypted' where username = '$username'";
                        #$sql = "UPDATE `user` SET `password` = '$npassword' WHERE `username` = '$username';";
                        $result = mysqli_query($con, $sql);
                        if($result){
                            $showAlert = true;
                        }
                    }
                }
                else{
                    $matchErr = "Password do not match....";
                }
            }
            else{
                $oldErr = "Please enter correct password...";
            }

        }

    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <title>Dashboard</title>
        <style>
            .error {color: red;}
    </style>
    </head>
    <body>
        <div> <?php require 'dash_nav.php'; ?></div>

        <?php 
            if($showAlert){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Succeess</strong> Your Password hase been Updated successfuly.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
        ?>
            <div class="container">
            <?php echo "<h1><center>Change your Password <br> For user: $username </center></h1>"; ?>
            <?php #echo "email = "?>
            <form action = "change_password.php" method = "post" class = "mt-2">
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Old Password<span class = "error">*</span></label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name = "opassword">
                    <span class="error"> <?php echo $oldErr;?></span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">New Password<span class = "error">*</span></label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name = "npassword">
                    <span class="error"> <?php echo $matchErr;?></span>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name = "cpassword">
                </div>
                <button type="submit" class="btn btn-success">Update passwod</button>
            </form>
             
            <a href ="dashboard.php">cancel</a>
        </div>

    </body>
</html>