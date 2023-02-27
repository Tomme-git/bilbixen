<?php

if (isset($_POST['sbmtlogin'])) {

    // username and password sent from form 
    $username = mysqli_real_escape_string($objCon, $_POST['username']);
    $password = mysqli_real_escape_string($objCon, $_POST['password']);

    $sql = "SELECT * FROM bb_login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($objCon, $sql);
    if (!$result) {
        printf("Error: %s\n", mysqli_error($objCon));
        exit();
    }
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $count = mysqli_num_rows($result);

    // If result matched $username and $password, table row must be 1 row
    if ($count == 1) {
        // $session_register = session_register("brugernavn");
        $_SESSION['login_user'] = $username;
        if ($row['permissions'] == 1) {
            header('Location: admin.php');
            exit();
        } elseif ($row['permissions'] == 2) {
            header('Location: index.php');
            exit();
        } else {
            header('Location: index,php');
            exit();
        }
    } else {
        $error = "Brugernavn eller password er forkert";
    }
}