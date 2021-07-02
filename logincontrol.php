<?php  
    if($_SERVER["REQUEST_METHOD"] == "POST"){    
        include 'control.php' ;  
        
        $username = $_POST['username'];  
        $password = $_POST['password'];  
        
            //to prevent from mysqli injection  
            
            function safe($con,$data){  
                $username = stripcslashes($data);  
                $username = mysqli_real_escape_string($con, $data);  
                return $data;  
            }
            
            $username = safe($con, $username); 
            $password = safe($con, $password);
            



            // encrypting password
            $checkpassword = md5($password);
            $sql = "select * from user where username = '$username' and password = '$checkpassword' ";  
            $result = mysqli_query($con, $sql);  
            $num = mysqli_num_rows($result);  
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
            
            if($num == 1){
                $sql = "select * from user where username = '$username' and `status` = 'active' ";  
                $result1 = mysqli_query($con, $sql);  
                $row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);  
                $num1 = mysqli_num_rows($result1);
                if($num1 == 1){  
                    #echo "<h1><center>Hello ". $row['username'] ." <br> Login successful </center></h1>";
                    session_start();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['username'] = $username;
                    #$_SESSION['name'] = $row['name'];
                    header("location: dashboard.php",);
                }
                else{
                    echo "your Email account is not varified... please varify your account First";
                }  
            }  
            else{  
                echo "<h1> Login failed. Invalid username or password.</h1>";  
                
            }
        
    }

?> 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" 
        rel="stylesheet" 
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" 
        crossorigin="anonymous">
    </head>
    <body >
        <div> <?php require 'nav.php'; ?></div>

        <center><input class = "btn btn-success" type="submit" value="GO BACK" onclick = " location.href = 'login.php'"> </center>
        
    </body>
</html>


