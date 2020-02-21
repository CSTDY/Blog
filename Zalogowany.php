<?php
    require_once('config.php');

    require_once('Public_Function.php');
?>

<?php
    //Sprawdzamy, czy użytkownik NIE jest zalogowany
    if(!isset($_SESSION['zalogowany']))
    {
        header('Location: index.php');
        exit();
    }
?>

<!-- Import kodu z pliku head-section.php-->
<?php 
    require_once(ROOT_PATH.'/Includes/head-section.php');
?>
        <title>Studenci IT | Dawka wiedzy w pigułce</title>
        <link rel="stylesheet" href="static/css/glowny.css" type="text/css"/>
    </head>
    <body>
    <main>
        <article>
            <div class="wrapper">
            <!--Menu-->
            <?php 
                require_once(ROOT_PATH.'/Includes/Menu.php');
            ?>
            <?php
                echo "<p>Witaj ".$_SESSION['user'].'![<a href="WylogujSie.php">Wyloguj się</a>]</p>';
            ?>
            </div>

            </article>
 <!--Footer-->
 <?php 
    require_once(ROOT_PATH.'/Includes/footer.php');
 ?>