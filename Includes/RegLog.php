<!--Rejestracja i logowanie-->
<div class="wrapper baner">
    <div class="cytat">
        <h2>Cytat dnia</h2>
        <p>
            Są dwa rodzaje pracy:<br/>
            przyjemna,która przynosi<br/>
            zmęczenie, i trudna, która<br/>
            przynosi nagrodę.<br/>
            <span>~Ali Ibn Abi Talib</span>
        </p>
        <a href="Rejestracja.php" class="btn">Dołącz do nas!</a>
    </div>
    <!--Logowanie-->
    <div class="LogIn">
        <form action="ZalogujSie.php" method="post">
            <h2>Logowanie</h2>
            <input type="text" name="nick_log" placeholder="User"/>
            <input type="password" name="haslo_log" placeholder="Hasło"/>
            <button type="submit" value="Zaloguj się" class="btn">Zaloguj się</button>
        </form>
    </div>
</div>
<?php
    
//funkcja 'isset' sprawdza, czy zmienna podana w jej środku istnieje w sesji (jest ustawiona)
    if(isset($_SESSION['fail'])) echo $_SESSION['fail'];
    //po odświeżeniu strony komunikat o niepoprawnym log lub pass nie pokaże się
    unset($_SESSION['fail']);
?>