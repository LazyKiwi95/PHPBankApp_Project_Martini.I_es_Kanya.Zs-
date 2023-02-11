<?php

include 'handler.php';
include 'header.php';

?>

<html>
    <title>Online Banking System</title>
    <head>
        <link rel="stylesheet" type="text/css" href="css/historydetail.css">
    </head>
    <body>
        <h1>Tranzakcio elozmenyek: </h1>
        <div class="historyTable">

            <?php

            $db->historyPrint();

            ?>

            <form action="handler.php" method="post">
                <input type="submit" value="Vissza" name="back" id="back">
            </form>
        </div>
    </body>
</html>

<?php

include 'footer.php';

?>
