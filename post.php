<?php

session_start();

include 'config.php';

// echo $_GET["id"];
$postid = $_GET["id"];
$displays = "d-none";
$link = "login.php";
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
    if(isset($_POST['content'])){
        $content = $_POST['content'];
        if($content != ''){
            $sql = "INSERT INTO reply (userid, postid, text) VALUES ('$userid', '$postid', '$content')";
            $result = mysqli_query($conn, $sql);
            header('Location: post.php?id='.$postid);
        }else{
            $error = 'Reply cannot be empty';
            $errordisplay = 'block';
            $overflowhidden = 'overflow-hidden';
        }
    }
}else{
    $action = 'login.php';
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="//cdn.ckeditor.com/4.17.1/basic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?ver=1.1.1.10">
</head>
<body id="body">
    <div class="border-bottom fixed-top " style="background: #fff;">
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
                <a href="" style="color: black;" class="ms-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($displays)) echo $displays; ?>">Welcome, <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?></a>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <div class="ms-auto me-auto" style="width: 1000px; background: white;">
        <div class="d-flex">
            <div style="width: 20%; text-align: center;">
                <br><br>
                <img class="ms-auto me-auto" src="assets/image/user/blank.png" style="width: 70%; border-radius: 100%;" alt="">
                <br><br><br>
                <?php
                $sql = "SELECT * FROM post a JOIN users b ON a.userid = b.userid WHERE postid = '$postid'";
                $result = mysqli_query($conn,$sql);
                while($row = $result->fetch_assoc()){
                    echo $row['username'];
                }
                ?>
            </div>
            <div style="width: 80%;">
                <div class="p-2" style="color: #fff; background: #49BFBE;">Main Post</div>
                    <div class="text-break p-3" style="width: 100%; border: 1px solid #000; min-height: 250px;">
                    <?php
                        $sql = "SELECT * FROM post WHERE postid = '$postid'";
                        $result = mysqli_query($conn,$sql);
                        while($row = $result->fetch_assoc()){
                            echo $row["text"];
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <br>
        <form action="<?php if(isset($action)) echo $action?>" method="post">
            <div class="p-2" style="color: #fff; width: 100%; background: #49BFBE;">Reply</div>
            <textarea name="content" id="content"></textarea>
            <p class="error-message" style="color: red;"><?php if(isset($error)) echo $error ?></p>
            <button id="post" class="float-end" name="id" value="<?php echo $postid;?>">REPLY</button>
        </form>
        <br>
        <br>
        <?php
            $sql = "SELECT * FROM reply a JOIN users b ON a.userid = b.userid WHERE postid = '$postid'";
            $result = mysqli_query($conn,$sql);
            while($row = $result->fetch_assoc()){
                echo '
                <div class="d-flex">
                <div style="width: 20%; text-align: center;">
                <br><br>
                <img class="ms-auto me-auto" src="assets/image/user/blank.png" style="width: 70%; border-radius: 100%;" alt="">
                <br><br><br>
                '. $row["username"] .'
                </div>
                <div style="width: 80%;">
                    <div class="p-2" style="color: #fff; background: #49BFBE;">Main Post</div>
                        <div class="text-break p-3" style="width: 100%; border: 1px solid #000; min-height: 250px;">
                        '. $row["text"] .'
                    </div>
                    </div>
                    </div>
                    <br>
                    ';
                }
        ?>
    </div>
    <br><br>
</body>
<script>
    if( window.history.replaceState){
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<script src="assets/js/subtopic.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
</html>