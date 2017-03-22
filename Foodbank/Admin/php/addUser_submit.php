<?php
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: loginRequired.php');
}

if(!isset( $_POST['username'], $_POST['password'], $_POST['form_token'])) {
    $message = 'Please enter a valid username and password';
}
/* check the form token is valid */
elseif( $_POST['form_token'] != $_SESSION['form_token']) {
    $message = 'Invalid form submission';
}
/* check the username is the correct length */
elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 2) {
    $message = 'Incorrect Length for Username';
}
/* check the password is the correct length */
elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4) {
    $message = 'Incorrect Length for Password';
}
/* check the username has only alpha numeric characters */
elseif (ctype_alnum($_POST['username']) != true) {
    $message = "Username must be alpha numeric";
}
/* check the password has only alpha numeric characters */
elseif (ctype_alnum($_POST['password']) != true) {
        $message = "Password must be alpha numeric";
}
else
{

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $password = sha1( $password );
    
    /* connect to database */
    $mysql_hostname = 'localhost';

    $mysql_username = 'root';

    $mysql_password = '';

    $mysql_dbname = 'foodbank';

    try
    {
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("INSERT INTO users (username, password) VALUES (:username, :password )");

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        $stmt->execute();

        unset($_SESSION['form_token']);

        $message = 'New User Added';
    }
    catch(Exception $e)
    {
        if( $e->getCode() == 23000)
        {
            $message = 'Username already exists';
        }
        else
        {
            $message = 'We are unable to process your request. Please try again later';
        }
    }
}
?>

<html>
<head>
    <title>Add User Submit</title>
    <link rel="stylesheet" type="text/css" href="/Foodbank/css/stylesheet.css">

    <script>
        function goBack() {
            window.history.back();
        }
    </script>

</head>
<body>
    <div id="loginBox" class="container centerAlign">
    <?php

        if($message === "New User Added") {
            echo '<p>' . $message . '</p>
            <a href="/Foodbank/Admin/home.php" class="loginButton">Go Home</a>  ';
        } else {
            echo '<p>' . $message . '</p>
            <a href="#" onclick="goBack()" class="loginButton">Back</a>
            ';
        }

    ?>
    </div>
</body>
</html>
