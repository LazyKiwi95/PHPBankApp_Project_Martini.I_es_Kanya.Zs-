


<form id="firstForm" action="Connection.php" method="post">
    <label for="where">Szamlaszam:
        <input type="text" name="szamlaszam">
    </label>
    <label for="egyenleg">Felhelyezni kivant osszeg:
        <input type="number" name="egyenleg"> Ron
    </label>
    <input type="submit" value="addMoney" name="addMoney">
</form>

<script>
    document.getElementById("firstForm").addEventListener("submit", function(event){
        event.preventDefault();
        var enteredAmount = document.getElementsByName("egyenleg")[0].value;
        if(enteredAmount >= 0){
            document.getElementById("secondForm").style.display = "block";
        } else {
            alert("Meg kell adni a pinkódot");
        }
    });
</script>
<form id="secondForm" style="display:none;" action="Connection.php" method="post">
    <label for="pin">Pin kód:
        <input type="number" name="pin">
    </label>
    <input type="submit" value="confirmTransaction" name="submit">
</form>