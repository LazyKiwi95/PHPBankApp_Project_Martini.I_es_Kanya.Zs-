<?php
include 'Connection.php';
include 'header.php';

?>



<form action="Connection.php" method="post">
    <label for="where">Szamlaszam:
        <input type="text" name="szamlaszam">
    </label>
    <label for="egyenleg">Levenni kivant osszeg:
        <input type="number" name="egyenleg"> Ron
    </label>
    <input type="submit" value="withdrawMoney" name="withdrawMoney">
</form>