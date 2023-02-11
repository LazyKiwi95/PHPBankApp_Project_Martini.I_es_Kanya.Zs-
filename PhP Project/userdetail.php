<?php

include 'handler.php';
include 'header.php'

?>

<html>
    <title>Online Banking System</title>
    <head>
        <link rel="stylesheet" type="text/css" href="css/userdetail.css">
    </head>
    <body>
        <h1>Az on adatai: </h1>
            <div class="userDetail">

                <?php

                $db->userDetailPrint()

                ?>

            </div>

        <form action="handler.php" method="post">
            <input type="submit" value="EddigiTranzakciok" name="transactionTable" id="transactionTable">
        </form>
    </body>
</html>

<?php

include 'footer.php';

?>
