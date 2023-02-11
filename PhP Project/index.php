<?php

include 'handler.php';
include 'header.php';

?>

<?php

$result = $db->checkAdress();

if ($result) {
header("location: userdetail.php");
} else {

?>

<html>
<title>Online Banking System</title>
<head>
    <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
    <body>
    <h2>To get full access, please fill out the following: </h2>
    <div class="finalizationForm">
        <form action="handler.php" method="post">

            <label for="country">Country:</label>
            <input type="text" name="country" id="country">
            <label for="region">Region:</label>
            <input type="text" name="region">
            <label for="city">City:</label>
            <input type="text" name="city">
            <label for="street">Street:</label>
            <input type="text" name="street">
            <label for="number">Number:</label>
            <input type="number" name="number" id="number">
            <input type="submit" value="Next" id="finalizationbutton" name="finalizationbutton">

        </form>
    </div>
    </body>
</html>

<?php

}

include 'footer.php';

?>








