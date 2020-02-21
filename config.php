<?php 
	session_start();

    require_once('connect.php');

    
    $connection = mysqli_connect($host, $db_user, $db_password, $db_name);

    //kiedy nie udało się połączyć
    if(!$connection)
    {
        die("Nie udało bołączyć się z bazą danych! Błąd: ".mysqli_connect_error());
    }
  
	

	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/Blog/');
?>