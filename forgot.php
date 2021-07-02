<?php

    $emailErr = "";
    if($_SERVER['REQUEST_METHOD']=="POST"){

        include 'control.php';

        $email = $_POST['email'];

        if (empty( $email )) {
            $emailErr = "Email is required";
            }
        else {
            #$email = safe($con, $email);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
            else{

                $sql = "select * from `user` where `email` = '$email' ";
                #echo $sql;
                $result = mysqli_query($con, $sql);
                $num = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);

                if($num != 1){

                    $emailErr = "$email is not registered, please signup First";        

                }
                else{
                    $name = $row['name'];
                    $token = $row['token'];
                    $to_email = "digvijayk723@gmail.com";
                    $subject = "Forgot password $name";
                    $body = "To change your pass click or below link
                            http://localhost/demo//login/reset_password.php?token=$token";
                    $headers = "From: digvijay.kumar@gingerwebs.co.in";
                    
                    if (mail($to_email, $subject, $body, $headers)) {
                        echo "Email successfully sent to $to_email...";
                    } else {
                        echo "Email sending failed...";
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>Forgot password</title>
    <style>
        .error {color: red;}
    </style>

</head>
<body>
    <div class="container">
        <h2> Enter Email address of which you want to change password</h2>
        <form action = "forgot.php" method = "POST" class = "mt-2">

            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address<span class = "error">*</span></label>
                <input type="text" class="form-control" name = "email">
                <!--  if Email is invalid-->
                <span class="error"> <?php echo $emailErr;?></span>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <input class = "btn btn-success" type="submit" value="Submit">

            <a href = "login.php">Cancel</a>

        </form>
        

    </div>
</body>
</html>