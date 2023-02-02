<?php
include 'Connection.php';
include 'header.php';

?>



<form action="Connection.php" method="post">
    <label for="from">Melyik szamlaszamrol:
        <input type="text" name="kuldoSzamlaszam">
    </label>
    <label for="egyenleg">Utalni kivant osszeg:
        <input type="number" name="egyenleg"> Ron
    </label>
    <label for="where"> Melyik Szamlaszamra
        <input type="text" name="fogadoSzamlaszam">
    </label>
    <label for="message">Uzenet:
    <input type="text" name="message">
    </label>
    <input type="submit" value="sendMoney" name="sendMoney">
</form>