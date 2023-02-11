<?php
session_start();
class Database
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $connecion;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    private function connectDatabase()
    {
        $this->connecion = new mysqli($this->host, $this->username, $this->password, $this->dbname);
        if ($this->connecion->connect_error) {
            die("Connection failed: " . $this->connecion->connect_error);
        }
    }

    public function query($sql)
    {
        $this->connectDatabase();
        $result = $this->connecion->query($sql);
        $this->connecion->close();
        return $result;
    }

    //registration of a user and adding the entered values to database
    public function registerUser($fname, $lname, $email, $password, $cnp)
    {
        $this->connectDatabase();

        // check if the username is already taken

        $check_username = $this->connecion->query("SELECT * FROM registeredusers WHERE email = '$email' ");
        if ($check_username->num_rows > 0) {
            header("Location: registration.php");
        } else {

            // insert the data into the database

            $insert = $this->connecion->query("INSERT INTO registeredusers (fname, lname, email, password, cnp) VALUES ('$fname', '$lname', '$email', '$password', $cnp)");
            if ($insert) {
                $_SESSION['logged_in_user_id'] = $email;
                $_SESSION['logged_in'] = false;
            }
        }
    }

    //login
    public function loginUser($email, $password)
    {
        $this->connectDatabase();

        // check if the username and password match

        $check_credentials = $this->connecion->query("SELECT * FROM registeredusers WHERE email = '$email'");
        if ($check_credentials->num_rows > 0) {
            $row = $check_credentials->fetch_assoc();
            if ($password === $row['password']) {
                $_SESSION['logged_in_user_id'] = $email;
                $_SESSION['logged_in'] = true;
            } else {
                //TODO
            }
        }
    }

    //random number generator create a 4 digit pin and a 10digit account number inicialise the balance equal to 0
    public function generateRandomNumbers()
    {
        $pin = rand(0000, 9999);
        $szamlaszam = "RO" . rand(0000000000, 9999999999);
        $egyenleg = 0;
        return array($szamlaszam, $pin, $egyenleg);
    }
    /*
        public function addfinalUser($country, $region, $city, $street, $number)
        {
            $this->connectDatabase();
            if (isset($_SESSION['email'])) {
                $useremail = $_SESSION['email'];
                //check if email existsts in final
                $checkFinalEmail = $this->connecion->query("SELECT * FROM registeredusers JOIN finalusers ON registeredusers.email = finalusers.email WHERE registeredusers.email = '$useremail' GROUP BY finalusers.email");
                if ($checkFinalEmail->num_rows == 0) {
                    $insertToFinal = $this->connecion->query("INSERT INTO finalusers (email, country, region, city, street, number) VALUES ('$useremail', '$country', '$region', '$city', '$street', $number)");
                    if ($insertToFinal)
                    {
                        echo "Sikeres";
                    } else
                    {
                        echo "Hiba tortent.";
                    }
                }
            }
        }
        public function addPersonalUser(){
            $this->connectDatabase();
            if (isset($_SESSION['email'])) {
                $useremail = $_SESSION['email'];
                //check if email exists in personal
                $checkPersonaEmail = $this->connecion->query("SELECT * FROM registeredusers JOIN userpersonal ON registeredusers.email = userpersonal.email WHERE registeredusers.email = '$useremail' GROUP BY userpersonal.email");
                if ($checkPersonaEmail->num_rows == 0)
                {
                    $random_numbers = $this->generateRandomNumbers();
                    $szamlaszam = $random_numbers[0];
                    $pin = $random_numbers[1];
                    $egyenleg = 0;
                    $insertToPersonal = $this->connecion->query("INSERT INTO userpersonal(email, szamlaszam, pin, egyenleg) VALUES ('$useremail', '$szamlaszam', $pin, $egyenleg)");
                    if ($insertToPersonal)
                    {
                        echo "Sikeres";
                    } else
                    {
                        echo "Hiba torent";
                    }
                }
            }
        }
    */

    // adding user personal info to finaluser table and create bank info to userpersonal table
    public function addFinalUserPersonalUser($country, $region, $city, $street, $number)
    {
        $this->connectDatabase();
        if (isset($_SESSION['logged_in_user_id'])) {
            $useremail = $_SESSION['logged_in_user_id'];

            //check if email exists in finalusers table

            $checkFinalEmail = $this->connecion->query("SELECT * FROM finalusers 
                                                        JOIN registeredusers ON finalusers.email = registeredusers.email 
                                                        WHERE finalusers.email = '$useremail' 
                                                        GROUP BY registeredusers.email");

            //check if email exists in userpersonal table

            $checkPersonaEmail = $this->connecion->query("SELECT * FROM finalusers 
                                                        JOIN userpersonal ON finalusers.email = userpersonal.email 
                                                        WHERE finalusers.email = '$useremail' 
                                                        GROUP BY userpersonal.email");
            $this->connecion->begin_transaction();
            if ($checkFinalEmail->num_rows == 0) {
                $insertToFinal = $this->connecion->query("INSERT INTO finalusers (email, country, region, city, street, number) 
                                                        VALUES ('$useremail', '$country', '$region', '$city', '$street', $number)");
                if ($checkPersonaEmail->num_rows == 0) {
                    $random_numbers = $this->generateRandomNumbers();
                    $szamlaszam = $random_numbers[0];
                    $pin = $random_numbers[1];
                    $egyenleg = 0;
                    $insertToPersonal = $this->connecion->query("INSERT INTO userpersonal(email, szamlaszam, pin, egyenleg) 
                                                                VALUES ('$useremail', '$szamlaszam', $pin, $egyenleg)");
                } else {
                    //TODO
                }
            } else {
                //TODO
            }
            if ($insertToFinal && $insertToPersonal) {
                $this->connecion->commit();
                unset($_SESSION['email']);
                $_SESSION['logged_in'] = true;
            } else {
                $this->connecion->rollback();
            }
        } else {
            //TODO
        }
    }

    // return the user firstName and lastName if the email exist in registereusers table (for header)
    public function showUser()
    {
        $this->connectDatabase();
        $useremail = $_SESSION['logged_in_user_id'];
        $checkUser = $this->connecion->query("SELECT fname, lname FROM registeredusers WHERE email = '$useremail'");
        $_SESSION['logged_in_user_id'] = $useremail;
        if (mysqli_num_rows($checkUser) > 0) {
            while ($row = mysqli_fetch_assoc($checkUser)) {
                echo $row["fname"] . " " . $row["lname"];
                return true;
            }
        } else {
            return false;
        } return true;
    }

    // return the user residential information from finalusers if email exist in database
    public function checkAdress()
    {
        $this->connectDatabase();
        $useremail = $_SESSION['logged_in_user_id'];
        $addressExists = $this->connecion->query("SELECT country, region, city, street, number FROM finalusers WHERE email = '$useremail'");
        $_SESSION['logged_in_user_id'] = $useremail;
        if (mysqli_num_rows($addressExists) > 0) {
            while ($row = mysqli_fetch_assoc($addressExists)) {
                echo $row['country'] . " " . $row['region'] . " " . $row['city'] . " " . $row['street'] . " " . $row['number'];
                return true;
            }
        } else {
            return false;
        } return  true;
    }

    // return entered values from registeredusers, finalusers and userpersonal table
    public function userDetailPrint(){
        $this->connectDatabase();
        $useremail = $_SESSION['logged_in_user_id'];
        $registeredUsers = $this->connecion->query("SELECT * FROM registeredusers WHERE email = '$useremail'");
        $_SESSION['logged_in_user_id'] = $useremail;
        if (mysqli_num_rows($registeredUsers) > 0){
            while ($row = mysqli_fetch_assoc($registeredUsers)){
                ?> <div class="data1"> <h2>Szemelyes Adatok: </h2>
                <h3>First Name: </h3> <?php echo  $row['fname'];
                ?>  <h3>Last Name: </h3> <?php echo  $row['lname'];
                ?>  <h3>Email: </h3> <?php echo $row['email'];
                ?>  <h3>CNP: </h3>  <?php echo  $row['cnp']; ?> </div> <?php
            }
        }
        $finalUser = $this->connecion->query("SELECT * FROM finalusers WHERE email = '$useremail'");
        if (mysqli_num_rows($finalUser) > 0){
            while ($row = mysqli_fetch_assoc($finalUser)){
                ?> <div class="data1"> <h2>Lakcim Adatok: </h2>
                <h3>Country: </h3> <?php echo $row['country'];
                ?> <h3>Region: </h3> <?php echo $row['region'];
                ?> <h3>City: </h3> <?php echo $row['city'];
                ?> <h3>Street: </h3> <?php echo $row['street'];
                ?> <h3>Number: </h3> <?php echo $row['number'] . ". szam"; ?> </div> <?php
            }
        }
        $personalUser = $this->connecion->query("SELECT * FROM userpersonal WHERE email = '$useremail'");
        if (mysqli_num_rows($personalUser) > 0){
            while ($row = mysqli_fetch_assoc($personalUser)){
                ?>  <div class="data1"> <h2>Banki Adatok: </h2>
                <h3>Szamlaszam: </h3> <?php echo $row['szamlaszam'];
                ?> <h3>PIN: </h3> <?php echo $row['pin'];
                ?> <h3>Egyenleg: </h3> <?php echo $row['egyenleg']; ?> </div> <?php
            }
        }
    }

    //add money to userperonal if account number exist and check the value to be valid
    public function addMoney($szamlaszam, $egyenleg)
    {
        if ($egyenleg < 0 ){
            echo "Nem lehet kisebb mint nulla!";
        } elseif ($egyenleg ==0) {
            echo "Nem lehet nulla";
        } else {
            $this->connectDatabase();
            $addForUser = $this->connecion->query("UPDATE userpersonal SET egyenleg = egyenleg + $egyenleg WHERE szamlaszam = '$szamlaszam'");
            if ($addForUser)
            {
                $currentDate = date("Y-m-d");
                $history = $this->connecion->query("INSERT INTO history (datum, tipus, ertek, szamlaszam, uzenet) VALUES ('$currentDate', 'Penz feltoltes', '$egyenleg', '$szamlaszam', 'Nincs megjegyzes')");
                if ($history){
                    return true;
                }
            } else
            {
                return false;
            }
        } return true;
    }

    //remove money to userperonal if account number exist and check the value to be valid
    public function withdrawMoney($szamlaszam, $egyenleg)
    {
        if ($egyenleg < 0) {
            return "Nem lehet kisebb mint null";
        } elseif ($egyenleg == 0) {

            return "Nem lehet null";
        } else {
            $this->connectDatabase();
            $checkBalance = $this->connecion->query("SELECT egyenleg FROM userpersonal WHERE szamlaszam = '$szamlaszam'");
            if (mysqli_num_rows($checkBalance) > 0) {
                while ($row = mysqli_fetch_assoc($checkBalance)) {
                    if ($row['egyenleg'] < $egyenleg) {
                        return "Nincs eleg penz";
                    } else {
                        $removeFromUser = $this->connecion->query("UPDATE userpersonal SET egyenleg = egyenleg - $egyenleg WHERE szamlaszam = '$szamlaszam'");
                        if ($removeFromUser) {
                            $currentDate = date("Y-m-d");
                            $history = $this->connecion->query("INSERT INTO history (datum, tipus, ertek, szamlaszam, uzenet) VALUES ('$currentDate', 'Penz kiveves', '$egyenleg', '$szamlaszam', 'Nincs megjegyzes')");
                            if ($history) {
                                return true;
                            }
                        } else {
                            return "Nem sikerult levenni a penzt";
                        }
                    }
                }
            }
        } return true;
    }

    ////send money between two users via account number if account numbers exists and check the value to be valid
    public function sendAndReceiveMoney($kuldoSzamla, $egyenleg, $fogadoSzamla)
    {
        if ($egyenleg < 0) {
            return "Nem lehet kisebb mint null";
        } elseif ($egyenleg == 0) {
            return "Nem lehet null";
        } else {
            $this->connectDatabase();
            $this->connecion->begin_transaction();
            $addForUser = $this->connecion->query("UPDATE userpersonal SET egyenleg = egyenleg + $egyenleg WHERE szamlaszam = '$fogadoSzamla'");
            $checkBalance = $this->connecion->query("SELECT egyenleg FROM userpersonal WHERE szamlaszam = '$kuldoSzamla'");
            if (mysqli_num_rows($checkBalance) > 0) {
                while ($row = mysqli_fetch_assoc($checkBalance)) {
                    if ($row['egyenleg'] < $egyenleg) {
                        return "Nincs eleg penz";
                    } else {
                        $removeFromUser = $this->connecion->query("UPDATE userpersonal SET egyenleg = egyenleg - $egyenleg WHERE szamlaszam = '$kuldoSzamla'");
                        if ($removeFromUser && $addForUser) {
                            $this->connecion->commit();
                            $currentDate = date("Y-m-d");
                            $message = $_POST['message'];
                            $history1 = $this->connecion->query("INSERT INTO history (datum, tipus, ertek, szamlaszam, uzenet) VALUES ('$currentDate', 'Penzt kapott', '$egyenleg', '$fogadoSzamla', '$message')");
                            $history2 = $this->connecion->query("INSERT INTO history (datum, tipus, ertek, szamlaszam, uzenet) VALUES ('$currentDate', 'Penzt utalt', '$egyenleg', '$kuldoSzamla', '$message')");
                            if ($history1 && $history2){
                                return "siker";
                            }
                        } else {
                            $this->connecion->rollback();
                            return "Nem sikerult levenni a penzt";
                        }
                    }
                }
            }
        } return true;
    }

    //return data from history table and format into html table
    public function historyPrint()
    {
        $this->connectDatabase();
        $useremail = $_SESSION['logged_in_user_id'];
        $userHistory = $this->connecion->query("SELECT * FROM history
                                                JOIN userpersonal ON history.szamlaszam = userpersonal.szamlaszam
                                                JOIN registeredusers ON userpersonal.email = registeredusers.email
                                                WHERE userpersonal.email = '$useremail'");
        $_SESSION['logged_in_user_id'] = $useremail;
        if (mysqli_num_rows($userHistory) > 0) {
                        echo "<table>
                <tr>
                    <th>Tranzakcio Datum</th>
                    <th>Elofizeto Neve</th>
                    <th>Szamlaszam</th>
                    <th>Ertek</th>
                    <th>Tranzakcio tipusa</th>
                    <th>Uzenet</th>
                </tr>";
            while ($row = mysqli_fetch_assoc($userHistory)) {
                if ($row['tipus'] == "Penzt kapott" || $row['tipus'] == "Penz feltoltes") {
                    $sign = "+";
                    $color = "green";
                } else {
                    $sign = "-";
                    $color = "red";
                }
                echo "<tr>
                <td>" . $row['datum'] . "</td>
                <td>" . $row['fname'] . " " . $row['lname'] . "</td>
                <td>" . $row['szamlaszam'] . "</td>
                <td style='color: $color'>" . $sign . $row['ertek'] . "</td>
                <td>" . $row['tipus'] . "</td>
                <td>" . $row['uzenet'] . "</td>
            </tr>";
            }
            echo "</table>";
        }
    }

    //validate entered pin if its ok than operations can be executed by user
    public function pinCheck($pin)
    {
        $this->connectDatabase();
        $useremail = $_SESSION['logged_in_user_id'];
        $pinEqualToDbPin = $this->connecion->query("SELECT pin FROM userpersonal WHERE pin = $pin");
        $_SESSION['logged_in_user_id'] = $useremail;
        if (mysqli_num_rows($pinEqualToDbPin) > 0) {
            while ($row = mysqli_fetch_assoc($pinEqualToDbPin)) {
                if($row['pin'] == $pin) {
                    $_SESSION['userPin'] = $pin;
                }
            }
        }
    }




}
?>



