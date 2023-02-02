<?php
include 'Connection.php';
include 'header.php';
?>

<html>
<title>Online Banking System</title>
<head>
    <link rel="stylesheet" type="text/css" href="css/userdetail.css">
</head>
<body>
<h1>Tranzakcio elozmenyek: </h1>

<div>
    <?php $db->historyPrint(); ?>
</div>

<form action="Connection.php" method="post">
    <input type="submit" value="Vissza" name="back">
</form>

</body>
