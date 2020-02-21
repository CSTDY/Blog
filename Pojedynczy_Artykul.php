<?php  
	require_once('config.php'); 
	require_once(ROOT_PATH.'/Includes/public_functions.php'); 
	 
	if (isset($_GET['Article-slug'])) {
		$Article = getPost($_GET['Article-slug']);
    }
    else echo "<p style {color:red;}>Nie pobrano artykulu</p>";
?>
<?php require_once(ROOT_PATH.'/Includes/head-section.php'); 
require_once(ROOT_PATH.'/Includes/poj_artykul_functions.php');
?>
    <title>Studenci IT | <?php echo $Article['tytul'] ?></title>
	<link rel="stylesheet" href="static/css/glowny.css" />
	<link rel="stylesheet" href="static/css/Pojedynczy_Artykul.css"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="wrapper">
	<!-- Menu -->
		<?php include( ROOT_PATH . '/Includes/Menu.php'); ?>
	<!-- // Navbar -->
	
	<div class="zawartosc" >
		<!-- Page wrapper -->
		<div class="Article-wrapper">
			<!-- full Article div -->
			<div class="full-Article-div">
			<?php if ($Article['published'] == false): ?>
				<h2 class="Article-title">Ten artykuł nie został udostępniony!</h2>
			<?php else: ?>
				<h2 class="Article-title"><?php echo $Article['tytul']; ?></h2>
				<div class="Article-body-div">
					<?php echo html_entity_decode($Article['body']); ?>
				</div>
			<?php endif ?>
			</div>
			<!-- // full Article div -->
			
		</div>
		<!-- // Page wrapper -->

	</div>
	<!-- comments section -->
	<?php require_once(ROOT_PATH.'/Includes/Comment_section.php'); ?>
		</div>
		</div>
</div>
</div>
<!-- // content -->
	<footer>
        <p>&copy Kamil Socha <?php echo date('Y'); ?></p>
    </footer>
</main>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="static/js/main.js"></script>
</body>
</html>