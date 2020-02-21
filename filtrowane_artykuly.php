<?php 
	require_once('config.php'); 
	require_once(ROOT_PATH.'/Includes/Public_Functions.php '); 

	//'tytul' pobieramy z pliku Public.Functions.php z funkcji 'getPostTopic($artykul_id)' 
	// Get posts under a particular topic
	if (isset($_GET['tytul'])) {
		$temat_id = $_GET['tytul'];
		$Articles = getPublishedPostsByTopic($temat_id);
	}
	else echo "Nie pobrano artykulu";
?>

<?php require_once(ROOT_PATH.'/Includes/head-section.php'); ?>
	<title>Studenci IT | Dawka wiedzy w pigułce</title>
	<link rel="stylesheet" href="static/css/glowny.css" />
</head>
<body>
<div class="wrapper">
<!-- Navbar -->
	<?php include( ROOT_PATH . '/Includes/Menu.php'); ?>
<!-- // Navbar -->
<!-- content -->
<div class="zawartosc">
	<h2 class="zawartosc-tytul">
		Articles on <u><?php echo getTopicNameById($temat_id); ?></u>
	</h2>
	<hr>
	<?php foreach ($Articles as $Article): ?>
		<div class="artykul" style="margin-left: 0px;">
			<img src="<?php echo BASE_URL . '/static/obrazy/' . $Article['image']; ?>" class="artykul_img" alt="">
			<a href="pojedynczy_artykul.php?Article-slug=<?php echo $Article['slug']; ?>">
				<div class="artykul_info">
					<h3><?php echo $Article['tytul'] ?></h3>
					<div class="info">
						<span><?php echo date("F j, Y ", strtotime($Article["created_at"])); ?></span>
						<span class="read_more">Read more...</span>
					</div>
				</div>
			</a>
		</div>
	<?php endforeach ?>
</div>
<!-- // content -->
</div>
<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->