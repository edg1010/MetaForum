<?php

include 'config.php';

if (!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    if(!filter_var($username, FILTER_VALIDATE_EMAIL)){
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows < 1){
            $username_error = "Username does not exist";
            $username_flag = 0;
        }else{
            $username_error = "";
            $username_flag = 1;
        }
        
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows < 1){
            $password_error = "Invalid password";
            $password_flag = 0;
        }else{
            $password_error = "";
            $password_flag = 1;
        }
    }else{
        $sql = "SELECT * FROM users WHERE email = '$username'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows < 1){
            $username_error = "E-mail is not associated with an account";
            $username_flag = 0;
        }else{
            $username_error = "";
            $username_flag = 1;
        }

        $sql = "SELECT * FROM users WHERE email = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);
        if($result->num_rows < 1){
            $password_error = "Invalid password";
            $password_flag = 0;
        }else{
            $password_error = "";
            $password_flag = 1;
        }
    }

    if($username_flag == 1 && $password_flag == 1){
        $sql = "SELECT * FROM users WHERE email = '$username' OR username = '$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");
    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
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
        <form action="login.php" method="POST" autocomplete="off">
            <label for="">Email or Username</label>
            <br>
            <input type="text" name="username" id="" value="<?php if(isset($username)) echo $username ?>">
            <br>
            <p class="failedtxt" id="usernametxt" style="margin-bottom: 10px; font-size: 12px; color: hsl(358deg 68% 59%);">
            <?php if(isset($username_error)) echo $username_error; ?>
            </p>
            <div style="margin-bottom: 10px;"></div>
            <label for="">Password</label>
            <br>
            <input type="password" name="password" id="" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>">
            <br>
            <p class="failedtxt" id="usernametxt" style="margin-bottom: 10px; font-size: 12px; color: hsl(358deg 68% 59%);">
            <?php if(isset($password_error)) echo $password_error; ?>
            </p>
            <div style="margin-bottom: 10px;"></div>
            <button name="submit" type="submit" style="width: 100%;">Log in</button>
            <a href="accountrecovery.php" style="font-size: 12px;">Forgot password?</a>
        </form>
    </div>
    <br>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</body>
<script>
    if( window.history.replaceState){
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>