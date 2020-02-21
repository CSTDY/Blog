<!--Menu-->
<div class="wrapper">
    <nav class="flex-nav">
        <div class="logo_div">
        <a href="index.php" class="znacznikOut"><h4>Poradnik IT | Blog</a> <?php
                //sprawdzamy, czy wcześnie nie byliśmy zalogowani, jeśli tak to odsyłamy do strony 'Zalogowany.php'
                if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']))
                {
                    echo '<span class="zalogowany"><a href="WylogujSie.php">Wyloguj się</a></span><span class="zalogowany">Witaj '.$_SESSION['user'].'!</span>';             
                }     
            ?></h4>
        </div>
        <?php if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']) && (isset($_SESSION['info_o_weryfikacji'])) && ($_SESSION['info_o_weryfikacji'])) {
            echo $_SESSION['info_o_weryfikacji'];
        }
        ?>
        <a href="#" class="phone-nav znacznikOut">☰ Menu</a>
        <ul class=""> 
            <?php foreach ($tematy as $temat): ?>
                <?php for ($i = 1; $i <= $sqlcode; $i++) ?>
                        <li><a 
							href="<?php echo BASE_URL . 'filtrowane_artykuly.php?tytul=' . $temat['id'] ?>">
							<?php echo $temat['nazwa']; ?>
                        </a>
                        </li> 
			<?php endforeach ?>                         
            <li class="social"><a href="https://github.com/CSTDY" ><img src="static/obrazy/Git_icon.png" alt="GitHub"/></a></li>
        </ul>
    </nav>
</div>