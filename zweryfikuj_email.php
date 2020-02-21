<?php
session_start();
require_once('connect.php');
$connection = new mysqli($host, $db_user, $db_password, $db_name);

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "SELECT * FROM uzytkownicy WHERE token='$token' LIMIT 1";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        //Potwierdzamy weryfikację i przedłużamy konto na okres 10 lat!
        $query = "UPDATE uzytkownicy SET weryfikacja=1, okres_weryfikacji = now() + INTERVAL 10 YEAR WHERE token='$token';";

        if (mysqli_query($connection, $query)) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['uzytkownik'] = $user['uzytkownik'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['okres_weryfikacji'] = $user['okres_weryfikacji'];
            $_SESSION['weryfikacja'] = true;
            $_SESSION['message'] = "Twój email został pomyślnie zweryfikowany!";
            $_SESSION['type'] = 'alert-success';
            header('location: index.php');
            exit(0);
        }
    } else {
        echo "Nie znaleziono użytkownika!";
    }
} else {
    echo "Nie ma przypisanego tokena!!";
}