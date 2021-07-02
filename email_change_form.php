<?php       
    $emailErr= "";
    session_start();
    

    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: login.php");
        exit;
    }
    else{

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            include 'control.php';
            
            $email = $_POST['email'];
            #logic to change email only
            
            # Email validation
            if (empty( $email )) {
                $emailErr = "Email is required";
            }
            else {
                // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $emailErr = "Invalid email format";
                }
                else{
                    
                    # checking if mail is already existing
                    $sql = "select * from user where email = '$email'";
                    $result = mysqli_query($con, $sql);
                    $num = mysqli_num_rows($result);
                    
                    if($num != 0 ){
                        $emailErr = "email already Exist";
                    }
                    else{
                        $username = $_SESSION['username'];
                        $sql = "select * from `user` where `username` = '$username' ";
                        
                        $result = mysqli_query($con, $sql);
                        $num = mysqli_num_rows($result);
                        $row = mysqli_fetch_assoc($result);
                        $token = $row['token'];
                        
                        $name = $row['name'];
                        $token = $row['token'];
                        if($num>0){

                            $to_email = "digvijayk723@gmail.com";
                            $subject = "Change Email $name";
                            $body = "To change your email click or below link
                            http://localhost/demo//login/email_change.php?token=$token&email=$email";
                            $headers = "From: digvijay.kumar@gingerwebs.co.in";
                            
                            if (mail($to_email, $subject, $body, $headers)) {
                                echo "Request has been send to $to_email to change Email";
                            } else {
                                echo "Email sending failed...";
                            }
                        }
                    }
                }
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Change Email</title>
</head>
<body>
    <div> <?php require 'dash_nav.php'; ?> </div>

    <div class="container">

    <form action = "email_change_form.php" method = "post" class = "mt-2">
    <div class="mb-2">
        Enter your New Email..</br>
        <label for="exampleInputEmail1" class="form-label">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name  = 'email'>
        <span style = " color: red"><?php echo $emailErr."</br>";?></span>
        <small>We'll never share your password</small>
    </div>
    
    
    <button type="submit" class="btn btn-success">Submit</button> 
    
    </form>
    
    </div>
</body>
</html>