<?php

if (isset($_SESSION['logged_in']) === false) {

    ?>

    <html>
        <title>Online Banking System Registration</title>
        <head>
            <link rel="stylesheet" type="text/css" href="css/header.css">
        </head>
        <header>
            <div class="header_main">
                <div class="navBar">
                    <ul>
                        <li><a href="registration.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>
                    </ul>
                </div>
                <a href="index.php"><div class="logo-name">
                        <div class="logo">
                            <img class="logo_img" src="img/chase.jpg">
                        </div>

                        <div class="name">
                            <h5> Online Banking System</h5></a><br>
                <h6>In PHP</h6>
            </div>
        </header>
    </html>

    <?php

} else {

    ?>

    <html>
        <title>Online Banking System Registration</title>
        <head>
            <link rel="stylesheet" type="text/css" href="css/header.css">
        </head>
        <header>
            <div class="header_main">
                <div class="navBar">
                    <ul>
                        <li><a href="userdetail.php"><?php $result = $db->showUser();?></a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
                <a href="index.php"><div class="logo-name">
                        <div class="logo">
                            <img class="logo_img" src="img/chase.jpg">
                        </div>

                        <div class="name">
                            <h5> Online Banking System</h5></a><br>
                <h6>In PHP</h6>
            </div>
            <div class="tranzaction">
                <ul>
                    <li><a href="addmoney.php">Penz beteves</a></li>
                    <li><a href="sendmoney.php">Penz utalas</a></li>
                    <li><a href="withdrawmoney.php">Penz kiveves</a></li>
                </ul>
            </div>
        </header>
    </html>

    <?php

}

?>


