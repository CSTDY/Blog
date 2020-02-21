<?php
require_once('wyslij_email.php');
    if(isset($_POST['email']))
    {
        //Rejestracja się powieodła
        $Udana_Rejestracja = true;
        //Sprawdzam, czy nazwa użytkownika nie jest za krótki lub za długi
        $uzytkownik = $_POST['user'];
        //funkcja 'strlen' zwraca długość stringa (tekstu)
        if((strlen($uzytkownik)<3) || (strlen($uzytkownik)>20))
        {
            $Udana_Rejestracja = false;
            $_SESSION['e_user'] = "Nazwa użytkownika może posiadać od 3 do 20 znaków";
        }
        //funkcja 'ctype_alnum' sprawdza, czy wszystkie znaki są alfanumeryczne
        //(ang. check for alphanumeric characters)
        //W skrócie jeżeli zwróci 'false' to oznacza, że w tekście nie ma specjalnych znaków (np.: ',' 'ą' 'ę' '*')
        if(ctype_alnum($uzytkownik) == false)
        {
            $Udana_Rejestracja = false;
            $_SESSION['e_user'] = "Nazwa użytkownika może składać się tylko z liter i cyfr (bez polskich znaków)";
        }
        //Sprawdzam, czy email został poprawnie wpisany
        $email = $_POST['email'];
        
        //funkcja 'filter_var' pobiera obiekt do filtrowania (1) 
        //oraz filtr, przez jaki ma przejść ten obiekt
        //Stała 'FILTER_SANITIZE_EMAIL' filtruje wszystkie niedozwolone znaki w emailu
        $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        //Stała 'FILTER_VALIDATE_EMAIL' sprawdza poprawność napisanego maila
        if((filter_var($emailS, FILTER_VALIDATE_EMAIL)==false) || ($emailS != $email))
        {
            $Udana_Rejestracja = false;
            $_SESSION['e_email'] = "Podaj poprawny e-mail";
        }
        //Sprawdzam, czy hasło się zgadza
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];
        if((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $Udana_Rejestracja = false;
            $_SESSION['e_password'] = "Hasło musi posiadać od 8 do 20 znaków!";
        }
        if($haslo1 != $haslo2)
        {
            $_SESSION['e_password'] = "Podane hasła nie są identyczne!";
        }
        //funkcja 'password_hash' koduje hasło algorytmem bcrypt
        //Stała 'PASSWORD_DEFAULT' oznacza, że kompilator sam wybiera najbezpieczniejszy algorytm
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50)); // generate unique token
        //Czy zaakceptowano regulamin
        if(!isset($_POST['regulamin']))
        {
            $Udana_Rejestracja = false;
            $_SESSION['e_regulamin'] = "* To pole jest wymagane!";
        }
        //Recaptcha, sprawdź, czy user nie jest robotem
        
        $kod = "6Le1lsoUAAAAAC8oSiKpvIcoKLjDdU7wg_OfpZK1";
        //funkcja 'file_get_contents' pobiera zawartość pliku (zapisanego w nawiasie) do zmiennej
        $czy_zaznaczony = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$kod.'&response='.$_POST['g-recaptcha-response']);
        //funkcja 'json_decode' dekoduje zawartość z formatu .json (W tym formacie napisana jest reCaptcha)
        $odp = json_decode($czy_zaznaczony);
        if($odp->success==false)
        {
            $Udana_Rejestracja = false;
            $_SESSION['e_reCaptcha'] = "Potwierdź, że nie jesteś botem!";
        }
        //Zapamiętaj wpisane wartości przy nieudanej rejestracji
        $_SESSION['saved_user'] = $uzytkownik;
        $_SESSION['saved_email'] = $email;
        if(isset($_POST['regulamin'])) $_SESSION['saved_regulamin'] = true;
        //połączenie z bazą MySql
        require_once "connect.php";
        //ustawienie sposób raportowania o błędzie
        //funkcja 'mysqli_report' sprqwdza w jaki sposób raportować ewentualne błędy w programie
        //Metoda 'MYSQLI_REPORT_STRICT' mówi, żeby raportować tylko te błędy, które zapisaliśmy w klauzuli "try" 
        mysqli_report(MYSQLI_REPORT_STRICT);
        try 
        {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            //kiedy nie udało się połączyć
            if($polaczenie->connect_errno != 0)
            {
                //'throw new Exception' oznacza 'Rzuć nowym wyjątkiem
                throw new Exception(mysqli_connect_errno());
            }
            //kiedy udało się połączyć
            else 
            {
                //Sprawdzam, czy email jest w bazie
                $wynik = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
             
                //jeśli email będzie w bazie to zostanie wyrzucony wyjątek
                if(!$wynik) throw new Exception($polaczenie->error);
                
                $ile_takich_maili = $wynik->num_rows;
                if($ile_takich_maili>0)
                {
                    $Udana_Rejestracja = false;
                    $_SESSION['e_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
                }
                //Sprawdzam, czy nazwa użytkownika jest w bazie
                $wynik = $polaczenie->query("SELECT id FROM uzytkownicy WHERE BINARY uzytkownik='$uzytkownik'");
             
                if(!$wynik) throw new Exception($polaczenie->error);
                
                $ile_takich_userow = $wynik->num_rows;
                if($ile_takich_userow>0)
                {
                    $Udana_Rejestracja = false;
                    $_SESSION['e_user'] = "Ta nazwa użytkownika jest już zajęta!";
                }
                //Udana rejestracja!
                if($Udana_Rejestracja==true)
                {
                    if($polaczenie->query("INSERT INTO `uzytkownicy` (`id`, `uzytkownik`, `email`, `pass`, `created_at`, `updated_at`, `token`, `okres_weryfikacji`) 
                    VALUES (NULL, '$uzytkownik', '$email', '$haslo_hash', now(), now(), '$token', now() + INTERVAL 7 DAY)"))
                    {
                        $_SESSION['Zarejestrowany'] = true;
                        sendVerificationEmail($email, $token);
                        header('Location: Strona_Powitalna.php');
                    }
                    else
                    {
                        throw new Exception($polaczenie->error);
                    }

                }
         
                //zamykamy połączenie z bazą danych
                $polaczenie->close();
            }
        }
        //'catch' jest odpowiedzialny za złapanie "rzuconych" w klauzuli 'try' wyjątków
        catch(Exception $e) 
        {
            echo '<span style {color: red;}>Błąd serwera! Przepraszamy za utrudnienia i zapraszamy do rejestracji w innym terminie.</span>';
            echo "<br/>Informacja dla developera: ".$e;
        }
    }
?>