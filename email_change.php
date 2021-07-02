<?php
    session_start();
        
    $token = $_GET['token'];
    $email = $_GET['email'];

    include 'control.php';

    $sql = "select * from `user` where `email` = '$email'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);

    if($num >0){
        echo "your Email '$email' has already been updated... please login now";
    }
    else{    
        $sql = "update `user` set `email` = '$email' where `token` = '$token'";
        $result2 = mysqli_query($con, $sql);
        #$row = mysqli_fetch_assoc($result2);
        #$email = $row['email'];

        if($result2){
            #$_SESSION['msg'] = 'Account created successfully ';
            #header("location: login.php");
            echo "your email has been updated successfully, Please login Again";

            session_destroy();

        }
        else{
            #$_SESSION['start'] = true;
            #$_SESSION['msg'] = 'Account not created';
            #header("location: login.php");
            echo "Email updation failed, Please login Again";

            session_destroy();
        }
    }



?>