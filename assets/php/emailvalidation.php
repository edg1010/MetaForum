<?php

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $sql);

if($result->num_rows > 0){
    echo "salahh";
    $email_error = "Email already exist";
    $error = 0;
}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $email_error = "Invalid e-mail format";
    $error = 0;
}

?>