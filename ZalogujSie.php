<?php
    //pozwoli na korzystanie z funkcji '$_SESSION'
    session_start();

    //ochrona, żeby nie dostać się do dokumentu 'Zalogowany.php' bez podania hasła lub nicku
    if((!isset($_POST['nick_log'])) || (!isset($_POST['haslo_log'])))
    {
        header('Location: index.php');
        exit();
    }

    //funkcja 'require_once' blokuje kilkukrotne wczytanie podanej po tej funkcji wartości
    require_once "connect.php";

    mysqli_report(MYSQLI_REPORT_STRICT);
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);

        if($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            $nick = $_POST['nick_log'];
            $haslo = $_POST['haslo_log'];
            
            //'htmlentities' pozwala zapisać np. '<p>' na stronie.
            //To znaczy nie zapisze tego jako znak zaczynającego się paragrafa a jako string (ciąg znaków)
            //'htmlentities' kożysta z encji html (więcej info w google ;), czyli zapisujemy nasz wyraz w postaci encji html
            $nick = htmlentities($nick, ENT_QUOTES, "UTF-8");

            //sprawdzamy, czy w kodzie SQL nie ma literówki
            //Funkcja 'mysql_real_escape_string' zapobiega wstrzykiwaniu kodu SQL
            //Czyli chroni przed dodawaniem kodu SQL np. do pola loginu lub hasła
            //klauzula 'BINARY' rozróżnia małe i duże litery
            if($wynik = $polaczenie->query(sprintf("SELECT * FROM uzytkownicy WHERE BINARY uzytkownik='%s'",
            mysqli_real_escape_string($polaczenie, $nick))))
            {
                //funkcja 'num_rows' zwraca wyniki, które wynikły z zapytania kodu SQL
                $liczba_userow = $wynik->num_rows;
                if($liczba_userow>0) {
                     //row (ang. wiersz), fetch (ang. pobierz, przynieś)
                    //metoda 'fetch_assoc' tworzy tablicę asocjacyjną, czyli do indeksów tablicy przypisujemy wartości tekstowe
                    //inaczej nazywana tablicą skojażeń
                    $row = $wynik->fetch_assoc();
                    if($row['rola'] == "Admin"){
                    if(password_verify($haslo, $row['pass']) ) {
                        $_SESSION['zalogowany_admin'] = true;
                        $_SESSION['user'] = $row['uzytkownik'];
                        $_SESSION['admin_id'] = $row['id'];
                        $_SESSION['wiadomosc'] = "Jesteś zalogowany";
                        $wynik->free();
                        header('Location: Admin/Panel-sterowania.php');
                    }
                    else {
                        $_SESSION['fail'] = $_SESSION['fail'] = '<span>Niepoprawny login lub hasło</span>';    
                        throw new Exception($polaczenie->error);
                    }
                }
                elseif ($row['rola'] == "Autor") {
                    if(password_verify($haslo, $row['pass']) ) {
                        $_SESSION['zalogowany_autor'] = true;
                        $_SESSION['user'] = $row['uzytkownik'];
                        $_SESSION['admin_id'] = $row['id'];
                        $_SESSION['wiadomosc'] = "Jesteś zalogowany";
                        $wynik->free();
                        header('Location: Admin/Panel-sterowania.php');
                    }
                    else {
                        $_SESSION['fail'] = $_SESSION['fail'] = '<span>Niepoprawny login lub hasło</span>';    
                        throw new Exception($polaczenie->error);
                    }
                }
                else {
                    if(password_verify($haslo, $row['pass']) ) {
                        $_SESSION['zalogowany'] = true;
                        $_SESSION['user'] = $row['uzytkownik'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['weryfikacja'] = $row['weryfikacja'];
                        $_SESSION['okres_weryfikacji'] = $row['okres_weryfikacji'];
                        $_SESSION['wiadomosc'] = "Jesteś zalogowany";
                        //sprawdzam, czy nastąpiła weryfikacja przez email oraz ile czasu zostało do usunięcia konta(jeśli jest brak weryfikacji)
                        //oraz kiedy wysłać kolejny link potwierdzający rejetrację
                        $dataczas = new DateTime();
                        $dataczas->format('Y-m-d H:i:s');
                        $koniec = DateTime::createFromFormat('Y-m-d H:i:s', $_SESSION['okres_weryfikacji']);
                        $roznica = $dataczas->diff($koniec);
                        $token = $row['token'];

                        if($dataczas<$koniec && !($_SESSION['weryfikacja']))
                        {
                            $_SESSION['info_o_weryfikacji'] = '<script> alert("Zweryfikuj swoje konto poprzez link, który otrzymałeś na adres: '.$_SESSION['email'].
                            '</br> Pozostało ci'.$roznica->format('%d dni, %h godz, %i min, %s sek').' na weryfikację!");</script>';
                        }
                        if($dataczas>$koniec && !($_SESSION['weryfikacja'])) 
                        {
                            $_SESSION['info_o_weryfikacji'] = '<script> alert("Określony czas na weryfikację minął! Twoje konto zostaje usunięte!");</script>';
                            $sql ="DELETE FROM uzytkownicy WHERE email =".$_SESSION['email'];
                            $polaczenie->query($sql);
                        }
                        if($dataczas>$koniec && ($_SESSION['weryfikacja']))
                        {
                            $_SESSION['weryfikacja'] = false;
                            sendVerificationEmail($_SESSION['email'], $token);
                            $_SESSION['info_o_weryfikacji'] = '<script> alert("Twoja weryfikacja konta wygasła '.$roznica->format('%d dni, %h godz, %i min, %s sek').
                            'temu!</br>W celu przedłużenia weryfikacji swojego konta proszę o potwierdzenie poprzez kliknięcie w link, który został wysłany na adres '.$_SESSION['email'].'");</script>';
                        }

                        $wynik->free();
                        header('Location: index.php');
                    }
                    else {
                        $_SESSION['fail'] = $_SESSION['fail'] = '<span>Niepoprawny login lub hasło</span>';    
                        throw new Exception($polaczenie->error);
                    }
                }
                }
                else {
                    $_SESSION['fail'] = '<span>Niepoprawny login lub hasło</span>';
                    throw new Exception($polaczenie->error);
                }
            }
        }
        $wynik->free();
    }
    catch(Exception $e) {
        echo "<br/>Informacja dla developera".$e;
        header('Location: index.php');
    }
?>
