<?php

include 'Database.php';

$db = new Database("localhost", "root", "", "bankdb");


//REGISTRATION
if (isset($_POST['registerbutton'])) {
    if(isset($_POST['lname'], $_POST['fname'], $_POST['email'], $_POST['password'], $_POST['cnp'])) {
        $lname = $_POST['lname'];
        $fname = $_POST['fname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cnp = $_POST['cnp'];
        $db->registerUser($fname, $lname, $email, $password, $cnp);
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === false) {
            header('location: login.php');
        } else {
            echo "Kerjuk toltse ki helyesen az adatokat.";
        }
    }
}



//LOGIN
if (isset($_POST['loginbutton'])) {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $db->loginUser($email, $password);
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            header('location: index.php');
        } else {
            echo "Helytelen email vagy jelszo";
        }
    }
}

//VEGLEGESITES
if (isset($_POST['finalizationbutton'])) {
    if (isset($_POST['country'], $_POST['region'], $_POST['city'], $_POST['street'], $_POST['number'])) {
        $country = $_POST['country'];
        $region = $_POST['region'];
        $city = $_POST['city'];
        $street = $_POST['street'];
        $number = $_POST['number'];
        $db->addFinalUserPersonalUser($country, $region, $city, $street, $number);
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            header('location: userdetail.php');
        } else {
            echo 'Hiba történt a kitöltés során, kérjük próbálja újra.';
        }
    }
}

// PENZ HOZAADASA
if (isset($_POST['addMoney'])) {
    $szamlaszam = $_POST['szamlaszam'];
    $egyenleg = $_POST['egyenleg'];
    $db->addMoney($szamlaszam, $egyenleg);
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: addmoney.php');
    } else {
        echo 'Hiba történt a kitöltés során, kérjük próbálja újra.';
    }
}

// PENZ LEVETELE
if (isset($_POST['withdrawMoney'])) {
    $szamlaszam = $_POST['szamlaszam'];
    $egyenleg = $_POST['egyenleg'];
    $db->withdrawMoney($szamlaszam, $egyenleg);
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: withdrawmoney.php');
    } else {
        echo 'Hiba történt a kitöltés során, kérjük próbálja újra.';
    }
}

// PENZ KULDES
if (isset($_POST['sendMoney'])) {
    $kuldoSzamla = $_POST['kuldoSzamlaszam'];
    $egyenleg = $_POST['egyenleg'];
    $fogadoSzamla = $_POST['fogadoSzamlaszam'];
    $message = $_POST['message'];
    $db->sendAndReceiveMoney($kuldoSzamla, $egyenleg, $fogadoSzamla);
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: sendmoney.php');
    } else {
        echo 'Hiba történt a kitöltés során, kérjük próbálja újra.';
    }
}

// TABLAZAT KIIRATASA
if (isset($_POST['transactionTable'])) {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: historytable.php');
    }
}

// VISSZALEPES
if (isset($_POST['back'])) {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: userdetail.php');
    }
}

//PIN ELLENORZES PENZ HOZZAADASAKOR
if (isset($_POST['addPin'])) {
    $pin = $_POST['pin'];
    $db->pinCheck($pin);
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: addmoney.php');
    }
}

//PIN ELLENORZES PENZ LEVETELEKOR
if (isset($_POST['withdrawPin'])) {
    $pin = $_POST['pin'];
    $db->pinCheck($pin);
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: withdrawmoney.php');
    }
}

//PIN ELLENORZES PENZ KULDESEKOR
if (isset($_POST['sendPin'])) {
    $pin = $_POST['pin'];
    $db->pinCheck($pin);
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        header('location: sendmoney.php');
    }
}

?>
