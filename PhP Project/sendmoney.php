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
                <link rel="stylesheet" type="text/css" href="css/sendmoney.css">
            </head>
            <body>
                <div class="pinCheck">
                    <form action="handler.php" method="post">
                        <label for="sendPin">PIN
                            <input type="password" name="pin">
                        </label>
                        <input type="submit" value="Ok" name="sendPin">
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
                <link rel="stylesheet" type="text/css" href="css/sendmoney.css">
            </head>
            <body>
                <div class="sendMoney">
                    <form action="handler.php" method="post">
                        <label for="from">Melyik szamlaszamrol:
                            <input type="text" name="kuldoSzamlaszam" id="kuldoSzamlaszam">
                        </label>
                        <label for="egyenleg">Utalni kivant osszeg:
                            <input type="number" name="egyenleg" id="egyenleg"> Ron
                        </label>
                        <label for="where"> Melyik Szamlaszamra:
                            <input type="text" name="fogadoSzamlaszam" id="fogadoSzamlaszam">
                        </label>
                        <label for="message">Uzenet:
                            <input type="text" name="message" id="message">
                        </label>
                        <input type="submit" value="sendMoney" name="sendMoney" id="sendMoney">
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
            <link rel="stylesheet" type="text/css" href="css/sendmoney.css">
        </head>
        <body>
            <div class="pinCheck">
                <h1>PIN</h1>
                <form action="handler.php" method="post">
                    <label for="sendPin">
                        <input type="password" name="pin" id="pin">
                    </label>
                    <input type="submit" value="Ok" name="sendPin">
                </form>
            </div>
        </body>
    </html>

    <?php

}

include 'footer.php'

?>