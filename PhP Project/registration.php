<?php
include 'Connection.php';
include 'header.php';
?>

<html>
<title>Online Banking System Registration</title>
<head>
    <link rel="stylesheet" type="text/css" href="css/registration.css">
</head>

<body>
    <div class="registerForm">
        <form action="Connection.php" method="post">

            <label for="username" id="username">First Name:</label>
            <input type="text" name="fname">
            <label for="username">Last Name:</label>
            <input type="text" name="lname">
            <label for="email">Email:</label>
            <input type="email" name="email">
            <label for="password">Password:</label>
            <input type="password" name="password">
            <label for="cnp">CNP:</label>
            <input type="number" name="cnp" maxlength="10" pattern="\d{10}" id="cnp">
            <input type="submit" value="Register" id="registerbutton"name="registerbutton">

        </form>
    </div>
</body>