<?php
    require_once('config.php');
?>

<?php
    if(!isset($_SESSION['Zarejestrowany']))
    {
        header('Location: index.php');
        exit();
    }
    else
        unset($_SESSION['Zarejestrowany']);
?>

<!DOCTYPE html>
<html lang="pl">
    <head>
        <!-- Google Fonts -->
	    <link href="https://fonts.googleapis.com/css?family=Averia+Serif+Libre|Noto+Serif|Tangerine" rel="stylesheet">
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="static/css/Strona_Powitalna.css" type="text/css"/>
    </head>
    <body>
        <div class="center-screen">
            <h4>Dziękuję za rejestrację!</h4>
            <h5>Życzę przyjenej lektury :)</h5>
            <a class="btn" href="index.php">Powrót do strony głównej</a>
        </div>
    </body>
</html>