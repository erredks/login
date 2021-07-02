<?php

    session_start();
    
    $token = $_GET['token'];

    include 'control.php';
        
    $sql = "select * from `user` where `token` = '$token' and status = 'active'";
    $result1 = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result1);

    if($num == 1 ){
        $_SESSION['msg'] = 'Your account is already activated';
        header("location: login.php");
    }    
    else{

            $sql = "update `user` set `status` = 'active' where `token` = '$token'";
            $result2 = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($result2);
            $email = $row['email'];

            if($result2){
                $_SESSION['msg'] = 'Account created successfully ';
                header("location: login.php");
            }
            else{
                $_SESSION['start'] = true;
                $_SESSION['msg'] = 'Account not created';
                header("location: login.php");
            }
    }

?>