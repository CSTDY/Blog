<?php  require_once('../config.php'); ?>
	<?php require_once(ROOT_PATH . '/Admin/Includes/admin_function.php'); ?>
	<?php require_once(ROOT_PATH . '/Admin/Includes/head_section.php'); ?>
	<title>IT Student | Panel sterowania</title>
</head>
<body>
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/Panel-sterowania.php' ?>">
				<h1>IT Student - Admin</h1>
			</a>
		</div>
		<?php if(((isset($_SESSION['zalogowany_admin'])) && ($_SESSION['zalogowany_admin'])) || ((isset($_SESSION['zalogowany_autor'])) && ($_SESSION['zalogowany_autor']))): ?>
			<div class="user-info">
				<span><?php echo $_SESSION['user'] ?></span> &nbsp; &nbsp; 
				<a href="<?php echo BASE_URL . '/WylogujSie.php'; ?>" class="btn">Wyloguj się</a>
			</div>
		<?php endif ?>
	</div>
	<div class="container dashboard">
		<h1>Witamy!</h1>
		<div class="statystyki">
			<a href="uzytkownicy.php" class="first">
				<span>Nowi użytkownicy</span>
				<span><?php countUsers(); ?></span> 
			</a>
			<a href="artykuly.php"> 
				<br/><span>Opublikowane artykuły</span>
				<span><?php countArticles() ?></span> 
			</a>
			<a>
				<br/><span>Opublikowane komentarze</span>
				<span><?php countComments() ?></span> 
			</a>
		</div>
		<br><br><br>
		<div class="buttons">
			<a href="uzytkownicy.php">Dodaj użytkownika</a>
			<a href="artykuly.php">Dodaj artykuł</a>
		</div>
	</div>
</body>
</html>