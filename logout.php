<?php
    $logout = false;
    
    session_start();

    #session_unset();
    session_destroy();

    session_start();
    $_SESSION['msg'] = "you are logged out";
    header("location: login.php");
    exit;
?>