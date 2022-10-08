<?php

include 'config.php';

if (!isset($_SESSION)) {
    session_start();
}

$postid = $_GET["id"];
$displays = "d-none";
// $link = "login.php";
$width = 88;
$users = $_SESSION['username'];

$sql = "SELECT * FROM users where username = '$users'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
    $userid = $row["userid"];
}

if(isset($_SESSION['username'])){
    $display = "d-none";
    $displays = "d-block";
    $link = "post.php";
    $width = 75;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="border-bottom fixed-top " style="background: #fff; z-index: 30;">
    <div class="ms-auto me-auto" style="max-width: 1200px;">
        <div class="d-flex justify-content-between align-items-center ms-3 me-3 " style="background: #fff;">
            <div class="login-register-button me-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($display)) echo $display; ?>">
                <a class="" style="color: var(--black-600);" href="login.php">Log in</a>
            </div>
            <div class="login-register-button ms-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($displays)) echo $displays; ?>">
                <a style="color: var(--black-600);" href="logout.php">Log out</a>
            </div>
            <a class="logo" href="index.php">
                <div class="mt-2 mb-2">
                    <img src="assets/image/logo.png" alt="" style="height: 50px;">
                </div>
            </a>
            <div class="login-register-button ms-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($display)) echo $display; ?>">
                <a style="color: var(--black-600);" href="signup.php">Sign up</a>
            </div>
            <a href="profile.php" style="color: black;" class="ms-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($displays)) echo $displays; ?>">Welcome, <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?></a>
        </div>
    </div>
</div>
<br><br><br><br>

</body>
<script>
    if( window.history.replaceState){
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</html>