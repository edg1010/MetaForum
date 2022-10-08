<?php

session_start();

include 'config.php';

$displays = "d-none";
$link = "login.php";
$width = 88;
$topicid = 1;
$subtopicid = 1;
$users = $_SESSION['username'];
$error = '';
$sql = "SELECT * FROM users where username = '$users'";
$result = mysqli_query($conn, $sql);
while($row = $result->fetch_assoc()){
    $userid = $row["userid"];
}

if(isset($_GET['id'])){
    $subtopicid = $_GET['id'];
}

if(isset($_GET['content'])){
    $content = $_GET['content'];
    if($content != ''){
        $sql = "INSERT INTO post (userid, subtopicid, text) VALUES ('$userid', '$subtopicid', '$content')";
        $result = mysqli_query($conn, $sql);
        header('Location: index.php?/id='.$subtopicid);
    }
}

$sql2 = "SELECT * FROM subtopic WHERE subtopicid = '$subtopicid'";
$result2 = mysqli_query($conn, $sql2);
while ($row = $result2->fetch_assoc()){
    $topicid = $row["topicid"];
    $subtopicid = $row["subtopicid"];
    $subtopicname = $row["subtopicname"];
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
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="//cdn.ckeditor.com/4.17.1/basic/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css?ver=1.1.1.11">
</head>
<body id="body" class="<?php if(isset($overflowhidden)) echo $overflowhidden?>">
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
                <a href="profile.php?user=<?php echo $users?>" style="color: black;" class="ms-3 text-center pt-1 pb-1 ps-3 pe-3 rounded-pill <?php if(isset($displays)) echo $displays; ?>">Welcome, <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?></a>
            </div>
        </div>
    </div>

    <div class="create-thread position-absolute" style="width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.7); z-index: 1000; display: <?php if(isset($errordisplay)) echo $errordisplay ?>;">
        <button id="close-create" class="position-absolute top-0 end-0" style="background: none; font-size: 30px; color: white; border: none;">&#10005;</button>
        <form action="" method="get" class="position-absolute top-50 start-50 translate-middle" style="width: 1000px; height: 600px; background: white;">
            <div class="p-2" style="color: #fff; width: 100%; background: #F274D3;">Creating Thread in <?php echo $subtopicname ?> </div>
            <textarea name="content" id="content"></textarea>
            <p style="color: red;"><?php if(isset($error)) echo $error ?></p>
            <button name="id" value="<?php echo $subtopicid;?>">POST</button>
        </form>
    </div>

    <br><br>

    <div class="d-flex mt-5 ms-auto me-auto justify-content-center align-items-center ps-5 pe-5" style="max-width: 1200px;">
        <span class="me-auto">Forum Groups</span>
        <div style="height: 1px; width: <?php echo $width?>%; background: black;"></div>
        <button id="thread" class="ms-auto p-1 threads <?php echo $displays?> " style="border: 1px solid black; font-size: 12px; color: black; background: none;" href="<?php echo $link ?>">CREATE THREADS</button>
    </div>
    <br>
    <div class="container d-flex justify-content-center" style="max-width: 1200px;">
        
        <div style="width: 15%;">
            <!-- <form action="" method="get"> -->
                <?php
                
                $sql = 'SELECT * FROM topic';
                $result = mysqli_query($conn, $sql);
                while ($row = $result->fetch_assoc()){
                    if($row["topicid"] == $topicid){
                        echo '<button name="topicid" value="'. $row["topicid"] .'" class="topics text-uppercase" id="topic-'. $row["topicid"] .'">'.$row["topicname"] .'</button>';
                    }else{
                        echo '<button name="topicid" value="'. $row["topicid"] .'" class="topics text-uppercase" id="topic-'. $row["topicid"] .'">'.$row["topicname"] .'</button>';
                    }
                    
                }
                
                ?>
            <!-- </form> -->
            <br>
        </div>
        <div style="width: 15%;">
            <form action="" method="get">
            <?php
            
            $sql = 'SELECT * FROM subtopic a JOIN topic b ON a.topicid = b.topicid';
            $result = mysqli_query($conn, $sql);
            while ($row = $result->fetch_assoc()){
                if($row["subtopicid"] == $subtopicid){
                    echo '<button name="id" value="'. $row["subtopicid"] .'" class="topics text-uppercase topic-'. $row["topicid"] . '"id="subtopic-' . $row["subtopicid"] . '">'.$row["subtopicname"] .'</button>';
                }else{
                    echo '<button name="id" value="'. $row["subtopicid"] .'" class="topics text-uppercase topic-'. $row["topicid"] . '"id="subtopic-' . $row["subtopicid"] . '">'.$row["subtopicname"] .'</button>';
                }
            }
            
            ?>
            </form>
        </div>

        
        <form action="" method="get" class="ms-auto me-auto" style="width: 70%;">
            
            <table class="" style="width: 100%; height: 100px;">

                <?php
                
                $sql = 'SELECT* FROM post a JOIN users b ON a.userid = b.userid';
                $result = mysqli_query($conn, $sql);
                while ($row = $result->fetch_assoc()){
                    if($row["subtopicid"] == $subtopicid){
                        echo '
                        <tr class="post subtopic-'. $row["subtopicid"] .'"> 
                        <td class="p-2" style="width: 6%;">';
                        echo'
                            </td>
                            <td class="p-2 d-block" style="min-width: 450px;max-width: 450px;">
                                <a class="elipsis" href="post.php?id='. $row["postid"] .'">
                                    '. $row["text"] .'
                                </a>
                            </td>
                            <td class="p-2">
                                by '. $row["username"] .'
                            </td>
                            <td class="p-2">
                                '. $row["views"] .'
                            </td>
                            <td class="p-2">
                                '. $row["time"] .'
                            </td>
                        </tr>';
                    }
                }
                ?>
            </table>
                
        </form>
    </div>

</body>

<?php

?>
<script>
    if( window.history.replaceState){
        window.history.replaceState( null, null, window.location.href );
    }
    CKEDITOR.replace('content');
    
    $(document).ready(function(){

        for(let i = 1; i <= 7; i++){
            $('.show'+i).show();
            $('.hide'+i).hide();
            if(i == <?php echo $topicid?>){
                $('.topic-'+i).show();
                $('#topic-'+i).addClass("topics-active");
            }else{
                $('.topic-'+i).hide();
                $('#topic-'+i).removeClass("topics-active");
            }
        }

        for(let i = 1; i <= 7; i++){
            $('#topic-'+i).click(function(){
                for(let j = 1; j <= 7; j++){
                    if(i == j){
                        $('.topic-'+j).show();
                        $('#topic-'+j).addClass("topics-active");
                    }else{
                        $('.topic-'+j).hide();
                        $('#topic-'+j).removeClass("topics-active");
                    }
                }
            });
        }

        for(let i = 1; i <= 26; i++){
            if(i == <?php echo $subtopicid?>){
                $('.subtopic-'+i).show();
                $('#subtopic-'+i).addClass("topics-active");
            }else{
                $('.subtopic-'+i).hide();
                $('#subtopic-'+i).removeClass("topics-active");
            }
        }

        for(let i = 1; i <= 26; i++){
            $('#subtopic-'+i).click(function(){
                for(let j = 1; j <= 26; j++){
                    if(i == j){
                        $('.subtopic-'+j).show();
                        $('#subtopic-'+j).addClass("topics-active");
                    }else{
                        $('.subtopic-'+j).hide();
                        $('#subtopic-'+j).removeClass("topics-active");
                    }
                }
            });
        }


    });



</script>
<!-- <script src="assets/js/subtopic.js?ver=1.1"></script> -->
<script src="assets/js/create.js"></script>
</html>