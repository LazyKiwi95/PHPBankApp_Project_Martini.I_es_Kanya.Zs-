<?php
include 'Connection.php';
include 'header.php';
?>

<html>
<title>Online Banking System Registration</title>
<head>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <div class="loginForm">
        <form action="Connection.php" method="post">

            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Login" id="loginbutton" name="loginbutton">

        </form>
    </div>
</body>
</html>
