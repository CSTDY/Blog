<?php
    require_once('config.php');
?>

<?php
    require_once(ROOT_PATH.'/Includes/Public_Functions.php');
?>

<?php
    $Articles = getPublishedArticles(); 
?>

<!-- Import kodu z pliku head-section.php-->
<?php 
    require_once(ROOT_PATH.'/Includes/head-section.php');
?>
<title>Studenci IT | Dawka wiedzy w pigułce</title>
<link rel="stylesheet" href="static/css/glowny.css" />
</head>
<body>
    <main>
        <article>
            <div class="wrapper">
                <!--Menu-->
                <?php 
                    require_once(ROOT_PATH.'/Includes/Menu.php');
                ?>
                <!--Strona powitalna-->
                <?php
                if(!(@isset($_SESSION['zalogowany'])) && !(@$_SESSION['zalogowany'])) 
                    require_once(ROOT_PATH.'/Includes/RegLog.php');
                ?>
                <div class="zawartosc">
                    <h4 class="zawartosc-tytul">Ostatnie artykuly</h4>
                    <hr>
                    <?php 

                    if(is_array($Articles)):    
                    foreach ($Articles as $Article): ?>
                    <div class="artykul">
                        <img src="<?php echo BASE_URL.'/static/obrazy/'.$Article['image']; ?>" class="artykul_img" alt="">

                        <?php if (isset($Article['temat']['nazwa'])): ?>
                            <a 
                                href="<?php echo BASE_URL . 'filtrowane_artykuly.php?tytul=' . $Article['temat']['id'] ?>"
                                class="btn kategorie">
                                <?php echo $Article['temat']['nazwa'] ?>
                            </a>
                        <?php endif ?>

                        <a href="pojedynczy_artykul.php?Article-slug=<?php echo $Article['slug']; ?>">
                        <div class="artykul_info">
                            <h3><?php echo $Article['tytul']; ?></h3>
                            <div class="info">
                                <span><?php echo date("F j, Y ", strtotime($Article["created_at"])); ?></span>
                                <span class="read_more">Read more...</span>
                            </div>
                        </div>
                        </a>
                    </div>
                <?php endforeach ?>  
                <?php endif ?>
            </h4>
        </div>

            </article>
 <!--Footer-->
 <?php 
    require_once(ROOT_PATH.'/Includes/footer.php');
 ?>