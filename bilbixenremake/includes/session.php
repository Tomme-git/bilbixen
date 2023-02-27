<?php

include('dbconn.php');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(isset($_SESSION['login_user'])){
    $user_check = $_SESSION['login_user'];
}
if(isset($user_check)){
    $ses_sql = mysqli_query($objCon, "SELECT * FROM bb_login WHERE username = '$user_check' ");
}
if(isset($ses_sql)){
    $ses_row = mysqli_fetch_array($ses_sql, MYSQLI_ASSOC);
}

if(isset($ses_row)){
    $login_session = $ses_row['username'];
}

if(isset($ses_row)){
    $login_id = $ses_row['id'];
}

