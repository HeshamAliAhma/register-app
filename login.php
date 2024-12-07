<?php

include 'config.php';
session_start();
if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn , $_POST['email']);
    $pass  = mysqli_real_escape_string($conn , md5($_POST['password']));



    $select = mysqli_query($conn, "SELECT * FROM `user_form` where email = '$email' AND password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    }else{
        $message[] = 'incorrect email or password!';

    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method='POST' enctype='multipart/form-data'>
            <h3>Login Now</h3>
            <?php 
            if(isset($message)){
                foreach($message as $msg){
                    echo '<div class="message">' . $msg . '</div>';
                }
            }

            ?>
            <input type="email" placeholder='Enter Your Email' name='email' require class='box'>
            <input type="password" placeholder='Enter Your Password' name='password' require class='box'>
            <input type="submit" name='submit' value="Login Now" class='btn'>
            <p>Don't Have An Account? <a href="register.php">Register Now</a></p>
        </form>
    </div>

</body>
</html>