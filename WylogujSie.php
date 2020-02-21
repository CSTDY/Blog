<?php
    session_start();

    //niszczymy całą sesję, czyli już nie mamy dostępu do zmiennych globalnych zadeklarowanych przy użyciu funkcji '$_SESSION'
    session_unset();

    //Przeniesienie użytkownika do strony głównej
    header('Location: index.php');
?>