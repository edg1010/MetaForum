<?php

include 'config.php';

if (!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $email_error = "";

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if(empty($email)){
        $email_error = "Invalid e-mail format";
        $email_flag = 0;
    }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $email_error = "Invalid e-mail format";
        $email_flag = 0;
    }else if($result->num_rows > 0){
        $email_error = "E-mail has been used";
        $email_flag = 0;
    }else{
        $email_error = "";
        $email_flag = 1;
    }

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if(empty($username)){
        $username_error = "Username must be between 6 and 20 characters long";
        $username_flag = 0;
    }else if(strlen($username) < 6 || strlen($username) > 20){
        $username_error = "Username must be between 6 and 20 characters long";
        $username_flag = 0;
    }else if(preg_match('/[^a-z_\-0-9]/i', $username)){
        $username_error = "Username must only contain alphanumeric characters";
        $username_flag = 0;
    }else if($result->num_rows > 0){
        $username_error = "Username already exist";
        $username_flag = 0;
    }else{
        $username_error = "";
        $username_flag = 1;
    }

    if(strlen($password) < 8){
        $password_error = "Password must be at least 8 characters long";
        $password_flag = 0;
    }else{
        $password_error = "";
        $password_flag = 1;
    }

    if($password != $cpassword){
        $cpassword_error = "Please correctly confirm the password";
        $cpassword_flag = 0;
    }else{
        $cpassword_error = "";
        $cpassword_flag = 1;
    }

    if($username_flag == 1 && $email_flag == 1 && $password_flag == 1 && $cpassword_flag == 1){
        $passwordd = md5($_POST['password']);
        $sql = "INSERT INTO users (email, username, password, roleid) VALUES ('$email', '$username', '$passwordd', 1)";
        $result = mysqli_query($conn, $sql);
        $secret = "35onoi2=-7#%g03kl";
        $email = urlencode($_POST['email']);
        $hash = MD5($_POST['email'].$secret);
        $link = "verify.php?email=$email&hash=$hash";
        mail("$email","Verification Link",$link);
        header("Location: login.php");
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?ver=1.1">
</head>
<body>
    <div class="border-bottom" style="background: #fff;">
        <div class="ms-auto me-auto" style="max-width: 1200px;">
            <div class="d-flex justify-content-between align-items-center ms-3 me-3 " style="background: #fff;">
                <div class="login-register-button me-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($display)) echo $display; ?>">
                    <a class="" style="color: var(--black-600);" href="login.php">Log in</a>
                </div>
                <a class="logo" href="index.php">
                    <div class="mt-2 mb-2">
                        <img src="assets/image/logo.png" alt="" style="height: 50px;">
                    </div>
                </a>
                <div class="login-register-button ms-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($display)) echo $display; ?>">
                    <a style="color: var(--black-600);" href="signup.php">Sign up</a>
                </div>
            </div>
        </div>
    </div>
    <div class="box ms-auto me-auto mt-5">
        <form action="signup.php" method="POST" autocomplete="off">
            <label for="">Email</label>
            <br>
            <input class="" type="text" name="email" id="email" value="<?php if(isset($email)) echo $email ?>">
            <br>
            <p class="failedtxt" id="emailtxt" style="margin-bottom: 10px; font-size: 12px; color: hsl(358deg 68% 59%);">
            <?php if(isset($email_error)) echo $email_error; ?>
            </p>
            <label for="">Username</label>
            <br>
            <input class="" type="text" name="username" id="username" value="<?php if(isset($username)) echo $username ?>">
            <br>
            <p class="failedtxt" id="usernametxt" style="margin-bottom: 10px; font-size: 12px; color: hsl(358deg 68% 59%);">
            <?php if(isset($username_error)) echo $username_error; ?>
            </p>
            <label for="">Password</label>
            <br>
            <input class="" type="password" name="password" id="password" value="<?php if(isset($password)) echo $password ?>">
            <br>
            <p class="failedtxt" id="passwordtxt" style="margin-bottom: 10px; font-size: 12px; color: hsl(358deg 68% 59%);">
            <?php if(isset($password_error)) echo $password_error; ?>
            </p>
            <label for="">Confirm Password</label>
            <br>
            <input class="" type="password" name="cpassword" id="cpassword" value="<?php if(isset($cpassword)) echo $cpassword ?>">
            <br>
            <p class="failedtxt" id="cpasswordtxt" style="margin-bottom: 10px; font-size: 12px; color: hsl(358deg 68% 59%);">
            <?php if(isset($cpassword_error)) echo $cpassword_error; ?>
            </p>
            <!-- <input type="text" id="rows" value="<?php if(isset($rows)) echo $rows; ?>"> -->
            <button name="submit" type="submit" style="width: 100%;">Sign up</button>
            
        </form>
    </div>
    <br>
</body>
<script>
    if( window.history.replaceState){
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>