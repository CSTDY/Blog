<?php
    require_once('config.php');
?>

<!--Import kodu z systemem rejestracji Rejestracja-system.php-->
<?php 
    require_once(ROOT_PATH.'/Includes/Rejestracja-system.php');
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <!-- Google Fonts -->
	    <link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Studenci IT | Dawka wiedzy w pigułce</title>
        <link rel="stylesheet" href="static/css/rejestracja.css"/>
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>
    <body>
        <main>
            <article>
                <div class="wrapper baner">
                <h2><a class="redirect" href="index.php">Powrót do strony głównej</a></h2>
                <form method="post">
                    <p>Nazwa użytkownika</p>
                    <input type="text" value= "<?php 
                        if(isset($_SESSION['saved_user']))
                        {
                            echo $_SESSION['saved_user'];
                            unset($_SESSION['saved_user']);
                        }
                    ?>" 
                    name="user"/>
                    <?php
                        if(isset($_SESSION['e_user']))
                        {
                            echo '<div id="error">'.$_SESSION['e_user'].'</div>';
                            unset($_SESSION['e_user']);
                        }
                    ?>
                    <p>Email</p>
                    <input type="text" value="<?php
                        if(isset($_SESSION['saved_email']))
                        {
                            echo $_SESSION['saved_email'];
                            unset($_SESSION['saved_email']);
                        }
                    ?>" name="email"/>
                    <?php
                        if(isset($_SESSION['e_email']))
                        {
                            echo '<div id="error">'.$_SESSION['e_email'].'</div>';
                            unset($_SESSION['e_email']);
                        }
                    ?>
                    <p>Hasło</p>
                    <input type="password" name="haslo1"/>
                    <?php
                        if(isset($_SESSION['e_password']))
                        {
                            echo '<div id="error">'.$_SESSION['e_password'].'</div>';
                            unset($_SESSION['e_password']);
                        }
                    ?>
                    <p>Powtórz hasło</p>
                    <input type="password" name="haslo2"/>
                    <br/><br/>
                    <!--w "checkboxach" klauzula 'checked' zaznacza go-->
                    <label>
                    <input type="checkbox" name="regulamin" <?php
                        if(isset($SESSION['saved_regulamin']))
                        {
                            echo "checked";
                            unset($_SESSION['saved_regulamin']);
                        }
                    ?>/> Akceptuję regulamin<br/><br/>
                    </label>
                    <?php
                        if(isset($_SESSION['e_regulamin']))
                        {
                            echo '<div id="error">'.$_SESSION['e_regulamin'].'</div>';
                            unset($_SESSION['e_regulamin']);
                        }    
                    ?>
                    <div class="g-recaptcha" data-badge="inline" data-sitekey="6Le1lsoUAAAAAMsowPJQDsFnzM5Tc5H0u6WCh6BD"></div>
                    <?php
                        if(isset($_SESSION['e_reCaptcha']))
                        {
                            echo '<div id="error">'.$_SESSION['e_reCaptcha'].'</div>';
                            unset($_SESSION['e_reCaptcha']);
                        }
                    ?>

                    <input class="btn" type="submit" value="Zarejestruj się"/>
                </form>
            </div>
        </article>
         <!--Footer-->
        <?php 
            require_once(ROOT_PATH.'/Includes/footer.php');
        ?>