<?php
include 'handler.php';
include 'header.php';

?>

<?php

if (isset($_SESSION['userPin'])) {
    $result = $db->pinCheck($_SESSION['userPin']);
    if ($result) {

        ?>

        <html>
            <title>Online Banking System</title>
            <head>
                <link rel="stylesheet" type="text/css" href="css/addmoney.css">
            </head>
            <body>
            <div class="pinCheck">

                <form action="handler.php" method="post">
                    <label for="addPin">PIN
                        <input type="password" name="pin">
                    </label>
                    <input type="submit" value="Ok" name="addPin">
                </form>

            </div>
            </body>
        </html>

        <?php

    } else {

        ?>

        <html>
            <title>Online Banking System</title>
            <head>
                <link rel="stylesheet" type="text/css" href="css/addmoney.css">
            </head>
            <body>
                <div class="addMoney">
                    <form action="handler.php" method="post">
                        <label for="where">Szamlaszam:
                            <input type="text" name="szamlaszam" id="szamlaszam">
                        </label>
                        <label for="egyenleg">Felhelyezni kivant osszeg:
                            <input type="number" name="egyenleg" id="egyenleg"> Ron
                        </label>
                        <input type="submit" value="addMoney" name="addMoney" id="addMoney">
                    </form>
                </div>
            </body>
        </html>

        <?php

    }

} else {

    ?>

    <html>
        <title>Online Banking System</title>
        <head>
            <link rel="stylesheet" type="text/css" href="css/addmoney.css">
        </head>
        <body>
            <div class="pinCheck">
                <h1>PIN</h1>
                <form action="handler.php" method="post">
                    <label for="addPin">
                        <input type="password" name="pin" id="pin">
                    </label>
                    <input type="submit" value="Ok" name="addPin">
                </form>
            </div>
        </body>
    </html>

    <?php

}

include 'footer.php';

?>

