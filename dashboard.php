<?php 
    session_start();

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    $username = $_SESSION['username'];
    
    include 'control.php' ;
    $sql = "select * from user where username = '$username'";
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $num = mysqli_num_rows($result);



?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <title>Dashboard</title>
    </head>
    <body>
        <div> <?php require 'dash_nav.php'; ?> </div>
        <?php echo "<h1><center>Hello ". $row['name'] ." <br> Login successful </center></h1>"; ?>
        <?php #echo "email = "?>
        <h1><center> Welcome To Dashboard</center></h1>

        <center><button name = 'logout' onclick= "location.href ='logout.php'" class = "mt-4 btn btn-primary"> logout</button></center>
    </body>
</html>