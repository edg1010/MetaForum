<?php

include 'config.php';

$secret = $GET['username'];

$sql = "SELECT verified FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

foreach($index as $result){
    echo $index;
}

?>