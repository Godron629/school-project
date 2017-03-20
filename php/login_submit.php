<?php

session_start();

if(isset( $_SESSION['user_id'] )) {
    $message = 'Users is already logged in';
}

if(!isset( $_POST['username'], $_POST['password'])) {
    $message = 'Please enter a valid username and password';
}

elseif (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 2) {
    $message = 'Incorrect Length for Username';
}

elseif (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4) {
    $message = 'Incorrect Length for Password';
}

elseif (ctype_alnum($_POST['username']) != true) {

    $message = "Username must be alpha numeric";
}

elseif (ctype_alnum($_POST['password']) != true) {

        $message = "Password must be alpha numeric";
} else {

    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    $password = sha1($password);
    
    $mysql_hostname = 'localhost';

    $mysql_username = 'root';

    $mysql_password = '';

    $mysql_dbname = 'foodbank';

    try {
        $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $dbh->prepare("SELECT user_id, username, password FROM users 
                    WHERE username = :username AND password = :password");

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        $stmt->execute();

        $user_id = $stmt->fetchColumn();

        if($user_id == false) {
                $message = 'Login Failed';
        } else {
                $_SESSION['user_id'] = $user_id;
                $message = 'You are now logged in';
        }
    }

    catch(Exception $e) {
        var_dump($e);
        $message = 'We are unable to process your request. Please try again later';
    }
}
?>

<html>
<head>
    <title>Admin Login Submit</title>
    <link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>
    <div id="loginBox" class="container centerAlign">
        <?php

        if($message === "You are now logged in") {
            echo '<p>' . $message . '</p>
            <a href="home.php" class="loginButton">Continue to Admin Site</a>
            ';

        } else {
            echo '
            <p> ' . $message . '</p>
            <a href="#" onclick="goBack()" class="loginButton">Back</a>
            ';
        }

        ?>
    </div>
</body>
</html>