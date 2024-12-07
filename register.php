<?php

include 'config.php';

if(isset($_POST['submit'])){
    $name  = mysqli_real_escape_string($conn , $_POST['name']);
    $email = mysqli_real_escape_string($conn , $_POST['email']);
    $pass  = mysqli_real_escape_string($conn , md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn , md5($_POST['cpassword']));
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;




    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $message[] = 'user already exist';
    }else{
        if($pass != $cpass){
            $message[] = 'confirm passsword not matched!';
        }elseif($image_size > 2000000){
            $message[] = 'Image size is too large! Max size: 2MB';
        }else{
            $insert = mysqli_query($conn, "INSERT INTO `user_form`(name,email,password,image) VALUES('$name','$email','$pass','$image')") or die('query failed'); 
            if($insert){
                move_uploaded_file($image_tmp_name,$image_folder);
                $message[] = 'registered successfully!';
                header('location:login.php');
            }else{
                $message[] = 'registeration faild!';

            }
        }
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <form action="" method='POST' enctype='multipart/form-data'>
            <h3>Register Now</h3>
            <?php 
                if(isset($message)){
                    foreach($message as $msg){
                        echo '<div class="message">' . $msg . '</div>';
                    }
                }

            ?>
            <input type="text" placeholder='Enter Your Username' name='name' require class='box'>
            <input type="email" placeholder='Enter Your Email' name='email' require class='box'>
            <input type="password" placeholder='Enter Your Password' name='password' require class='box'>
            <input type="password" placeholder='Confirm Your Password' name='cpassword' require class='box'>
            <input type="file" name='image' accept='image/jpg, image/jpeg, image/png' require class='box'>
            <input type="submit" name='submit' value="Register Now" class='btn'>
            <p>Aleready Have An Account? <a href="login.php">Login Now</a></p>
        </form>
    </div>

</body>
</html>